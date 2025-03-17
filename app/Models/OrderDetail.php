<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $guarded = [];


    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function medicine(){
        return $this->belongsTo(Medicine::class);
    }

    public function orderable(){
        return $this->morphTo();
    }
}
