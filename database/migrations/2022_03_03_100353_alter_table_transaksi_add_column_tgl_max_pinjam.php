<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTransaksiAddColumnTglMaxPinjam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->date('tgl_max_pinjam')->nullable()->after('tgl_pinjam');
            $table->integer('total_denda')->nullable()->after('buku_id');
            $table->integer('jumlah_hari_telat')->nullable()->after('buku_id');
            $table->date('tgl_kembali')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
