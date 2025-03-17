<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicineCategory;
use Illuminate\Support\Facades\DB;

class MedicineCategorySeeder extends Seeder
{
    /**
     * تشغيل Seeder لإدخال بيانات تجريبية.
     */
    public function run()
    {
        $categories = [
            ['name' => 'مسكنات', 'description' => 'أدوية لتسكين الألم'],
            ['name' => 'مضادات حيوية', 'description' => 'أدوية لعلاج العدوى البكتيرية'],
            ['name' => 'مضادات الالتهاب', 'description' => 'أدوية لتقليل الالتهاب'],
            ['name' => 'أدوية القلب', 'description' => 'أدوية لعلاج أمراض القلب'],
            ['name' => 'أدوية السكري', 'description' => 'أدوية لتنظيم السكر في الدم'],
        ];

        foreach ($categories as $category) {
            MedicineCategory::updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
}

}
