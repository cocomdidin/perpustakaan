@extends('layouts.master')
@section('content')
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="my-3 text-center">{{ $title }}</h3>
                    <div class="success" data-flash="{{ session()->get('success') }}"></div>
                </div>
                <div class="card-body">
                    <form action="{{ route('buku.update',$buku->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Kode</label>
                                    <input type="text" name="kode" value="{{ old('kode', $buku->kode) }}" class="form-control">
                                    @error('kode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">ISBN</label>
                                    <input type="text" name="isbn" value="{{ old('isbn', $buku->isbn) }}" class="form-control">
                                    @error('isbn')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Judul</label>
                                    <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" class="form-control">
                                    @error('judul')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Edisi</label>
                                    <input type="text" name="edisi" value="{{ old('edisi', $buku->edisi) }}" class="form-control">
                                    @error('edisi')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Pengarang</label>
                                    <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}" class="form-control">
                                    @error('penulis')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    @php($img = old('gambar', $buku->gambar))
                                    <img width="150" height="150" src="{{ asset($img ? 'storage/'.$img : 'assets/img/system/Book-icon.png') }}"/>
                                    <input type="file" name="gambar" id="" class="uploads form-control mt-2">
                                    @error('gambar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Penerbit</label>
                                    <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" class="form-control">
                                    @error('penerbit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Tahun Terbit</label>
                                    <input type="number" min="0" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" class="form-control">
                                    @error('tahun_terbit')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Stock</label>
                                    <input type="number" min="0" name="jumlah_buku" value="{{ old('jumlah_buku', $buku->jumlah_buku) }}" class="form-control">
                                    @error('jumlah_buku')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Lokasi</label>
                                    <select name="lokasi" class="form-control">
                                        <option value="" disabled selected>-- Pilih Rak --</option>
                                        @foreach($rak as $rk)
                                            <option @if(old('lokasi', $buku->rak_id)==$rk->id) selected @endif value="{{ $rk->id }}">{{ $rk->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('lokasi')
                                            <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Deskripsi</label>

                                    <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                            <button type="button" class="btn btn-danger" onclick="history.back()">Batal</button>
                            <button type="submit" class="btn btn-primary ">simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal')
@endsection

@push('script')
    <script>


        //show gambar
        function readURL() {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(input).prev().attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function () {
            $(".uploads").change(readURL)
            $("#f").submit(function(){
                return false
            })
        })

        $(document).ready(function(){

            //session flash success
            let success = $('.success').data('flash');
            if (success) {
                Swal.fire({
                    position: 'center',
                    type: 'success',
                    title: success,
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        })
    </script>
@endpush
