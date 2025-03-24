<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PharmacyInventory;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'prescription' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user(); // المستخدم اللي بيعمل الطلب
        $cartItems = $user->carts;
        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'السلة فارغة'], 400);
        }

        // تجميع المنتجات حسب الصيدلية
        $itemsByPharmacy = $cartItems->groupBy(function ($item) {
            return $item->pharmacyInventory->pharmacy_id;
        });

        // رفع الروشتة مرة واحدة
        $prescriptionPath = $request->file('prescription')->store('orders', 'public');

        // إنشاء طلب لكل صيدلية
        foreach ($itemsByPharmacy as $pharmacyId => $items) {
            $pharmacy = $items->first()->pharmacyInventory->pharmacy;

            // إنشاء الطلب
            $order = Order::create([
                'orderable_id' => $user->id,
                'orderable_type' => get_class($user), // App\Models\User
                'destination_id' => $pharmacy->id,
                'destination_type' => get_class($pharmacy), // App\Models\Pharmacy
                'order_status' => 'pending',
                'total' => $items->sum(fn($item) => $item->quantity * $item->pharmacyInventory->selling_price),
            ]);

            // إضافة تفاصيل الطلب
            foreach ($items as $item) {
                $order->orderDetails()->create([
                    'medicine_id' => $item->pharmacyInventory->medicine_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->pharmacyInventory->selling_price,
                    'subtotal' => $item->quantity * $item->pharmacyInventory->selling_price,
                ]);
            }

            // ربط الروشتة بالطلب في جدول images
            $order->image()->create([
                'path' => $prescriptionPath,
            ]);
        }

        // حذف عناصر السلة بعد الطلب
        $user->carts()->delete();

        return response()->json(['success' => true, 'message' => 'تم تقديم الطلبات بنجاح!']);
    }


}
