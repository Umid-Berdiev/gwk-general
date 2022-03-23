<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->nullable();
            $table->double('value')->nullable();
            $table->double('average')->nullable();
            $table->bigInteger('form_id')->nullable();
            $table->bigInteger('gvk_object_id')->nullable();
            $table->integer('type')->comment('type => 1 Amu , type=> 2 Sirdaryo')->nullable();
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
        Schema::dropIfExists('information_history');
    }
}
