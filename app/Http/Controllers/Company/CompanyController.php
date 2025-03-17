<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{

    public function profile()
    {
        $company = auth('company')->user();
        return view('company.profile', compact('company'));
    }


    public function updateProfile(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'current-password' => 'required_with:password|current_password:company', // التحقق من كلمة المرور الحالية
            'password' => 'nullable|min:8|confirmed',
            'image' => 'sometimes|image|max:2048', // صورة بحد أقصى 2MB
        ], [
            'current-password.current_password' => 'كلمة المرور الحالية غير صحيحة.',
            'password.confirmed' => 'كلمة المرور وتأكيدها غير متطابقتين.',
            'image.image' => 'الملف المحدد ليس صورة.',
            'image.max' => 'حجم الصورة لا يجب أن يزيد عن 2 ميجابايت.',
        ]);

        try {



            /** @var Company $company  */
            // جلب الصيدلية الحالية
            $company = auth('company')->user();

            if (!$company) {
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
            $company->update($data);

            // معالجة الصورة إذا تم رفعها
            if ($request->hasFile('image')) {
                // حذف الصورة القديمة إذا كانت موجودة
                if ($company->image) {
                    Storage::disk('public')->delete('company/' . $company->image->path);
                    $company->image()->delete();
                }

                // رفع الصورة الجديدة
                $imgName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('company', $imgName, 'public');

                // إنشاء سجل جديد في جدول images باستخدام العلاقة المورفية
                $company->image()->create([
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
        Auth::guard('company')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('msg', 'تم تسجيل الخروج بنجاح!');
    }


}
