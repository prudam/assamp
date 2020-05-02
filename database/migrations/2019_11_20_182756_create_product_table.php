<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name', 191);
            $table->string('color', 191);
            $table->string('slug', 191);
            $table->integer('sub_category_id');
            $table->integer('discount')->nullable();
            $table->string('customer_price', 191)->nullable();
            $table->string('distributor_price', 191)->nullable();
            $table->integer('weight')->nullable();
            $table->integer('product_type')->comment("1 = Unit Product, 2 = Weight Product");
            $table->text('desc');
            $table->string('banner', 191);
            $table->integer('stock');
            $table->string('shipping_amount', 191);
            $table->integer('status')->default(1)->comment("1 = Active, 0 = Inactive");
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
        Schema::dropIfExists('product');
    }
}
