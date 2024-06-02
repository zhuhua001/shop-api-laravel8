<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 10)->comment('分类名称');
                $table->integer('pid')->default(0)->comment('父级id');
                $table->tinyInteger('status')->default(1)->comment('状态 0:禁用 1:启用');
                $table->tinyInteger('level')->default(1)->comment('分类级别: 1,2,3');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
