<?php

namespace App\Http\Controllers;

use App\Anggota;
use App\Buku;
use App\History;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {


        //chart berdasarkan jenis kelamin
        $jenis_kelamin =  Anggota::select('jenis_kelamin',DB::raw('count(transaksi.id) as total'))
            ->join('transaksi','transaksi.anggota_id','anggota.id')
            ->whereYear('tgl_pinjam', Carbon::now()->year)
            ->groupBy('jenis_kelamin')
            ->get()
        ;

        //chart berdasarkan pinjam dan kembali
        $transaksi_pinjam = Transaksi::withTrashed()
            ->select(
                DB::raw('MONTH(tgl_pinjam) bln'),
                DB::raw('MONTHNAME(tgl_pinjam) bulan'),
                DB::raw("COUNT(id) as pinjam"),
                DB::raw("SUM(IF(status='kembali',1,0)) as kembali")
            )
            ->whereYear('tgl_pinjam', Carbon::now()->year)
            ->groupBy('bulan','bln')
            ->orderBy('bln')
            ->get()
        ;

        // $list_bulan = $transaksi_pinjam->pluck('bulan')->toJson();
        // $list_pinjam = $transaksi_pinjam->pluck('pinjam')->toJson();
        // $list_kembali = $transaksi_pinjam->pluck('kembali')->toJson();

        $data = [
           'buku' =>  Buku::count(),
           'anggota' => Anggota::count(),
           'transaksi' => Transaksi::count(),
           'riwayat' => Transaksi::withTrashed()->count(),
           'jenis_kelamin' => $jenis_kelamin,
           'transaksi_pinjam' => $transaksi_pinjam,

        ];

        // dd($buku_kategori);
        return view('dashboard',$data);


    }
}
