<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'name', 'base_price', 'description', 'medicine_category_id', 'expiry_date', 'is_available', 'is_controlled',
        'company_id'
    ];


    function  company(){
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(MedicineCategory::class, 'medicine_category_id');
    }


    function pharmacyInventories(){
        return $this->hasMany(pharmacyInventory::class);
    }

    function image(){
        return $this->morphOne(image::class,'imageable');
    }


}
