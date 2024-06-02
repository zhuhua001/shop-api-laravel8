<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;

    //表名称
    protected $table = 'goods';
    //主键
    protected $primaryKey = 'id';
    //设置允许写入的数据字段
    protected $fillable = ['id', 'user_id', 'title', 'category_id', 'price', 'stock', 'cover', 'description', 'details'];

    /**
     * 商品所属的分类 
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
