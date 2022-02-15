@extends('layouts.master')

@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-md-8 mt-4">
        <div class="card">
            <div class="card-body">
                <div class="card-header border-0">
                    <h3 class="my-3 text-center">{{ $title }}</h3>
                    @if(session('success'))
                        <div role="alert" class="alert alert-success alert-dismissible">
                            <span class="alert-inner--text">{{ session('success') }}</span>
                            <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div role="alert" class="alert alert-danger alert-dismissible">
                            <span class="alert-inner--text">{{ session('error') }}</span>
                            <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                    @endif
                </div>
                <form action="{{ route('kunjungan.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>No Anggota</label>
                    <input type="text" placeholder="masukkan no anggota" id="nim" name="nim"class="form-control" autocomplete="off" value="{{ old('nim') }}">
                    @error('nim')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" id="nama" name="nama"class="form-control" value="{{ old('nama') }}" disabled>
                </div>
                <div class="form-group">
                    <label>Tanggal lahir</label>
                    <input type="date" id="tgl_lahir" name="tgl_lahir"class="form-control" value="{{ old('tgl_lahir') }}" disabled>
                </div>
                <div class="form-group">
                    <label>No. Hp</label>
                    <input type="text" id="no_hp" name="no_hp"class="form-control" value="{{ old('no_hp') }}" disabled>
                </div>
                <div class="d-flex justify-content-between">
                    {{-- <a class="btn btn-danger" href="{{ route('transaksi.index') }}">Pulang</a>
                    <a class="btn btn-primary" href="{{ route('transaksi.index') }}">Masuk</a> --}}
                    <button type="submit" class="btn btn-danger" name="simpan" value="Pulang">Pulang</button>
                    <button type="submit" class="btn btn-primary" name="simpan" value="Masuk">Masuk</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
    <script>
        let timeout;
        $(document).ready(function(){

            $('#nim').keyup(function(){
                clearTimeout(timeout);
                timeout = setTimeout(function(){
                    $.ajax({
                        url: `{{ route('kunjungan.search.anggota') }}`,
                        type: 'GET',
                        data: {
                            nim: $('#nim').val()
                        },
                        success: function(data){
                            $('#nama').val(data.nama);
                            $('#tgl_lahir').val(data.tgl_lahir);
                            $('#no_hp').val(data.no_hp);
                        }
                    })
                }, 1000);
            })

        })
    </script>
@endpush
