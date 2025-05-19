<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function order_item()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
