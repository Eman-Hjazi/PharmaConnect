<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * تشغيل Seeder لإدخال بيانات تجريبية.
     */

     public function run()
     {
         $companies = [
             [
                 'name' => 'شركة الشفاء للأدوية',
                 'email' => 'info@shifa-gaza.com',
                 'password' => bcrypt('shifa123'), // كلمة المرور مشفرة
             ],
             [
                 'name' => 'شركة غزة فارما',
                 'email' => 'contact@gazapharma.com',
                 'password' => bcrypt('gazapharma123'),
             ],
             [
                 'name' => 'شركة الأمل للصناعات الدوائية',
                 'email' => 'support@amal-pharma.com',
                 'password' => bcrypt('amal123'),
             ],
             [
                 'name' => 'شركة النور للأدوية',
                 'email' => 'sales@noor-gaza.com',
                 'password' => bcrypt('noor123'),
             ],
         ];

         foreach ($companies as $company) {
             Company::updateOrCreate(
                 ['email' => $company['email']], // التأكد من عدم التكرار بناءً على البريد الإلكتروني
                 [
                     'name' => $company['name'],
                     'password' => $company['password'],
                 ]
             );
         }
     }

}

