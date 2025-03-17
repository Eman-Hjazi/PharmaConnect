<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PharmacyInventory;
use App\Models\User; // استيراد النموذج User بشكل صحيح
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Flasher\Laravel\Facade\Flasher;

class OrderController extends Controller
{
    public function index() {}

    public function create() {}

    public function show() {}

    public function sentOrders()
    {
        // استرجاع الطلبات المرسلة من الصيدلية المرتبطة بالمستخدم الحالي
        $orders = Order::where('orderable_id', auth('pharmacy')->user()->id)
            ->where('orderable_type', 'App\Models\Pharmacy')
            ->with('orderDetails.medicine')
            ->paginate(10);

        return view('pharmacy.orders.sent-orders', compact('orders'));
    }

    public function customerOrder()
    {
        // استرجاع الطلبات التي أرسلها المستخدمون إلى الصيدلية الحالية
        $orders = Order::where('destination_id', auth('pharmacy')->user()->id)
            ->where('destination_type', 'App\Models\Pharmacy')
            ->where('orderable_type', 'App\Models\User')
            ->with('orderDetails.medicine')
            ->paginate(10);

        return view('pharmacy.orders.customer-orders', compact('orders'));
    }

    // Update order status via AJAX
    public function updateStatus(Request $request, $id)
    {
        try {
            $pharmacy = auth('pharmacy')->user();
            $order = Order::where('destination_id', $pharmacy->id)
                ->where('destination_type', 'App\Models\Pharmacy')
                ->with(['orderDetails' => function ($query) {
                    $query->select('id', 'order_id', 'medicine_id', 'quantity');
                }, 'orderDetails.medicine' => function ($query) {
                    $query->select('id', 'name');
                }])
                ->findOrFail($id);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'الطلب غير موجود أو لا يخص هذه الصيدلية'
                ], 403);
            }

            // Validate request
            $request->validate([
                'status' => 'required|in:pending,processing,completed,canceled'
            ]);

            $newStatus = $request->status;

            // Check if status change is allowed
            if (in_array($order->order_status, ['completed', 'canceled'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن تغيير حالة الطلب بعد اكتماله أو إلغائه'
                ], 403);
            }

            // Handle stock update for completed status
            if ($newStatus === 'completed') {
                DB::beginTransaction();

                foreach ($order->orderDetails as $detail) {
                    // Check if the medicine exists in the pharmacy's inventory
                    $inventory = $pharmacy->inventories()
                        ->where('medicine_id', $detail->medicine_id)
                        ->first();

                    if (!$inventory) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => "الدواء: {$detail->medicine->name} غير متوفر في مخزون الصيدلية. يرجى طلب الدواء من شركة الأدوية أولاً."
                        ], 400);
                    }

                    if ($inventory->quantity_in_stock < $detail->quantity) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => "مخزون غير كافٍ للدواء: {$detail->medicine->name}"
                        ], 400);
                    }

                    // Update stock
                    $inventory->quantity_in_stock -= $detail->quantity;
                    $inventory->save();

                    // Update status based on quantity
                    $inventory->status = ($inventory->quantity_in_stock <= $inventory->alert_threshold) ? 'قليل' : 'متوفر';
                    if ($inventory->quantity_in_stock <= 0) {
                        $inventory->status = 'نفذ';
                    }
                    $inventory->save();
                }

                DB::commit();
            }

            // Handle stock return for canceled status
            if ($newStatus === 'canceled') {
                DB::beginTransaction();

                foreach ($order->orderDetails as $detail) {
                    $inventory = $pharmacy->inventories()
                        ->where('medicine_id', $detail->medicine_id)
                        ->first();

                    if (!$inventory) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => "الدواء: {$detail->medicine->name} غير متوفر في مخزون الصيدلية"
                        ], 400);
                    }

                    $inventory->quantity_in_stock += $detail->quantity;
                    $inventory->save();

                    // Update status based on quantity
                    $inventory->status = ($inventory->quantity_in_stock <= $inventory->alert_threshold) ? 'قليل' : 'متوفر';
                    $inventory->save();
                }

                DB::commit();
            }

            // Update order status
            $order->order_status = $newStatus;
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث حالة الطلب بنجاح'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تحديث الحالة: ' . $e->getMessage()
            ], 500);
        }
    }
}
