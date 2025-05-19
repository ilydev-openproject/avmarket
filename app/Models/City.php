<?php

namespace App\Models;

use App\Models\Province;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['city_id', 'province_id', 'type', 'name'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
