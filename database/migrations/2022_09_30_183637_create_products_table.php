<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            /*Связываем таблицы*/
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('product_categories');

            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->string('article')->nullable();
            $table->tinyInteger('price_up')->default('0');
            $table->tinyInteger('price after')->default('0');
            $table->string('image')->nullable();
            $table->string('type_products')->nullable();
            $table->string('coverage')->nullable();
            $table->string('weight_photo')->nullable();
            $table->string('number_tiers')->nullable();
            $table->longText('intro_text')->nullable();
            $table->longText('description')->nullable();
            $table->longText('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('congratulatory_signature')->nullable();
            $table->boolean('published')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');

    }
}
