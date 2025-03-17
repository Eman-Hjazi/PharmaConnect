<?php

namespace App\Http\Controllers\Company;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Models\MedicineCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MedicineController extends Controller
{

    public function index()
    {
        // جلب الأدوية التي تنتجها الشركة المسجلة دخولها باستخدام العلاقة
        $company = auth('company')->user(); // الحصول على الشركة المسجلة دخولها
        $medicines = $company->medicines()->with('category')->paginate(12);

        // جلب الفئات لعرضها في الفلترة (إذا لزم الأمر)
        $categories = MedicineCategory::all();

        return view('company.medicines.index', compact('medicines', 'categories'));
    }







    public function store(Request $request)
    {
        try {
            // التحقق من أن المستخدم مسجل دخول باستخدام Guard 'company'
            if (!auth('company')->check()) {
                throw new \Exception('يجب تسجيل الدخول كشركة لإضافة دواء.');
            }

            // التحقق من البيانات مع قاعدة التحقق الصحيحة لـ company_id
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'base_price' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'medicine_category_id' => 'required|exists:medicine_categories,id',
                'expiry_date' => 'nullable|date',
                'is_available' => 'required|boolean',
                'is_controlled' => 'required|boolean',
                'image' => 'nullable|image|max:2048',

            ]);

            // تعيين company_id يدويًا بناءً على المستخدم المصادق
            $validatedData['company_id'] = auth('company')->user()->id;


            // إنشاء الدواء
            $medicine = Medicine::create($validatedData);

            // معالجة الصورة إذا كانت موجودة
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('medicines', 'public'); // تخزين الصورة في storage/app/public/medicines
                $medicine->image()->create([
                    'path' => $imagePath,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'تم إضافة الدواء بنجاح!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء الإضافة: ' . $e->getMessage()], 500);
        }

    }


    public function edit($id)
    {
        $medicine = Medicine::with('category', 'image')->findOrFail($id);
        return response()->json([
            'success' => true,
            'medicine' => $medicine
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            // التحقق من البيانات المدخلة مع إضافة قواعد التحقق للصورة
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'base_price' => 'required|numeric',
                'description' => 'nullable|string',
                'medicine_category_id' => 'required|exists:medicine_categories,id',
                'expiry_date' => 'nullable|date',
                'is_available' => 'required|boolean',
                'is_controlled' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // قواعد التحقق للصورة
            ]);

            // جلب الدواء من قاعدة البيانات
            $medicine = Medicine::findOrFail($id);

            // تحديث بيانات الدواء الأساسية
            $medicine->update($validated);

            // التحقق مما إذا تم رفع صورة جديدة
            if ($request->hasFile('image')) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($medicine->image) {
                    // حذف الملف من التخزين
                    Storage::disk('public')->delete($medicine->image->path);
                    // حذف السجل من قاعدة البيانات
                    $medicine->image->delete();
                }

                // حفظ الصورة الجديدة في مجلد 'medicines' داخل التخزين العام
                $imagePath = $request->file('image')->store('medicines', 'public');

                // إنشاء سجل جديد للصورة في جدول الصور
                $medicine->image()->create([
                    'path' => $imagePath,
                ]);
            }

            // إرجاع استجابة ناجحة مع بيانات الدواء المحدثة
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الدواء بنجاح',
                'medicine' => $medicine->fresh()
            ]);
        } catch (\Throwable $e) {
            // إرجاع استجابة فاشلة مع تفاصيل الخطأ
            return response()->json([
                'success' => false,
                'message' => 'خطأ: ' . $e->getMessage(),
                'trace' => $e->getTrace()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $medicine = Medicine::findOrFail($id);
            $medicine->delete();

            return response()->json(['success' => true, 'message' => 'تم حذف الدواء بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء الحذف: ' . $e->getMessage()], 500);
        }
    }
}
