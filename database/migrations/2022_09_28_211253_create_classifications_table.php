<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->integer('rank')->nullable();

            $table->integer('worked_days');

            $table->integer('formation_points');

            $table->integer('worked_days_unit');

            $table->unsignedBigInteger('inscription_id')->index();
            $table->foreign('inscription_id')
            ->references('id')
            ->on('inscriptions')
            ->onDelete('cascade');

            $table->unsignedBigInteger('edict_id')->index();
            $table->foreign('edict_id')
            ->references('id')
            ->on('edicts')
            ->onDelete('cascade');

         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classifications');
    }
}
