<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('object_history', function (Blueprint $table) {
            $table->bigInteger('id')->nullable();
            $table->string('name',255)->nullable();
            $table->bigInteger('form_id')->nullable();
            $table->bigInteger('unit_id')->nullable();
            $table->bigInteger('type_id')->nullable();
            $table->boolean('get')->nullable();
            $table->boolean('set')->nullable();
            $table->bigInteger('obj_id')->nullable();
            $table->string('name_ru',255)->nullable();
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
        Schema::dropIfExists('object_history');
    }
}
