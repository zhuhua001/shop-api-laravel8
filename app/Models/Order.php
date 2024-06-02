<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**订单所属用户**/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**用户拥有的订单细节**/
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }
}
