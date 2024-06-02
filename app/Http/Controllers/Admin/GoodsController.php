<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\GoodsRequest;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Models\Good;
use App\Transformers\GoodTransFormer;

class GoodsController extends BaseController
{
    /**
     * 商品列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $category_id = $request->input('category_id');
        $is_on = $request->input('is_on', false);
        $is_recommend = $request->input('is_recommend', false);
        $perPage = $request->input('per_page') ?? 5;
        $currentPage = $request->input('current_page') ?? 1;

        $goods = Good::when($title, function ($query) use ($title) {
            $query->where('title', 'like', "%$title%");
        })->when($category_id, function ($query) use ($category_id) {
            $query->where('category_id', $category_id);
        })->when($is_on !== false, function ($query) use ($is_on) {
            $query->where('is_on', $is_on);
        })->when($is_recommend !== false, function ($query) use ($is_recommend) {
            $query->where('is_recommend', $is_recommend);
        })
            ->paginate($perPage, ['*'], '', $currentPage);

        return $this->response->paginator($goods, new GoodTransFormer());
    }

    /**
     * 新增商品
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GoodsRequest $request)
    {
        //获取用户id
        $user_id = auth('api')->id();

        $request->offsetSet('user_id', $user_id);

        //存储商品信息
        Good::create($request->all());

        return $this->response->created();
    }

    /**
     * 商品详情
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Good $good)
    {
        return $this->response->item($good, new GoodTransFormer());
    }

    /**
     * 更新商品信息
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GoodsRequest $request, Good $good)
    {
        //检查分类
        $categoey = Category::find($request->category_id);

        if (!$categoey) {
            return $this->response->errorBadRequest('分类不能存在');
        }
        if ($categoey->status == 0) {
            return $this->response->errorBadRequest('分类被禁用');
        }
        if ($categoey->level !== 3) {
            return $this->response->errorBadRequest('只能向三级分类关联商品');
        }

        //更新商品信息
        $good->update($request->all());

        return $this->response->noContent();
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

    /**
     * 是否上架
     */
    public function isOn(Good $good)
    {
        $good->is_on = $good->is_on == 0 ? 1 : 0;
        $good->save();

        return $this->response->noContent();
    }

    /**
     * 是否推荐
     */
    public function isRecommend(Good $good)
    {
        $good->is_recommend = $good->is_recommend == 0 ? 1 : 0;
        $good->save();

        return $this->response->noContent();
    }
}
