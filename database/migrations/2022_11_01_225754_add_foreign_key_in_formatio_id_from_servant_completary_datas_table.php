<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInFormatioIdFromServantCompletaryDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servant_completary_datas', function (Blueprint $table) {
            $table->foreign('formation_id')
            ->references('id')
            ->on('formations')
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
        Schema::table('servant_completary_datas', function (Blueprint $table) {
            $table->dropForeign('servant_completary_datas_formation_id_foreign');
        });
    }
}
