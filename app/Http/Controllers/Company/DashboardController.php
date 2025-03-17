<?php
namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\Medicine;

class DashboardController extends Controller
{
    public function index()
    {

        $company_id =auth('company')->user()->id;

            // استرداد عدد الطلبات الجديدة
            $newOrders = Order::where('destination_id', $company_id)
            ->where('order_status', 'pending')->count();


            // استرداد عدد الصيدليات المسجلة
            $pharmacies = Pharmacy::count();


            // استرداد عدد الأدوية المتوفرة
            $availableMedicines = Medicine::where('is_available', true)
            ->where('company_id', $company_id)
            ->count();

            // استرداد إجمالي المبيعات (اليوم وأمس)
            $totalSales = Order::where('order_status', 'completed')
                ->where('destination_type', 'App\Models\Company')
                ->where('destination_id', $company_id)
                ->whereDate('created_at', Carbon::today())
                ->sum('total');


            // استرداد آخر 10 طلبات
            $recentOrders = Order::with(['orderable', 'destination'])
                ->where('destination_type', 'App\Models\Company')
                ->where('destination_id', $company_id)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();




        return view('company.dashboard', compact('newOrders',
'pharmacies',
'availableMedicines',
'totalSales',
'recentOrders'));
    }
}
