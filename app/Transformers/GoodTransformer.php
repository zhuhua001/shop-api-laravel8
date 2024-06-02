<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;
use App\Models\Good;
use App\Models\User;

class GoodTransFormer extends TransformerAbstract
{
    protected $availableIncludes = ['category'];

    public function transform(Good $good)
    {
        return [
            'id' => $good->id,
            'title' => $good->title,
            /*  'category_id' => $good->category_id,
            'category_name' => Category::find($good->category_id)->name, */
            'cover' => $good->cover,
            'stock' => $good->stock,
            'cover_url' => config('filesystems')['disks']['oss']['oss_bucket_url'] . $good->cover,
            'price' => $good->price,
            'description' => $good->description,
            'is_on' => $good->is_on,
            'is_recommend' => $good->is_recommend,
            'created_at' => $good->created_at,
            'updated_at' => $good->updated_at,
            'user_id' => $good->user_id,
            'user_name' => User::find($good->user_id)->uname
        ];
    }

    /**
     * 额外的分类数据
     */
    public function includeCategory(Good $good)
    {
        return $this->item($good->category, new CategoryTransformer());
    }
}
