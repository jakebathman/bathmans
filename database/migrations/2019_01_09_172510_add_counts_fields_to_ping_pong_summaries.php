<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountsFieldsToPingPongSummaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ping_pong_summaries', function (Blueprint $table) {
            $table->integer('count_internal')->unsigned()->nullable()->default(0)->after('count');
            $table->integer('count_external')->unsigned()->nullable()->default(0)->after('count_internal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ping_pong_summaries', function (Blueprint $table) {
            $table->dropColumn('count_internal');
            $table->dropColumn('count_external');
        });
    }
}
