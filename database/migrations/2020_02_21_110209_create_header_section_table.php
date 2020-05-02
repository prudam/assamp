<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeaderSectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_section', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('header_top_color', 191);
            $table->string('header_middle_color', 191);
            $table->string('header_word_color', 191);
            $table->string('header_top_title', 191);
            $table->string('header_title', 191);
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
        Schema::dropIfExists('header_section');
    }
}
