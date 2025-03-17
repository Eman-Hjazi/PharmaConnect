<?php

namespace App\Http\Controllers\Pharmacy\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy;
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
        return view('pharmacy.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Pharmacy::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $pharmacy = Pharmacy::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'description' => $request->description,
        ]);

        //Add image to relation
        if ($request->hasFile('image')) {
            // رفع الصورة إلى مجلد في التخزين
            $imagePath = $request->file('image')->store('pharmacy', 'public');

            // إنشاء سجل في جدول الصور باستخدام العلاقة Morph
            $pharmacy->image()->create([
                'path' => $imagePath,
            ]);
        }

        event(new Registered($pharmacy));

        Auth::guard('pharmacy')->login($pharmacy);

        return redirect(route('pharmacy.dashboard', absolute: false));
    }
}
