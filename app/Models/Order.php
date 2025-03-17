<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $guarded = [];

    public function orderable(){ // pharmacy or user
        return $this->morphTo();
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function destination() // pharmacy or company
    {
        return $this->morphTo();
    }
}
