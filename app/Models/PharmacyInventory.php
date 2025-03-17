<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PharmacyInventory extends Model
{

    protected $fillable = [
        'pharmacy_id',
        'medicine_id',
        'quantity_in_stock',
        'selling_price',
        'expiry_date',
        'status',
        'alert_threshold'
    ];

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'inventory_id');
    }
}
