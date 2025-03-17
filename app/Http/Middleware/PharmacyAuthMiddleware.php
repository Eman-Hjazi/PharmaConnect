<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PharmacyAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!Auth::guard('pharmacy')->check()) {
            return redirect()->route('pharmacy.login'); // توجيه إلى صفحة تسجيل الدخول إذا لم يكن مصادقًا
        }
        return $next($request);
    }
}
