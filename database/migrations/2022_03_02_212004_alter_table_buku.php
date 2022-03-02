<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableBuku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->string('kode',50)->after('id');
            $table->string('edisi',255)->nullable()->after('judul');
            $table->foreignId('rak_id')->nullable()->after('deskripsi');

            $table->foreign('rak_id')->references('id')->on('rak');

            $table->dropColumn('lokasi');
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
