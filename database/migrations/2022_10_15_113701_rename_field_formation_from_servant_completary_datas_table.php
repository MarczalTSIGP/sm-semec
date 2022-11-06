<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFieldFormationFromServantCompletaryDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servant_completary_datas', function (Blueprint $table) {
          
            $table->renameColumn('formation', 'formation_id');
       //     $table->unsignedBigInteger('formation_id')->change();
       //     $table->foreign('formation_id')
       //     ->references('id')
       //     ->on('formations')
       //     ->onDelete('cascade');

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
         //  $table->dropForeign('servant_completary_datas_formation_id_foreign');
           $table->renameColumn('formation_id', 'formation');
       //    $table->string('formation')->change();
        });
            
    }
}
