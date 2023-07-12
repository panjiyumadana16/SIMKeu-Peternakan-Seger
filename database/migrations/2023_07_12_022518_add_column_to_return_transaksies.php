<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToReturnTransaksies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('return_transaksies', function (Blueprint $table) {
            $table->foreignId('detail_transaksies_id')->after('transaksi_id')
                ->references('id')->on('detail_transaksies');
            $table->integer('jml_return')->after('detail_transaksies_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('return_transaksies', function (Blueprint $table) {
            //
        });
    }
}
