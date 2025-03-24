<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Models\MedicineCategory;
use App\Models\PharmacyInventory;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{




    public function index()
    {
        $pharmacies = Pharmacy::with('image')->get();


        return view('frontend.index', compact('pharmacies'));
    }

    public function getPharmaciesByLocation($location)
    {
        $pharmacies = $location === 'all'
            ? Pharmacy::with('image')->get()
            : Pharmacy::with('image')
            ->where(function ($query) use ($location) {
                $query->where('address', 'like', $location . '%')
                    ->orWhere('address', 'like', $location . ',%');
            })
            ->get();

        $html = view('frontend.partials.pharmacy-cards', compact('pharmacies'))->render();
        return response()->json(['html' => $html]);
    }


    public function show($id)
    {
        $pharmacy = Pharmacy::with('image')->findOrFail($id);
        $categories = MedicineCategory::all(); // جلب جميع الفئات
        return view('frontend.pharma', compact('pharmacy', 'categories'));
    }



    function checkAuth()
    {
        return response()->json(['authenticated' => Auth::check()]);
    }


    function ask()
    {
        return view('frontend.ask');
    }


    function policies(){
        return view('frontend.pharma-policies');
    }




    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $category = $request->input('category', '');
        $sort = $request->input('sort', 'asc');

        // بناء الاستعلام الأساسي
        $inventoriesQuery = PharmacyInventory::whereHas('medicine', function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%");
        })
            ->whereIn('status', ['متوفر', 'قليل'])
            ->with(['medicine', 'pharmacy', 'medicine.category']);

        // تصفية حسب الفئة إذا تم اختيارها
        if ($category) {
            $inventoriesQuery->whereHas('medicine.category', function ($q) use ($category) {
                $q->where('id', $category);
            });
        }

        // جلب البيانات
      $inventories = $inventoriesQuery->orderBy('selling_price', $sort)->get();

        // جلب الفئات للتصفية
        $categories = MedicineCategory::all();

        // إذا كان الطلب من نوع AJAX، نرجع JSON
        if ($request->ajax()) {
            return response()->json([
                'inventories' => $inventories->map(function ($inventory) {
                    return [
                        'medicine' => [
                            'name' => $inventory->medicine->name,
                            'image' => $inventory->medicine->image ? ['path' => $inventory->medicine->image->path] : null,
                        ],
                        'selling_price' => $inventory->selling_price,
                        'pharmacy' => [
                            'name' => $inventory->pharmacy->name,
                        ],
                    ];
                }),
            ]);
        }

        // إرجاع العرض العادي إذا لم يكن AJAX
        return view('frontend.search', compact('inventories', 'query', 'categories', 'category', 'sort'));
    }


    function connectus(){
        return view('frontend.connectus');
    }
}

/* page 1
* الصيدليات القريبة  لم يعمل بحث زر مزيد ما بعمل
*  البحث  عن منتج
* منتجات طبية

/* page 2
* عرض معلومات الصيدلية
* بحث
* التنصيف
* عرض جميع منتجات الصيدلية

*/
