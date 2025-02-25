<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('轮播图名称');
            $table->string('url')->nullable()->comment('跳转链接');
            $table->string('img')->nullable()->comment('轮播图图片');
            $table->tinyInteger('status')->default(0)->comment('状态, 0:禁用 1:正常');
            $table->integer('seq')->default(1)->comment('排序');
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
        Schema::dropIfExists('slides');
    }
}
