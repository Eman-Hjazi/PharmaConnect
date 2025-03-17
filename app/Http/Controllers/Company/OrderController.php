<?php

namespace App\Http\Controllers\Company;

use App\Models\Order;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Models\PharmacyInventory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{


    public function index(){
        $company_id =auth('company')->user()->id;

        $orders=Order::with(['orderable', 'destination'])
                ->where('destination_type', 'App\Models\Company')
                ->where('destination_id', $company_id)

                ->orderBy('created_at', 'desc')
                ->get();

                return view('company.orders.index',compact('orders'));
    }
    function show($id)
    {


        // جلب بيانات الطلب مع العلاقات
        $order = Order::with(['orderable', 'destination', 'orderDetails.medicine'])
            ->findOrFail($id);

        // جلب تفاصيل الأدوية
        $orderDetails = $order->orderDetails;

        // إرجاع البيانات إلى الواجهة
        return view('company.orders.show', compact('order', 'orderDetails'));
    }


    // public function updateStatus(Request $request, $id)
    // {
    //     $order = Order::findOrFail($id);

    //     // لا يمكن تحديث الحالة إذا كان مكتملًا أو ملغيًا
    //     if (in_array($order->order_status, ['completed', 'canceled'])) {
    //         return response()->json(['success' => false, 'message' => 'لا يمكن تحديث الطلب بعد اكتماله أو إلغائه.'], 403);
    //     }

    //     // تحديث الحالة
    //     $order->update(['order_status' => $request->status]);

    //     return response()->json(['success' => true, 'message' => 'تم تحديث حالة الطلب بنجاح.']);
    // }


//     public function updateStatus(Request $request, $id){

//     try {
//         $order = Order::with('orderDetails.medicine')->findOrFail($id);

//         // لا يمكن تحديث الحالة إذا كان مكتملًا أو ملغيًا
//         if (in_array($order->order_status, ['completed', 'canceled'])) {
//             return response()->json(['success' => false, 'message' => 'لا يمكن تحديث الطلب بعد اكتماله أو إلغائه.'], 403);
//         }

//         // التحقق من المدخلات
//         $request->validate([
//             'status' => 'required|in:pending,processing,completed,canceled',
//         ]);

//         // تحديث الحالة
//         $order->update(['order_status' => $request->status]);

//         Log::info('Order status updated to: ' . $request->status . ' for order ID: ' . $id);

//         // إذا أصبح الطلب مكتمل، قم بتحديث المخزون
//         if ($request->status === 'completed') {
//             if ($order->orderDetails->isEmpty()) {
//                 Log::warning('No order details found for order ID: ' . $id);
//                 return response()->json(['success' => false, 'message' => 'لا يوجد تفاصيل للطلب لتحديث المخزون.'], 400);
//             }

//             $pharmacyId = $order->orderable_id; // للحصول على pharmacy_id من orderable (Polymorphic)
//             if (!$pharmacyId || !in_array(get_class($order->orderable), [Pharmacy::class])) {
//                 Log::error('Invalid pharmacy_id for order ID: ' . $id);
//                 return response()->json(['success' => false, 'message' => 'لا يمكن تحديد الصيدلية المرتبطة.'], 400);
//             }

//             foreach ($order->orderDetails as $item) {
//                 if (!$item->medicine) {
//                     Log::error('Medicine not found for order detail ID: ' . $item->id);
//                     continue;
//                 }

//                 $inventory = PharmacyInventory::updateOrCreate(
//                     ['pharmacy_id' => $pharmacyId, 'medicine_id' => $item->medicine_id],
//                     [
//                         'quantity_in_stock' => \DB::raw("quantity_in_stock + {$item->quantity}"),
//                         'selling_price' => $item->unit_price ?? 0,
//                         'expiry_date' => $item->expiry_date ?? null,
//                         'status' => $item->quantity <= 0 ? 'نفذ' :
//                             ($item->quantity <= 10 ? 'قليل' : 'متوفر'),
//                         'alert_threshold' => 10,
//                     ]
//                 );

//                 if ($inventory->wasRecentlyCreated) {
//                     Log::info('New inventory created for medicine ID: ' . $item->medicine_id);
//                 } else {
//                     Log::info('Inventory updated for medicine ID: ' . $item->medicine_id);
//                 }
//             }
//         }

//         return response()->json(['success' => true, 'message' => 'تم تحديث حالة الطلب بنجاح.']);
//     } catch (\Exception $e) {
//         Log::error('Error in updateStatus: ' . $e->getMessage());
//         return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء معالجة الطلب.'], 500);
//     }

// }




public function updateStatus(Request $request, $id)
{
    try {
        $order = Order::with('orderDetails.medicine', 'orderable')->findOrFail($id);

        // لا يمكن تحديث الحالة إذا كان مكتملًا أو ملغيًا
        if (in_array($order->order_status, ['completed', 'canceled'])) {
            return response()->json(['success' => false, 'message' => 'لا يمكن تحديث الطلب بعد اكتماله أو إلغائه.'], 403);
        }

        // التحقق من المدخلات
        $request->validate([
            'status' => 'required|in:pending,processing,completed,canceled',
        ]);

        // استخدام معاملة لضمان الاتساق
        return DB::transaction(function () use ($order, $request, $id) {
            // إذا كانت الحالة الجديدة هي "completed"، تحقق من المخزون أولاً
            if ($request->status === 'completed') {
                if ($order->orderDetails->isEmpty()) {
                    Log::warning('No order details found for order ID: ' . $id);
                    throw new \Exception('لا يوجد تفاصيل للطلب لتحديث المخزون.');
                }

                   $pharmacyId = $order->orderable_id; // للحصول على pharmacy_id من orderable (Polymorphic)
            if (!$pharmacyId || !in_array(get_class($order->orderable), [Pharmacy::class])) {
                Log::error('Invalid pharmacy_id for order ID: ' . $id);
                return response()->json(['success' => false, 'message' => 'لا يمكن تحديد الصيدلية المرتبطة.'], 400);
            }

                // تحديث المخزون
                foreach ($order->orderDetails as $item) {
                    if (!$item->medicine) {
                        Log::error('Medicine not found for order detail ID: ' . $item->id);
                        throw new \Exception('لم يتم العثور على الدواء لأحد تفاصيل الطلب.');
                    }

                    $inventory = PharmacyInventory::updateOrCreate(
                        ['pharmacy_id' => $pharmacyId, 'medicine_id' => $item->medicine_id],
                        [
                            'quantity_in_stock' => DB::raw("quantity_in_stock + {$item->quantity}"),
                            'selling_price' => $item->unit_price ?? 0,
                            'expiry_date' => $item->expiry_date ?? null,
                            'status' => $item->quantity <= 0 ? 'نفذ' :
                                ($item->quantity <= 10 ? 'قليل' : 'متوفر'),
                            'alert_threshold' => 10,
                        ]
                    );

                    if ($inventory->wasRecentlyCreated) {
                        Log::info('New inventory created for medicine ID: ' . $item->medicine_id);
                    } else {
                        Log::info('Inventory updated for medicine ID: ' . $item->medicine_id);
                    }
                }
            }

            // إذا نجح تحديث المخزون (أو لم يكن هناك حاجة لتحديثه)، قم بتحديث حالة الطلب
            $order->update(['order_status' => $request->status]);
            Log::info('Order status updated to: ' . $request->status . ' for order ID: ' . $id);

            return response()->json(['success' => true, 'message' => 'تم تحديث حالة الطلب بنجاح.']);
        });
    } catch (\Exception $e) {
        Log::error('Error in updateStatus: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
    }
}
}
