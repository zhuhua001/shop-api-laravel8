<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Mail\OrderEmail;
use App\Models\Order;
use App\Transformers\OrderTransFormer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends BaseController
{
    /****订单列表****/
    public function index(Request $request)
    {
        /* 查询条件 */
        //订单号
        $order_no = $request->input('order_no');
        //支付单号
        $trade_no = $request->input('trade_no');
        //订单状态 
        $status = $request->input('status');

        $orders = Order::when($order_no, function ($query) use ($order_no) {
            $query->where('order_no', $order_no);
        })->when($order_no, function ($query) use ($trade_no) {
            $query->where('trade_no', $trade_no);
        })->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
            ->paginate(5);

        return $this->response->paginator($orders, new OrderTransFormer());
    }

    /****订单详情****/
    public function show(Order $order)
    {
        return $this->response->item($order, new OrderTransFormer());
    }

    /****发货****/
    public function post(Request $request, Order $order)
    {
        //验证提交参数
        $request->validate([
            'express_type' => 'required|in:SF,YT,YD',
            'express_no' => 'required'
        ], [
            'express_type.required' => '快递类型必填',
            'express_type.in' => '快递类型只能是: SF,YT,YD',
            'express_no.required' => '快递单号不能为空'
        ]);

        //更新数据
        $order->express_type = $request->input('express_type');
        $order->express_no = $request->input('express_no');
        $order->status = 3; //发货状态

        $order->save();

        /* 发货之后，邮件提醒 */
        Mail::to($order->user)->send(new OrderEmail($order));

        return $this->response->noContent();
    }
}
