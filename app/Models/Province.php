<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = ['province_id', 'name'];

    public function city()
    {
        return $this->hasMany(City::class, 'province_id', 'province_id');
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
