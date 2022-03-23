<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('object_id')->nullable();
            $table->string('object_name',255)->nullable();
            $table->bigInteger('formObjectMorning')->nullable();
            $table->bigInteger('formObjectPresent')->nullable();
            $table->integer('formId')->nullable();
            $table->integer('parentId')->nullable();
            $table->date('dateCr')->nullable();
            $table->double('morning')->nullable();
            $table->double('present')->nullable();
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
        Schema::dropIfExists('daily_history');
    }
}
