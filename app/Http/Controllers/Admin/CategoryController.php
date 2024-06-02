<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * 分类列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Category::select(['id', 'pid', 'name', 'level'])->get();

        $tree = common_get_tree($data, 0);

        return $tree;
        //注：数据多了可以做cache缓存
    }

    /**
     * 新增分类
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**参数检查**/
        $check = $this->checkCategory($request);

        if (!is_array($check)) {
            return $check;
        }
        $inserData = [
            'name' =>  $request->input('name'),
            'pid' => $check['pid'],
            'level' => $check['level']
        ];

        Category::create($inserData);

        return $this->response->created();
    }

    /**
     * 分类详情
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * 更新分类
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        /**参数检查**/
        $check = $this->checkCategory($request);

        if (!is_array($check)) {
            return $check;
        }

        $inserData = [
            'name' =>  $request->input('name'),
            'pid' => $check['pid'],
            'level' => $check['level']
        ];

        $category->update($inserData);

        return $this->response->noContent();
    }

    /**
     * 状态的启用和禁用
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status(Category $category)
    {
        $category->status = $category->status == 1 ? 0 : 1;

        $category->save();

        return $this->response->noContent();
    }

    /******分类参数检查******/
    public function checkCategory($request)
    {
        $request->validate([
            'name' => 'required|max:10',
        ], [
            'name.required' => '分类名称不能为空',
            'name.max' => '分类名称长度不能超过10'
        ]);

        //父级id
        $pid = $request->input('pid', 0);
        //level
        $level = $pid == 0 ? 1 : (Category::find($pid)->level + 1);

        //不能超过三级分类
        if ($level > 3) {
            return $this->response->errorBadRequest('不能超过三级分类');
        }

        return ['pid' => $pid, 'level' => $level];
    }
}
