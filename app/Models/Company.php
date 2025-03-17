<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class Company extends Authenticatable
{
    protected $guard = 'company';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function medicines(){
     return $this->hasMany(Medicine::class);
    }

     // الطلبات المرسلة من الصيدلية إلى الشركات
     public function orders()
     {
         return $this->morphMany(Order::class, 'destination');  // العلاقة مع الطلبات المرسلة
     }

     function image(){
        return $this->morphOne(image::class,'imageable');
    }
}
