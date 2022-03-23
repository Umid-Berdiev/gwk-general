<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmusirFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amu_sir_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('gvk_object_id')->nullable();
            $table->double('order_number')->nullable();
            $table->integer('check')->nullable();
            $table->integer('year')->nullable();
            $table->integer('type')->nullable();
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
        Schema::dropIfExists('amu_sir_forms');
    }
}
