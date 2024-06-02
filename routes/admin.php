<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\GoodsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PayController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\UserController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->group(['prefix' => 'admin'], function ($api) {
        //需要登录后操作
        $api->group(['middleware' => ['api.auth', 'check.permission', 'bindings', 'serializer:array']], function ($api) {

            /**
             * 用户管理
             */
            /*用户启用/禁用*/
            $api->patch('users/{user}/lock', [UserController::class, 'lock']);

            /*用户管理资源路由*/
            $api->resource('users', UserController::class, [
                'only' => ['index', 'show']
            ]);

            /**
             * 分类管理
             */
            /*分类启用/禁用*/
            $api->patch('category/{category}/status', [CategoryController::class, 'status']);

            /*分类管理资源路由*/
            $api->resource('category', CategoryController::class, [
                'except' => ['destroy']
            ]);

            /**
             * 商品管理
             */
            /* 是否上架 */
            $api->patch('goods/{good}/on', [GoodsController::class, 'isOn']);

            /* 是否推荐 */
            $api->patch('goods/{good}/recommend', [GoodsController::class, 'isRecommend']);

            /*商品管理资源路由*/
            $api->resource('goods', GoodsController::class, [
                'except' => ['destroy']
            ]);

            /**
             * 评价管理
             */
            /* 评价列表 */
            $api->get('comments', [CommentController::class, 'index']);

            /* 评价详情 */
            $api->get('comments/{comment}', [CommentController::class, 'show']);

            /* 回复评价 */
            $api->patch('comments/{comment}/reply', [CommentController::class, 'reply']);

            /**
             * 订单管理
             */
            /*订单列表*/
            $api->get('orders', [OrderController::class, 'index']);
            /*订单详情*/
            $api->get('orders/{order}', [OrderController::class, 'show']);
            /*订单发货*/
            $api->patch('orders/{order}/post', [OrderController::class, 'post']);

            /*支付宝扫码支付*/
            $api->post('pay', [PayController::class, 'pay']);

            /*轮播图管理资源路由*/
            $api->resource('slides', SlideController::class);

            /* 轮播图排序 */
            $api->patch('slides/{slide}/seq', [SlideController::class, 'seq']);
        });
    });
});
