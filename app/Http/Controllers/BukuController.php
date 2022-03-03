<?php

namespace App\Http\Controllers;

use App\Buku;
use App\Rak;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('buku.index',[
            'title' => 'Daftar Buku',
            'buku' => Buku::orderBy('judul','asc')->paginate(),
            'rak' => Rak::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|max:50|unique:buku',
            'isbn' => 'required|unique:buku',
            'judul' => 'required|max:255|unique:buku',
            'edisi' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'jumlah_buku' => 'required',
            'lokasi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,svg'

        ],[
            'required' => 'Tidak boleh kosong',
            'unique' => 'Sudah digunakan',
            'max' => 'Karakter max 255',
            'image' => 'Harus gambar',
            'mimes' => 'Harus format jpg,jpeg,png atau svg'
        ]);

        //request file gambar jika ada tambahkan dan jika kosong
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = $file->store('img/buku');
        }

        //insert to database buku
        Buku::create([
            'kode' => $request->kode,
            'isbn' => $request->isbn,
            'judul' => $request->judul,
            'edisi' => $request->edisi,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'jumlah_buku' => $request->jumlah_buku,
            'deskripsi' => $request->deskripsi,
            'rak_id' => $request->lokasi,
            'gambar' => $fileName ?? '',
            'created_at' => Carbon::now()
        ]);

        //session success
        return redirect('buku')->with('success','buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.show',compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit Buku';
        $buku = Buku::find($id);
        $rak = Rak::all();
        return view('buku.formEdit',compact(['title','buku','rak']));
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
        $request->validate([
            'kode' => 'required|max:50|unique:buku,kode,'.$id,
            'isbn' => 'required|unique:buku,isbn,'.$id,
            'judul' => 'required|max:255|unique:buku,judul,'.$id,
            'edisi' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'jumlah_buku' => 'required',
            'lokasi' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,svg'

        ],[
            'required' => 'Tidak boleh kosong',
            'unique' => 'Sudah digunakan',
            'max' => 'Karakter max 255',
            'image' => 'Harus gambar',
            'mimes' => 'Harus format jpg,jpeg,png atau svg'
        ]);

        $buku = Buku::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            Storage::delete($buku->gambar);
            $fileName = $file->store('img/buku');
        }

        $buku->update([
            'kode' => $request->kode ?? $buku->kode,
            'judul' => $request->judul ?? $buku->judul,
            'edisi' => $request->edisi ?? $buku->edisi,
            'isbn' => $request->isbn ?? $buku->isbn,
            'penulis' => $request->penulis ?? $buku->penulis,
            'penerbit' => $request->penerbit ?? $buku->penerbit,
            'tahun_terbit' => $request->tahun_terbit ?? $buku->tahun_terbit,
            'jumlah_buku' => $request->jumlah_buku ?? $buku->jumlah_buku,
            'rak_id' => $request->lokasi ?? $buku->lokasi,
            'gambar' => $fileName ?? $buku->gambar,
            'deskripsi' => $request->deskripsi ?? $buku->deskripsi,
            'updated_at' => Carbon::now()
        ]);

        return redirect('buku')->with('success','buku berhasil diupate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);
        Storage::delete($buku->gambar);
        $buku->delete();
        return redirect('buku')->with('success','data berhasil dihapus');

    }

    // pencarian
    public function search(Request $request){

        $cari = $request->q;
        if ($cari) {
            $buku = Buku::where('judul','LIKE',"%$cari%")
            ->orWhere('isbn','LIKE',"%$cari%")
            ->orWhere('kode','LIKE',"%$cari%")
            ->orWhere('penulis','LIKE',"%$cari%")
            ->paginate();
        } else {
            return redirect('buku');
        }

        return view('buku.index',[
            'title' => 'Daftar Buku',
            'buku' => $buku,
            'rak' => Rak::all(),
            'cari' => $cari
        ]);
    }
}
