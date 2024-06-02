<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('评价的用户');
            $table->integer('goods_id')->comment('所属商品');
            $table->tinyInteger('rate')->default(1)->comment('评价的级别,1:好评 2:中评 3:差评');
            $table->string('content')->comment('评价的内容');
            $table->string('reply')->nullable()->comment('商家的回复');
            $table->json('pics')->nullable()->comment('多个评论图');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
