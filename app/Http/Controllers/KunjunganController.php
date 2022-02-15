<?php

namespace App\Http\Controllers;

use App\Anggota;
use App\Kunjungan;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{

    public function index()
    {
        return view('kunjungan.index',[
            'title' => 'Kunjungan',
        ]);
    }

    public function searchAnggota(Request $request)
    {
        return Anggota::where('nim', $request->nim)->first();
    }

    public function store(Request $request)
    {
        $message = [
            'required' => 'atribute tidak boleh kosong',
            'exists' => 'Nomor tidak terdaftar',
        ];
        $request->validate([
            'nim' => 'required|exists:anggota,nim',
        ],$message);

        //ambil anggota id
        $anggota = Anggota::where('nim',$request->nim)->first();

        $kunjungan = new Kunjungan;
        $kunjungan->anggota_id = $anggota->id;
        $kunjungan->waktu = date('Y-m-d H:i:s');
        $kunjungan->jenis = $request->simpan;
        $kunjungan->save();

        return redirect()->back()->with('success','Data Berhasil Disimpan');
    }
}
