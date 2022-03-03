<?php

namespace App\Http\Controllers;

use App\Anggota;
use App\Buku;
use App\Transaksi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Daftar Transaksi';
        $carbon = new \Carbon\Carbon();
        $transaksi = Transaksi::with('anggota','buku','user')->orderBy('created_at','desc')->paginate(6);
        return view('transaksi.index',compact('title','transaksi','carbon'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('transaksi.create',[
            'title' => 'Tambah Transaksi Pinjam Buku',
            'buku' => Buku::orderBy('judul','asc')->get(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            'required' => 'Tidak boleh kosong',
            'exists' => 'Nomor tidak terdaftar',
            'date' => 'Format tanggal salah',
            'after_or_equal' => 'Tanggal harus lebih besar dari tanggal pinjam',
        ];
        $request->validate([
            'nim' => 'required|exists:anggota,nim',
            'buku_id' => 'required',
            'tgl_pinjam' => 'required|date',
            'tgl_max_pinjam' => 'required|date|after_or_equal:tgl_pinjam',
        ],$message);

        //ambil anggota id
        $anggota = Anggota::where('nim',$request->nim)->first();

        //tolak jika anggota sudah pinjam
        if (Transaksi::where('anggota_id',$anggota->id)->where('status','pinjam')->exists()) {
            session()->flash('fail','sorry, masih ada buku yang anda pinjam');

            return redirect('transaksi');
            exit;
        }

        $transaksi = Transaksi::create([

            'anggota_id' => $anggota->id,
            'kode_transaksi' => Str::random(10),
            'buku_id' => $request->buku_id,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_max_pinjam' => $request->tgl_max_pinjam,
            'status' => 'pinjam',
            'ket' => $request->ket,
            'user_id' => Auth::user()->id
        ]);

        //jika transaksi dilakukan maka stock buku akan berkurang
        $transaksi->buku->where('id',$transaksi->buku_id)->update(['jumlah_buku' => $transaksi->buku->jumlah_buku -1]);
        return redirect('transaksi')->with('success','transaksi anda berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaksi = Transaksi::with('buku','anggota','user')->find($id);
        return view('transaksi.show',compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $transaksi = Transaksi::with('buku','anggota','user')->find($id);
        // $buku = Buku::get();
        return view('transaksi.edit',compact('transaksi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = ['required' => 'atribute tidak boleh kosong' ];
        $request->validate([
            'tgl_pinjam' => 'required|date',
            'tgl_max_pinjam' => 'required|date',
        ],$message);

        //update transaksi
        $transaksi = Transaksi::find($id);
        $transaksi->update([
            'tgl_pinjam' => $request->tgl_pinjam ?? $transaksi->tgl_pinjam,
            'tgl_max_pinjam' => $request->tgl_max_pinjam ?? $transaksi->tgl_max_pinjam,
            'ket' => $request->ket ?? $transaksi->ket,
            'user_id' => Auth::user()->id
        ]);

          //jika transaksi dilakukan maka stock buku akan berkurang
        //   $transaksi->buku->where('id',$transaksi->buku_id)->update(['jumlah_buku' => $transaksi->buku->jumlah_buku +1]);

        return redirect('transaksi')->with('success','transaksi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaksi::find($id)->delete();
        return redirect('transaksi')->with('success','data berhasil dihapus');
    }

    public function search(Request $request){
        $title = 'Daftar Transaksi';

        //cari dengan kode_transaksi
        $cari = $request->input('q');
            if ($cari) {
                $transaksi = Transaksi::join('anggota','anggota.id','=','transaksi.anggota_id')
                ->join('buku','buku.id','=','transaksi.buku_id')
                ->where('transaksi.kode_transaksi','LIKE',"%$cari%")
                ->orWhere('buku.judul','LIKE',"%$cari%")
                ->orWhere('anggota.nama','LIKE',"%$cari%")
                ->orWhere('anggota.nim','LIKE',"%$cari%")
                ->paginate();
            } else {
                $transaksi = Transaksi::paginate();
            }

        return view('transaksi.index',compact('title','transaksi','cari'));

    }

    public function kembali(Request $request, $id)
    {
        $transaksi = Transaksi::with('buku','anggota','user')->find($id);

        return view('transaksi.kembali',compact('transaksi'));
    }

    public function kembalikan(Request $request, $id)
    {
        //update transaksi
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->tgl_kembali = date('Y-m-d');
        try {
            DB::beginTransaction();

            $transaksi->update([
                'tgl_kembali' => $request->tgl_kembali ?? $transaksi->tgl_kembali,
                'status' => 'kembali',
                'jumlah_hari_telat' => $transaksi->terlambat,
                'total_denda' => $transaksi->denda,
                'ket' => $request->ket ?? $transaksi->ket,
                'user_id' => Auth::user()->id
            ]);

            //jika transaksi dilakukan maka stock buku akan berkurang
            $transaksi->buku->where('id',$transaksi->buku_id)->update(['jumlah_buku' => $transaksi->buku->jumlah_buku +1]);

            DB::commit();
            return redirect('transaksi')->with('success','Buku berhasil dikembalikan');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('transaksi')->with('fail','Buku gagal dikembalikan');
        }
    }
}
