<?php

namespace App\Transformers;

use App\Models\Slide;
use League\Fractal\TransformerAbstract;

class SlideTransFormer extends TransformerAbstract
{
    public function transform(Slide $slide)
    {
        return [
            'id' => $slide->id,
            'title' => $slide->title,
            'img' => $slide->img,
            'url' => $slide->url,
            'status' => $slide->status
        ];
    }
}
