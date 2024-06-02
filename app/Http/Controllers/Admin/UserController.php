<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Transformers\UserTransFormer;

class UserController extends BaseController
{
    /**
     * 用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $uname = $request->input('uname');
        $email = $request->input('email');
        $perPage = $request->input('per_page') ?? 5;
        $currentPage = $request->input('current_page') ?? 1;

        $users = User::when($uname, function ($query) use ($uname) {
            $query->where('uname', 'like', "%$uname%");
        })->when($email, function ($query) use ($email) {
            $query->where('email', $email);
        })
            ->paginate($perPage, ['*'], '', $currentPage);

        return $this->response->paginator($users, new UserTransFormer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * 用户详情
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->response->item($user, new UserTransFormer);
    }

    /**
     * 用户启用/禁用
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lock(User $user)
    {
        $user->is_locked = $user->is_locked == 0 ? 1 : 0;
        $user->save();

        return $this->response->noContent();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
