<?php
namespace App\Http\Controllers\Pharmacy;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\PharmacyInventory;
use App\Models\Pharmacy; // أضف هذا للاستخدام
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        $pharmacy = auth()->guard('pharmacy')->user();
        $pharmacyId = $pharmacy->id;
        $image = $pharmacy->image;

        // إجمالي الطلبات الواردة إلى الصيدلية من المستخدمين
        $totalOrders = Order::where('destination_type', Pharmacy::class)
                            ->where('destination_id', $pharmacyId)
                            ->count();

        // الطلبات قيد الانتظار الواردة إلى الصيدلية
        $pendingOrders = Order::where('destination_type', Pharmacy::class)
                              ->where('destination_id', $pharmacyId)
                              ->where('order_status', 'pending')
                              ->count();

        // عدد الأدوية منخفضة المخزون للصيدلية
        $lowStockCount = PharmacyInventory::where('pharmacy_id', $pharmacyId)
                                          ->where('quantity_in_stock', '<', 10)
                                          ->count();

        // جلب الأدوية منخفضة المخزون مع تفاصيل الدواء
        $lowStockMedicines = PharmacyInventory::where('pharmacy_id', $pharmacyId)
                                              ->where('quantity_in_stock', '<', 10)
                                              ->with('medicine')
                                              ->get();

        // إجمالي الإيرادات من الطلبات المكتملة الواردة
        $totalRevenue = Order::where('destination_type', Pharmacy::class)
                             ->where('destination_id', $pharmacyId)
                             ->where('order_status', 'completed')
                             ->sum('total');

        // عدد الطلبات في الشهر الماضي
        $lastMonthOrders = Order::where('destination_type', Pharmacy::class)
                                ->where('destination_id', $pharmacyId)
                                ->where('created_at', '>=', Carbon::now()->subMonth())
                                ->count();
        $ordersPercentageIncrease = $lastMonthOrders > 0 ? (($totalOrders - $lastMonthOrders) / $lastMonthOrders) * 100 : 0;

        // الإيرادات في الشهر الماضي
        $lastMonthRevenue = Order::where('destination_type', Pharmacy::class)
                                 ->where('destination_id', $pharmacyId)
                                 ->where('order_status', 'completed')
                                 ->where('created_at', '>=', Carbon::now()->subMonth())
                                 ->sum('total');
        $revenuePercentageIncrease = $lastMonthRevenue > 0 ? (($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;

        // عدد الطلبات الجديدة اليوم
        $todayOrders = Order::where('destination_type', Pharmacy::class)
                            ->where('destination_id', $pharmacyId)
                            ->whereDate('created_at', Carbon::today())
                            ->count();

        // جلب آخر 5 طلبات واردة
        $recentOrders = Order::where('destination_type', Pharmacy::class)
                             ->where('destination_id', $pharmacyId)
                             ->with('orderable')
                             ->orderBy('created_at', 'desc')
                             ->take(5)
                             ->get();

        return view('Pharmacy.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'lowStockMedicines',
            'totalRevenue',
            'ordersPercentageIncrease',
            'revenuePercentageIncrease',
            'todayOrders',
            'recentOrders',
            'lowStockCount'
        ));
    }
}
