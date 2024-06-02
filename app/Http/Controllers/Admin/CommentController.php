<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Comment;
use App\Transformers\CommentTransformer;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    /**
     * 评价列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //搜索条件
        $rate = $request->input('rate');
        $goods_id = $request->input('goods_id');

        $comments = Comment::when($rate, function ($query) use ($rate) {
            $query->where('rate', $rate);
        })->when($goods_id, function ($query) use ($goods_id) {
            $query->where('goods_id', $goods_id);
        })
            ->paginate(5);

        return $this->response->paginator($comments, new CommentTransformer);
    }

    /**
     * 评价详情
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return $this->response->item($comment, new CommentTransformer());
    }

    /**
     * 商家回复
     */
    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'reply' => 'required|max:255'
        ], [
            'reply.required' => '回复 不能为空',
            'reply.max' => '回复 最大长度不能超过255'
        ]);

        //更新
        $comment->reply = $request->input('reply');
        $comment->save();

        return $this->response->noContent();
    }
}
