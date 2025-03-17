<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineCategory extends Model
{
    protected $fillable = ['name'];

    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'medicine_category_id');
    }


}
