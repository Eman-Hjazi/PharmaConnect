<?php

namespace App\Http\Controllers\Company\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('company.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // التحقق من البيانات مع إضافة حقل الصورة
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Company::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // تحقق من الصورة
        ]);

        // إنشاء الشركة
        $company = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // التعامل مع رفع الصورة
        if ($request->hasFile('image')) {
            // رفع الصورة إلى مجلد في التخزين
            $imagePath = $request->file('image')->store('company', 'public');

            // إنشاء سجل في جدول الصور باستخدام العلاقة Morph
            $company->image()->create([
                'path' => $imagePath,
            ]);
        }
        // إطلاق حدث التسجيل
        event(new Registered($company));

        // تسجيل دخول الشركة باستخدام الـ guard الصحيح
        Auth::guard('company')->login($company);

        // إعادة التوجيه إلى لوحة التحكم
        return redirect(route('company.dashboard', absolute: false));
    }
}
