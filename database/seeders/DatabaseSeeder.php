<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PharmacySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       // ترتيب تنفيذ Seeders
       $this->call([
        MedicineCategorySeeder::class, // أولاً: إنشاء فئات الأدوية
        CompanySeeder::class,          // ثانياً: إدخال الشركات
        MedicineSeeder::class,         // ثالثاً: إدخال الأدوية
        PharmacySeeder::class
    ]);
    }
}
