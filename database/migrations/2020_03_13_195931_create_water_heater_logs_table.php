<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaterHeaterLogsTable extends Migration
{
    public function up()
    {
        Schema::create('water_heater_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('is_on')->unsigned();
            $table->integer('noticed_when_using')->unsigned()->nullable()->default(0);
            $table->text('notes')->nullable()->default(null);
            $table->dateTime('logged_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('water_heater_logs');
    }
}
