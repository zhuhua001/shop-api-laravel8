<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class TestController extends BaseController
{
    public function test(Request $request)
    {
        return 'dingo搭建测试';
    }
}
