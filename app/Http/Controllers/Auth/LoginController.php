<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\LoginRequest;

class LoginController extends BaseController
{
    /**
     * 用户登录.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {

            return $this->response->errorUnauthorized();
        }

        //检查用户状态
        $user = auth('api')->user();
        if ($user->is_locked == 1) {
            return $this->response->errorForbidden('用户已被锁定');
        }

        return $this->respondWithToken($token);
    }


    /**
     * 退出登录
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * 刷新token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
