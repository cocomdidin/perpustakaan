<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;

    protected $table = 'transaksi';

    protected $guarded = [];

    public function anggota(){

        return $this->belongsTo(Anggota::class);
    }

    public function buku(){

        return $this->belongsTo(Buku::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function getTerlambatAttribute()
    {
        return max(Carbon::parse($this->tgl_max_pinjam)->diffInDays(Carbon::parse($this->tgl_kembali), false), 0);
    }

    public function getDendaAttribute()
    {
        return $this->terlambat * 1000;
    }
}
