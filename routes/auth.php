<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OssController;
use App\Http\Controllers\Auth\RegisterController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['prefix' => 'auth'], function ($api) {

        //注册
        $api->post('register', [RegisterController::class, 'register']);
        //登录
        $api->post('login', [LoginController::class, 'login']);

        $api->group(['middleware' => 'api.auth'], function ($api) {
            //退出登录
            $api->post('logout', [LoginController::class, 'logout']);
            //刷新token
            $api->post('refresh', [LoginController::class, 'refresh']);
            //生成阿里云oss的token
            $api->get('oss/token', [OssController::class, 'token']);
        });
    });
});
