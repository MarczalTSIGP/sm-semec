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
           $table->renameColumn('formation_id', 'formation');
                });
            
    }
}
