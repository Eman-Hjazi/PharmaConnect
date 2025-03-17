<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Medicine;
use Illuminate\Database\Seeder;
use App\Models\MedicineCategory;
use Illuminate\Support\Facades\DB;

class MedicineSeeder extends Seeder
{
    /**
     * تشغيل Seeder لإدخال بيانات تجريبية.
     */
    public function run()
    {
        // استرجاع الفئات والشركات
        $categories = MedicineCategory::all()->pluck('id', 'name')->toArray();
        $companies = Company::all()->pluck('id', 'name')->toArray();

        $medicines = [
            // مسكنات
            [
                'name' => 'باراسيتامول 500 ملغ',
                'base_price' => 5.50,
                'description' => 'مسكن وخافض للحرارة',
                'is_available' => true,
                'medicine_category_id' => $categories['مسكنات'],
                'company_id' => $companies['شركة الشفاء للأدوية'],
                'expiry_date' => Carbon::now()->addYears(2),
                'is_controlled' => false,
            ],
            [
                'name' => 'إيبوبروفين 400 ملغ',
                'base_price' => 8.75,
                'description' => 'مسكن ومضاد للالتهاب',
                'is_available' => true,
                'medicine_category_id' => $categories['مسكنات'],
                'company_id' => $companies['شركة غزة فارما'],
                'expiry_date' => Carbon::now()->addYears(1),
                'is_controlled' => false,
            ],
            [
                'name' => 'ديكلوفيناك 50 ملغ',
                'base_price' => 10.25,
                'description' => 'مسكن قوي للآلام المزمنة',
                'is_available' => true,
                'medicine_category_id' => $categories['مسكنات'],
                'company_id' => $companies['شركة الأمل للصناعات الدوائية'],
                'expiry_date' => Carbon::now()->addYears(3),
                'is_controlled' => false,
            ],
            [
                'name' => 'أسبرين 81 ملغ',
                'base_price' => 4.20,
                'description' => 'مسكن ومميع للدم',
                'is_available' => true,
                'medicine_category_id' => $categories['مسكنات'],
                'company_id' => $companies['شركة النور للأدوية'],
                'expiry_date' => Carbon::now()->addYears(2),
                'is_controlled' => false,
            ],

            // مضادات حيوية
            [
                'name' => 'أموكسيسيلين 500 ملغ',
                'base_price' => 12.00,
                'description' => 'مضاد حيوي واسع الطيف',
                'is_available' => true,
                'medicine_category_id' => $categories['مضادات حيوية'],
                'company_id' => $companies['شركة الشفاء للأدوية'],
                'expiry_date' => Carbon::now()->addYears(2),
                'is_controlled' => false,
            ],
            [
                'name' => 'أزيثرومايسين 250 ملغ',
                'base_price' => 15.30,
                'description' => 'مضاد حيوي للعدوى التنفسية',
                'is_available' => true,
                'medicine_category_id' => $categories['مضادات حيوية'],
                'company_id' => $companies['شركة غزة فارما'],
                'expiry_date' => Carbon::now()->addYears(1),
                'is_controlled' => false,
            ],
            [
                'name' => 'سيفالكسين 500 ملغ',
                'base_price' => 14.00,
                'description' => 'مضاد حيوي للعدوى البكتيرية',
                'is_available' => true,
                'medicine_category_id' => $categories['مضادات حيوية'],
                'company_id' => $companies['شركة الأمل للصناعات الدوائية'],
                'expiry_date' => Carbon::now()->addYears(3),
                'is_controlled' => false,
            ],
            [
                'name' => 'كلاريثرومايسين 500 ملغ',
                'base_price' => 18.50,
                'description' => 'مضاد حيوي لعلاج التهابات الحلق',
                'is_available' => true,
                'medicine_category_id' => $categories['مضادات حيوية'],
                'company_id' => $companies['شركة النور للأدوية'],
                'expiry_date' => Carbon::now()->addYears(2),
                'is_controlled' => false,
            ],

            // مضادات الالتهاب
            [
                'name' => 'نابروكسين 500 ملغ',
                'base_price' => 9.80,
                'description' => 'مضاد التهاب غير ستيرويدي',
                'is_available' => true,
                'medicine_category_id' => $categories['مضادات الالتهاب'],
                'company_id' => $companies['شركة الشفاء للأدوية'],
                'expiry_date' => Carbon::now()->addYears(2),
                'is_controlled' => false,
            ],
            [
                'name' => 'ميلوكسيكام 15 ملغ',
                'base_price' => 11.40,
                'description' => 'مضاد التهاب لآلام المفاصل',
                'is_available' => true,
                'medicine_category_id' => $categories['مضادات الالتهاب'],
                'company_id' => $companies['شركة غزة فارما'],
                'expiry_date' => Carbon::now()->addYears(1),
                'is_controlled' => false,
            ],
            [
                'name' => 'سيليكوكسيب 200 ملغ',
                'base_price' => 13.20,
                'description' => 'مضاد التهاب لعلاج التهاب المفاصل',
                'is_available' => true,
                'medicine_category_id' => $categories['مضادات الالتهاب'],
                'company_id' => $companies['شركة الأمل للصناعات الدوائية'],
                'expiry_date' => Carbon::now()->addYears(3),
                'is_controlled' => false,
            ],
            [
                'name' => 'كيتورولاك 10 ملغ',
                'base_price' => 16.00,
                'description' => 'مضاد التهاب قوي للألم الحاد',
                'is_available' => true,
                'medicine_category_id' => $categories['مضادات الالتهاب'],
                'company_id' => $companies['شركة النور للأدوية'],
                'expiry_date' => Carbon::now()->addYears(2),
                'is_controlled' => true,
            ],

            // أدوية القلب
            [
                'name' => 'أتينولول 50 ملغ',
                'base_price' => 7.90,
                'description' => 'لعلاج ارتفاع ضغط الدم',
                'is_available' => true,
                'medicine_category_id' => $categories['أدوية القلب'],
                'company_id' => $companies['شركة الشفاء للأدوية'],
                'expiry_date' => Carbon::now()->addYears(2),
                'is_controlled' => false,
            ],
            [
                'name' => 'لوسارتان 50 ملغ',
                'base_price' => 9.50,
                'description' => 'لعلاج ارتفاع ضغط الدم',
                'is_available' => true,
                'medicine_category_id' => $categories['أدوية القلب'],
                'company_id' => $companies['شركة غزة فارما'],
                'expiry_date' => Carbon::now()->addYears(1),
                'is_controlled' => false,
            ],
            [
                'name' => 'أملوديبين 5 ملغ',
                'base_price' => 8.20,
                'description' => 'لعلاج ارتفاع ضغط الدم والذبحة الصدرية',
                'is_available' => true,
                'medicine_category_id' => $categories['أدوية القلب'],
                'company_id' => $companies['شركة الأمل للصناعات الدوائية'],
                'expiry_date' => Carbon::now()->addYears(3),
                'is_controlled' => false,
            ],
            [
                'name' => 'كابتوبريل 25 ملغ',
                'base_price' => 6.80,
                'description' => 'لعلاج ارتفاع ضغط الدم وفشل القلب',
                'is_available' => true,
                'medicine_category_id' => $categories['أدوية القلب'],
                'company_id' => $companies['شركة النور للأدوية'],
                'expiry_date' => Carbon::now()->addYears(2),
                'is_controlled' => false,
            ],

            // أدوية السكري
            [
                'name' => 'ميتفورمين 500 ملغ',
                'base_price' => 5.00,
                'description' => 'لتنظيم السكر في الدم',
                'is_available' => true,
                'medicine_category_id' => $categories['أدوية السكري'],
                'company_id' => $companies['شركة الشفاء للأدوية'],
                'expiry_date' => Carbon::now()->addYears(2),
                'is_controlled' => false,
            ],
            [
                'name' => 'جليبيزيد 5 ملغ',
                'base_price' => 7.30,
                'description' => 'لعلاج السكري من النوع الثاني',
                'is_available' => true,
                'medicine_category_id' => $categories['أدوية السكري'],
                'company_id' => $companies['شركة غزة فارما'],
                'expiry_date' => Carbon::now()->addYears(1),
                'is_controlled' => false,
            ],
            [
                'name' => 'سيتاگليبتين 100 ملغ',
                'base_price' => 22.00,
                'description' => 'لتحسين التحكم في السكر',
                'is_available' => true,
                'medicine_category_id' => $categories['أدوية السكري'],
                'company_id' => $companies['شركة الأمل للصناعات الدوائية'],
                'expiry_date' => Carbon::now()->addYears(3),
                'is_controlled' => false,
            ],
            [
                'name' => 'إنسولين جلارجين',
                'base_price' => 45.00,
                'description' => 'إنسولين طويل المفعول للسكري',
                'is_available' => true,
                'medicine_category_id' => $categories['أدوية السكري'],
                'company_id' => $companies['شركة النور للأدوية'],
                'expiry_date' => Carbon::now()->addYears(2),
                'is_controlled' => true,
            ],
        ];

        foreach ($medicines as $medicineData) {
            $medicine = Medicine::create($medicineData);

            // مساحة لإضافة الصورة (علاقة مع جدول images)
            // يمكنك إضافة الكود التالي لاحقًا لربط الصورة
            /*
            $medicine->image()->create([
                'path' => 'medicine/' . $medicine->id . '.jpg', // المسار الذي تريده
            ]);
            */
        }
    }

}
