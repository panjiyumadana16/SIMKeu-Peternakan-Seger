<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsFromKandangs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kandangs', function (Blueprint $table) {
            $table->dropColumn('jenis_produk');
            $table->dropColumn('tgl_diambil');
            $table->dropColumn('stok');
            $table->integer('jml_ayam')->after('kandang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kandangs', function (Blueprint $table) {
            //
        });
    }
}
