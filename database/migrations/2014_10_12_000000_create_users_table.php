<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 191);
            $table->string('email', 191);
            $table->string('contact_no', 191);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 191);
            $table->string('gst_no', 191);
            $table->integer('user_role')->comment('1 = Seller, 2 = User');
            $table->integer('verification')->comment('1 = New, 0 = Confirm');
            $table->integer('status')->comment('1 = Active, 0 = In-Active');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
