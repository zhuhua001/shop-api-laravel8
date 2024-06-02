<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    /**订单细节所属主表**/
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**订单细节关系的商品**/
    public function goods()
    {
        return $this->hasOne(Good::class, 'goods_id', 'id');
    }
}
