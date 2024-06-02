<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\SlideRequest;
use App\Models\Slide;
use App\Transformers\SlideTransFormer;
use Illuminate\Http\Request;

class SlideController extends BaseController
{
    /**
     * 列表
     */
    public function index()
    {
        $slide = Slide::paginate(2);

        return $this->response->paginator($slide, new SlideTransFormer);
    }

    /**
     * 新增
     *
     */
    public function store(SlideRequest $request)
    {
        //查询最大的seq值
        $max_seq = Slide::max('seq') ?? 0;
        $max_seq++;

        $request->offsetSet('seq', $max_seq);

        Slide::create($request->all());

        return $this->response->created();
    }

    /**
     * 详情
     *
     */
    public function show(Slide $slide)
    {
        return $this->response->item($slide, new SlideTransFormer);
    }

    /**
     * 更新
     *
     */
    public function update(SlideRequest $request, Slide $slide)
    {
        $slide->update($request->all());

        return $this->response->noContent();
    }

    /**
     * 删除
     *
     */
    public function destroy(Slide $slide)
    {
        $slide->delete();

        return $this->response->noContent();
    }

    /**
     * 排序
     *
     */
    public function seq(Request $request, Slide $slide)
    {
        $slide->seq = $request->input('seq', 1);
        $slide->save();

        return $this->response->noContent();
    }
}
