<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdvpositions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advpositions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->default('');
            $table->Integer('ap_height')->default(0);
            $table->Integer('ap_width')->default(0);
            $table->tinyInteger('status')->default(1);//1代表在使用ing
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
        Schema::dropIfExists('advpositions');
    }
}
