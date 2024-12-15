<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 店舗名
            $table->string('image_url')->nullable(); // 店舗画像のパス
            $table->unsignedBigInteger('area_id')->nullable(); // 店舗の地域
            $table->unsignedBigInteger('genre_id')->nullable(); // 店舗のジャンル
            $table->text('description');// 店舗の説明
            $table->timestamps();


            // 外部キー制約
            $table->foreign('area_id')->references('id')->on('areas');

            $table->foreign('genre_id')->references('id')->on('genres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}