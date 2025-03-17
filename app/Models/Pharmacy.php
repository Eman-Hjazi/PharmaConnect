<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Pharmacy extends Authenticatable
{
    protected $guard = 'pharmacy';

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'description',
    ];

       // الطلبات المستقبلة من الصيدلية
       public function orders() {
        return $this->morphMany(Order::class, 'destination');  // orders التي أرسلت إلى الصيدلية
    }

    // الطلبات المرسلة من الصيدلية
    public function sentOrders() {
        return $this->morphMany(Order::class, 'orderable');  // orders التي أرسلت من الصيدلية
    }



    function image(){
        return $this->morphOne(image::class,'imageable');
    }

    public function inventories()
{
    return $this->hasMany(PharmacyInventory::class, 'pharmacy_id');
}

}
