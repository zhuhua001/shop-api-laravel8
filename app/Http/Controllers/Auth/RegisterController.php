<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\RegisterRequest;

use App\Models\User;

class RegisterController extends BaseController
{
    /**用户注册**/
    public function register(RegisterRequest $request)
    {
        $user = new User();

        $user->uname = $request->input('uname');
        $user->password = bcrypt($request->input('password'));
        $user->email = $request->input('email');

        $user->save();

        return $this->response()->created();
    }
}
