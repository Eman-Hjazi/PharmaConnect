<?php

namespace App\Http\Controllers\Company;

use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PharmacyController extends Controller
{
    public function index()
    {
        $companyId = auth('company')->user()->id; // افتراض أن المستخدم مرتبط بشركة

        $pharmacies = Pharmacy::whereHas('sentOrders', function ($query) use ($companyId) {
            $query->where('destination_type', 'App\Models\Company')
                  ->where('destination_id', $companyId);
        })->withCount('sentOrders')->with('image')->get();

        return view('company.pharmacies.index', compact('pharmacies'));
    }


    public function show(Pharmacy $pharmacy)
    {
        return view('company.pharmacies.show', compact('pharmacy'));
    }






    public function destroy(Pharmacy $pharmacy)
    {
        try {
            // التحقق من وجود الصيدلية
            if (!$pharmacy->exists) {
                Log::error('Pharmacy not found for deletion');
                return response()->json(['error' => 'الصيدلية غير موجودة'], 404);
            }

            // تسجيل معرف الصيدلية
            Log::info('Starting deletion process for pharmacy ID: ' . $pharmacy->id);

            // الحصول على معرف الشركة الحالية
            $company = Auth::guard('company')->user();
            if (!$company) {
                Log::error('No authenticated company user found');
                return response()->json(['error' => 'لا يمكن التعرف على الشركة'], 401);
            }
            $companyId = $company->company_id;
            Log::info('Authenticated company ID: ' . $companyId);

            // حذف الطلبات المرسلة من الصيدلية إلى هذا الشركة فقط
            $sentOrders = $pharmacy->sentOrders()
                                 ->where('destination_type', 'App\Models\Company')
                                 ->where('destination_id', $companyId)
                                 ->get();
            Log::info('Found ' . $sentOrders->count() . ' sent orders to company ID: ' . $companyId . ' for pharmacy ID: ' . $pharmacy->id);
            foreach ($sentOrders as $order) {
                Log::info('Deleting sent order ID: ' . $order->id);
                if ($order->orderDetails()->count() > 0) {
                    $order->orderDetails()->delete();
                    Log::info('Deleted order details for sent order ID: ' . $order->id);
                }
                $order->delete();
                Log::info('Deleted sent order ID: ' . $order->id);
            }

            // حذف الصورة المرتبطة بالصيدلية
            if ($pharmacy->image) {
                Log::info('Attempting to delete image for pharmacy ID: ' . $pharmacy->id . ' with path: ' . $pharmacy->image->path);
                if (Storage::disk('public')->exists($pharmacy->image->path)) {
                    Storage::disk('public')->delete($pharmacy->image->path);
                    Log::info('Deleted image file for pharmacy ID: ' . $pharmacy->id);
                } else {
                    Log::warning('Image file not found for pharmacy ID: ' . $pharmacy->id . ' at path: ' . $pharmacy->image->path);
                }
                $pharmacy->image->delete();
                Log::info('Deleted image record for pharmacy ID: ' . $pharmacy->id);
            } else {
                Log::info('No image found for pharmacy ID: ' . $pharmacy->id);
            }

            // حذف الصيدلية
            Log::info('Attempting to delete pharmacy ID: ' . $pharmacy->id);
            $pharmacy->delete();
            Log::info('Successfully deleted pharmacy ID: ' . $pharmacy->id);

            // التحقق من الحذف
            if (Pharmacy::find($pharmacy->id)) {
                Log::error('Pharmacy ID: ' . $pharmacy->id . ' was not actually deleted');
                return response()->json(['error' => 'فشل في حذف الصيدلية'], 500);
            }

            return response()->json(['success' => 'تم حذف الصيدلية وطلباتها المرسلة إلى الشركة بنجاح']);
        } catch (\Exception $e) {
            Log::error('Error deleting pharmacy ID: ' . ($pharmacy->id ?? 'unknown') . ' - Error: ' . $e->getMessage());
            return response()->json(['error' => 'حدث خطأ أثناء الحذف: ' . $e->getMessage()], 500);
        }
    }


}
