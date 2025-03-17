<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pharmacy;
use App\Models\Image;

class PharmacySeeder extends Seeder
{
    public function run()
    {
        $pharmacies = [
            [
                'name' => 'صيدلية الشفاء',
                'email' => 'shifa.gaza@example.com',
                'password' => bcrypt('password123'),
                'address' => 'غزة، شارع الوحدة، بجوار مستشفى الشفاء',
                'description' => 'صيدلية رائدة تقدم خدمات طبية متميزة في مدينة غزة.',
            ],
            [
                'name' => 'صيدلية الرحمة',
                'email' => 'rahma.gaza@example.com',
                'password' => bcrypt('password123'),
                'address' => 'غزة، شارع الرشيد، حي الرمال',
                'description' => 'صيدلية تقدم جميع الأدوية والمستلزمات الطبية بأسعار مناسبة.',
            ],
            [
                'name' => 'صيدلية الأمل',
                'email' => 'amal.deir@example.com',
                'password' => bcrypt('password123'),
                'address' => 'دير البلح، شارع صلاح الدين، مقابل السوق المركزي',
                'description' => 'صيدلية تخدم سكان دير البلح وتوفر أدوية بجودة عالية.',
            ],
            [
                'name' => 'صيدلية السلام',
                'email' => 'salaam.deir@example.com',
                'password' => bcrypt('password123'),
                'address' => 'دير البلح، شارع البحر، قرب الميناء',
                'description' => 'صيدلية تتميز بخدمة العملاء الممتازة في دير البلح.',
            ],
            [
                'name' => 'صيدلية النور',
                'email' => 'noor.khanyounis@example.com',
                'password' => bcrypt('password123'),
                'address' => 'خانيونس، شارع جلال، حي الأمل',
                'description' => 'صيدلية تقدم خدمات طبية شاملة في خانيونس.',
            ],
            [
                'name' => 'صيدلية الفرج',
                'email' => 'faraj.khanyounis@example.com',
                'password' => bcrypt('password123'),
                'address' => 'خانيونس، شارع البحر، مقابل مخيم خانيونس',
                'description' => 'صيدلية توفر الأدوية النادرة والمستلزمات الطبية.',
            ],
            [
                'name' => 'صيدلية الحياة',
                'email' => 'hayat.rafah@example.com',
                'password' => bcrypt('password123'),
                'address' => 'رفح، شارع الشهداء، بجوار مدرسة رفح الإعدادية',
                'description' => 'صيدلية تقدم خدمات متميزة لسكان مدينة رفح.',
            ],
            [
                'name' => 'صيدلية المستقبل',
                'email' => 'mustaqbal.rafah@example.com',
                'password' => bcrypt('password123'),
                'address' => 'رفح، شارع النصر، قرب دوار النجمة',
                'description' => 'صيدلية حديثة تخدم سكان رفح بكفاءة عالية.',
            ],

            [
                'name' => 'صيدلية النهضة',
                'email' => 'nahda.rafah@example.com',
                'password' => bcrypt('password123'),
                'address' => 'رفح، شارع الشهداء، بالقرب من المسجد الكبير',
                'description' => 'صيدلية متطورة تقدم خدمات طبية شاملة في رفح.',
            ],

        ];

        foreach ($pharmacies as $pharmacyData) {
            $pharmacy = Pharmacy::create($pharmacyData);
            $pharmacy->image()->create(['path' => 'pharmacy/pharma.png']);
        }
    }
}
