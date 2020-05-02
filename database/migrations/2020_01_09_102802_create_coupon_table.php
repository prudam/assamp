<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('coupon')->comment('1 = User, 2 = Seller');
            $table->integer('coupon_type')->comment('1 = For new user, 2 = For all user');
            $table->string('coupon_code');
            $table->integer('coupon_amount')->comment('In perchantage');
            $table->string('coupon_desc');
            $table->integer('status')->default(1)->comment('1 = Active, 2 = In-Active');
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
        Schema::dropIfExists('coupon');
    }
}
