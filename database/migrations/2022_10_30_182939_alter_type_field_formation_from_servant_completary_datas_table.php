<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTypeFieldFormationFromServantCompletaryDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servant_completary_datas', function (Blueprint $table) {
            $table->unsignedBigInteger('formation_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servant_completary_datas', function (Blueprint $table) {
            $table->string('formation_id')->change();
        });
    }
}
