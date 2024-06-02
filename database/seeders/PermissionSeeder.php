<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //添加权限
        $permissions = [
            ['name' => 'users.index', 'cn_name' => '用户列表', 'guard_name' => 'api'],
            ['name' => 'users.show', 'cn_name' => '用户详情', 'guard_name' => 'api'],
            //需要写入所有权限
        ];

        foreach ($permissions as $v) {
            Permission::create($v);
        }

        //添加角色
        $role = Role::create(['name' => 'super-admin', 'cn_name' => '超级管理员', 'guard_name' => 'api']);

        //为角色添加权限
        $role->givePermissionTo(Permission::all());
    }
}
