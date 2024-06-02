<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Order;

class OrderTransFormer extends TransformerAbstract
{
    public function transform(Order $order)
    {
        return [
            'id' => $order->id,
            'order_no' => $order->order_no,
            'user id' => $order->user_id,
            'amount' => $order->amount,
            'status' => $order->status,
            'address_id' => $order->address_id,
            'express type' => $order->express_type,
            'express_no' => $order->express_no,
            'pay_time' => $order->pay_time,
            'pay_type' => $order->pay_type,
            'trade_no' => $order->trade_no
        ];
    }
}
