<?php

namespace App\Transformers;

use App\Models\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'goods_id' => $comment->goods_id,
            'goods_title' => $comment->goods->title,
            'user_id' => $comment->user_id,
            'user_name' => $comment->user->uname,
            'rate' => $comment->rate,
            'reply' => $comment->reply,
            'created_at' => $comment->created_at,
            'updated_at' => $comment->updated_at
        ];
    }
}
