<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdictUnitsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('edict_units', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('edict_id')->index();
      $table->foreign('edict_id')
        ->references('id')
        ->on('edicts')
        ->onDelete('cascade');

      $table->unsignedBigInteger('unit_id')->index();
      $table->foreign('unit_id')
        ->references('id')
        ->on('units')
        ->onDelete('cascade');

      $table->integer('available_vacancies');
      $table->enum('type_of_vacancy', ['RELEASED', 'REGISTERED']);

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
    Schema::dropIfExists('edict_units');
  }
}
