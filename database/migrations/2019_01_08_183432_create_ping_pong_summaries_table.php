<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePingPongSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ping_pong_summaries', function (Blueprint $table) {
            $table->integer('group')->unsigned();
            $table->integer('count')->unsigned()->nullable()->default(0);
            $table->string('uptime')->nullable()->default(0);
            $table->string('uptime_internal', 100)->nullable();
            $table->string('uptime_external', 100)->nullable();
            $table->timestamp('earliest_item')->nullable();

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
        Schema::dropIfExists('ping_pong_summaries');
    }
}
