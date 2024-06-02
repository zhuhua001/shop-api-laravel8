<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //数据库表
    protected $table = 'categories';
    //主键
    protected $primaryKey = 'id';

    //设置允许写入的数据字段
    protected $fillable = ['name', 'pid', 'level'];
}
