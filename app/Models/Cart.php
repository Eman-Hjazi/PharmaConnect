<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'inventory_id', 'quantity'];

    // علاقة مع User (كل عربة تابعة لمستخدم واحد)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // علاقة مع PharmacyInventory (كل عربة تابعة لمنتج مخزون واحد)
    public function pharmacyInventory()
    {
        return $this->belongsTo(PharmacyInventory::class, 'inventory_id');
    }
}
