<?php

namespace App\Http\Controllers\Pharmacy;

use App\Models\Order;
use App\Models\Company;
use App\Models\Medicine;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Models\PharmacyInventory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MedicineController extends Controller
{


    public function index()
    {
        // جلب الأدوية المتاحة فقط بناءً على حقل is_available
        $medicines = Medicine::with(['company', 'image'])
            ->where('is_available', true)
            ->get();
        $companies = Company::all();
        return view('pharmacy.medicine.index', compact('medicines', 'companies'));
    }


    public function order(Request $request)
    {
        $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $pharmacy = Auth::guard('pharmacy')->user();
        $medicine = Medicine::findOrFail($request->medicine_id);

        if (!$medicine->is_available) {
            return redirect()->back()->withErrors(['quantity' => 'الدواء غير متوفر حاليًا.']);
        }

        // إنشاء الطلب
        $order = Order::create([
            'orderable_id' => $pharmacy->id,
            'orderable_type' => Pharmacy::class,
            'destination_id' => $medicine->company_id,
            'destination_type' => Company::class,
            'order_status' => 'pending',
            'total' => $medicine->base_price * $request->quantity,
        ]);

        // تخزين تفاصيل الطلب
        $order->orderDetails()->create([
            'medicine_id' => $medicine->id,
            'quantity' => $request->quantity,
            'unit_price' => $medicine->base_price,
            'subtotal' => $medicine->base_price * $request->quantity,
        ]);

        return redirect()->route('pharmacy.medicine.index')->with('success', 'تم إرسال الطلب بنجاح!');
    }
}
