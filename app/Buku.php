<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';

    protected $guarded = [];

    protected $perPage = 5;

    public function transaksi(){
        return $this->hasMany(Transaksi::class);
    }

    public function rak(){
        return $this->belongsTo(Rak::class);
    }
}
