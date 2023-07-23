<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToTransaksies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksies', function (Blueprint $table) {
            $table->foreignId('ongkir_kota_id')->after('alamat_pengiriman')
                ->references('id')->on('ongkir_kotas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksies', function (Blueprint $table) {
            //
        });
    }
}
