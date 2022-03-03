<?php

namespace App\Http\Controllers;

use App\Anggota;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('anggota.index',[
            'title' => 'Daftar Anggota',
            'anggota' =>  Anggota::orderBy('nama','asc')->paginate(4),
            'users' => User::get()
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
        //validasi
        $message = [
            'required' => 'Tidak boleh kosong',
            'unique' => 'Sudah digunakan',
            'numeric' => 'Harus angka',
            'email' => 'Email tidak valid',
        ];

        $request->validate([
            'email' => 'required|unique:users|email',
            'nama' => 'required',
            'nim' => 'required|unique:anggota|numeric',
            'no_hp' => 'required|numeric',
            'tgl_lahir' => 'required',
            'jurusan' => 'required',
            'jenis_kelamin' => 'required',
        ],$message);

        try {
            DB::beginTransaction();

            //create user
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'level' => 'anggota',
                'name' => $request->nama,
            ]);

            //insert DB Anggota
            Anggota::create([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'no_hp' => $request->no_hp,
                'tgl_lahir' => $request->tgl_lahir,
                'jurusan' => $request->jurusan,
                'jenis_kelamin' => $request->jenis_kelamin,
                'user_id' => $user->id
            ]);

            DB::commit();
            return back()->with('success','Anggota berhasil ditambahkan. Silahkan login dengan email dan password 12345678.');
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('success','Anggota gagal ditambahkan');
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $anggota = Anggota::with('user')->find($id);
        return view('anggota.show',compact('anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $anggota = Anggota::with('user')->find($id);
        $users = User::get();
        return view('anggota.edit',compact('anggota','users'));
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
       $anggota =  Anggota::find($id);
       $anggota->update([
            'nama' => $request->nama ?? $anggota->nama,
            'nim' => $request->nim ?? $anggota->nim,
            'no_hp' => $request->no_hp ?? $anggota->no_hp,
            'tgl_lahir' => $request->tgl_lahir ?? $anggota->tgl_lahir,
            'jurusan' => $request->jurusan ?? $anggota->jurusan,
            'jenis_kelamin' => $request->jenis_kelamin ?? $anggota->jenis_kelamin,
            'user_id' => $request->user_id ?? $anggota->user_id
       ]);
       return redirect('anggota')->with('success','anggota berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Anggota::find($id)->delete();
        return redirect('anggota')->with('success','anggota berhasil dihapus');
    }

    public function search(Request $request){

        $cari = $request->get('q');
        $anggota = Anggota::where('nim','LIKE',"%$cari%")->orWhere('nama','LIKE',"%$cari%")->paginate();
        return view('anggota.index',[
            'title' => 'Daftar Anggota',
            'anggota' =>  $anggota,
            'users' => User::get()
        ]);

    }
}
