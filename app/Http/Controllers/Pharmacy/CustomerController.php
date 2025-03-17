<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function create()
    {
        return view('pharmacy.customers.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('pharmacy.customers.index')->with('success', 'تم إضافة العميل بنجاح!');
    }

    public function index()
    {
        $pharmacy = auth('pharmacy')->user();
        if (!$pharmacy) {
            return redirect()->route('pharmacy.login')->with('error', 'يرجى تسجيل الدخول أولاً.');
        }

        // استرجاع العملاء الذين أرسلوا طلبات إلى الصيدلية
        $customers = User::whereIn('id', function ($query) use ($pharmacy) {
            $query->select('orderable_id')
                  ->from('orders')
                  ->where('orderable_type', 'App\Models\User')
                  ->where('destination_id', $pharmacy->id)
                  ->where('destination_type', 'App\Models\Pharmacy');
        })->paginate(10);

        return view('pharmacy.customers.index', compact('customers'));
    }
}
