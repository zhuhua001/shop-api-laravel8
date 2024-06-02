<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Yansongda\LaravelPay\Facades\Pay;

class PayController extends BaseController
{
    public function pay()
    {
        //return '支付测试';

        $order = [
            'out_trade_no' => time() + 60000,
            'total_amount' => '1',
            'subject' => 'test subject - 测试',
        ];

        return Pay::alipay()->scan($order);
    }
}
