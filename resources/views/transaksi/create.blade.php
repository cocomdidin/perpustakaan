@extends('layouts.master')

@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-md-8 mt-4">
        <div class="card">
            <div class="card-body">
                <div class="card-header border-0">
                    <h3 class="my-3 text-center">{{ $title }}</h3>
                </div>
                <form action="{{ route('transaksi.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>No Anggota</label>
                    <input type="text" placeholder="masukkan no anggota" name="nim"class="form-control" autocomplete="off" value="{{ old('nim') }}">
                    @error('nim')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Buku</label>
                    <select name="buku_id" class="form-control">
                        <option disabled selected>-- Pilih Buku --</option>
                        @foreach ($buku as $item)
                        <option @if(old('buku_id') == $item->id) selected @endif value="{{ $item->id }}">{{ $item->judul }}</option>
                        @endforeach
                    </select>
                    @error('buku_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Tanggal Pinjam</label>
                    <input type="date" id="tgl_pinjam" name="tgl_pinjam"class="form-control" value="{{ old('tgl_pinjam') ?? now()->format('Y-m-d') }}">
                    @error('tgl_pinjam')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Tgl Max Pinjam</label>
                    <input type="date" id="tgl_max_pinjam" name="tgl_max_pinjam"class="form-control" value="{{ old('tgl_max_pinjam') ?? now()->addDays(2)->format('Y-m-d') }}">
                    @error('tgl_max_pinjam')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea  name="ket"class="form-control" placeholder="optional" value = {{ old('ket') }}></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <small class="text-primary">NB : Jika buku dikembalikan melebihi tanggal maksimal penjam maka akan terkena denda kelipatan stiap harinya</small>
                    <a class="btn btn-danger" href="{{ route('transaksi.index') }}">kembali</a>
                    <button type="submit" class="btn btn-primary">simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
    <script>
        $(document).ready(function () {

            $('#tgl_pinjam').change(function (e) {
                let tgl_pinjam = $(this).val();
                let tgl_max_pinjam = new Date(tgl_pinjam);
                tgl_max_pinjam.setDate(tgl_max_pinjam.getDate() + 2);
                $('#tgl_max_pinjam').val(tgl_max_pinjam.toISOString().slice(0, 10));
            });
        });
    </script>
@endpush
