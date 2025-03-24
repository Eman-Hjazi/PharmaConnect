<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('frontend.login'); // ده شغال زي ما هو
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $credentials = $request->only('email', 'password');

    //     // محاولة تسجيل الدخول كصيدلية
    //     if (Auth::guard('pharmacy')->attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return redirect()->intended(route('pharmacy.dashboard')); // توجيه لداشبورد الصيدلية
    //     }

    //     // محاولة تسجيل الدخول كمستخدم عادي
    //     if (Auth::guard('web')->attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return redirect()->intended(route('home')); // توجيه للصفحة الرئيسية
    //     }

    //     // لو فشل الاثنين، ارجع خطأ
    //     return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة']);
    // }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        // محاولة تسجيل الدخول كصيدلية
        if (Auth::guard('pharmacy')->attempt($credentials)) {
            $request->session()->regenerate();
            // dd("Logged in as pharmacy"); // هنا هيوقف ويظهر رسالة لو نجح
            return redirect()->route('pharmacy.dashboard');
        }

        // محاولة تسجيل الدخول كمستخدم عادي
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            //dd("Logged in as web user"); // هنا كمان
            return redirect()->intended(route('home'));
        }

        // لو فشل
        dd("Login failed"); // هيظهر لو الاثنين فشلوا
        return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة']);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // التحقق من أي guard مسجل وتسجيل الخروج منه
        if (Auth::guard('pharmacy')->check()) {
            Auth::guard('pharmacy')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
