<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\Order;
use App\Models\Medicine;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\PharmacyInventory;
use Flasher\Prime\FlasherInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PharmacyController extends Controller
{


    public function profile()
    {
        $pharmacy = auth('pharmacy')->user();
        return view('pharmacy.profile', compact('pharmacy'));
    }

    public function storeOrder(Request $request, FlasherInterface $flasher)
    {
        $pharmacy = auth('pharmacy')->user(); // جلب الصيدلية

        // التحقق من صحة البيانات
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            // جلب بيانات الدواء
            $medicine = Medicine::findOrFail($request->medicine_id);
            $totalPrice = $medicine->price * $request->quantity;

            // إنشاء الطلب الرئيسي
            $order = Order::create([
                'orderable_id' => $pharmacy->id,
                'orderable_type' => 'App\Models\Pharmacy',
                'destination_id' => $medicine->company->id,
                'destination_type' => 'App\Models\Company',
                'order_status' => 'pending',
                'total' => $totalPrice,
            ]);

            // إضافة تفاصيل الطلب
            OrderDetail::create([
                'order_id' => $order->id,
                'medicine_id' => $medicine->id,
                'quantity' => $request->quantity,
                'price' => $medicine->price,
                'total' => $totalPrice,
            ]);


            $flasher->success('تم إرسال الطلب بنجاح!');
        } catch (\Exception $e) {
            $flasher->error('حدث خطأ أثناء إرسال الطلب: ' . $e->getMessage());
        }

        return redirect()->back();
    }


    // عرض المخزون لصيدلية معينة
    public function showInventory($pharmacyId)
    {
        // جلب المخزون للصيدلية المحددة
        $inventory = PharmacyInventory::where('pharmacy_id', $pharmacyId)
            ->with('medicine') // جلب معلومات الدواء المرتبطة
            ->get();

        // إعادة توجيه إلى العرض مع البيانات
        return view('pharmacy.medicine.inventory-list', compact('inventory'));
    }


    public function updateProfile(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'current-password' => 'required_with:password|current_password:pharmacy', // التحقق من كلمة المرور الحالية
            'password' => 'nullable|min:8|confirmed',
            'image' => 'sometimes|image|max:2048', // صورة بحد أقصى 2MB
        ], [
            'current-password.current_password' => 'كلمة المرور الحالية غير صحيحة.',
            'password.confirmed' => 'كلمة المرور وتأكيدها غير متطابقتين.',
            'image.image' => 'الملف المحدد ليس صورة.',
            'image.max' => 'حجم الصورة لا يجب أن يزيد عن 2 ميجابايت.',
        ]);

        try {



            /** @var Pharmacy $pharmacy  */
            // جلب الصيدلية الحالية
            $pharmacy = auth('pharmacy')->user();

            if (!$pharmacy) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم العثور على الصيدلية.'
                ], 404);
            }

            // بيانات التحديث
            $data = [
                'name' => $request->name,
            ];

            // تحديث كلمة المرور إذا تم إرسالها
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            // تحديث بيانات الصيدلية
            $pharmacy->update($data);

            // معالجة الصورة إذا تم رفعها
            if ($request->hasFile('image')) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($pharmacy->image) {
                    Storage::disk('public')->delete('pharmacy/' . $pharmacy->image->path);
                    $pharmacy->image()->delete();
                }

                // رفع الصورة الجديدة
                $imgName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('pharmacy', $imgName, 'public');

                // إنشاء سجل جديد في جدول images باستخدام العلاقة المورفية
                $pharmacy->image()->create([
                    'path' => $imgName,
                ]);
            }

            // إرجاع الرد باستخدام SweetAlert
            return response()->json([
                'success' => true,
                'message' => 'تم تحديث الملف الشخصي بنجاح!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الملف الشخصي: ' . $e->getMessage()
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        Auth::guard('pharmacy')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('msg', 'تم تسجيل الخروج بنجاح!');
    }
}
