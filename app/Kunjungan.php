<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';
    protected $fillable = ['anggota_id', 'jenis', 'waktu'];
    protected $perPage = 10;

    public function anggota(){

        return $this->belongsTo(Anggota::class);
    }
}
