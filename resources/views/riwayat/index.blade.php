@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="card">
              <div class="card-header border-0">
                <div class="row align-items-center">
                  <div class="col">
                    <h3 class="text-left">{{ $title }}</h3>
                  </div>
                  <div class="col text-right">
                    @if($section == 'all')
                        <a href="{{ route('riwayat.index') }}" class="btn btn-primary">Tampilkan Sebagian</a>
                    @else
                        <a href="{{ route('riwayat.all') }}" class="btn btn-primary">Tampilkan semua</a>
                    @endif
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">No Anggota</th>
                        <th scope="col">Kode Transaksi</th>
                        <th scope="col">Judul Buku</th>
                        <th scope="col">Tanggal Pinjam</th>
                        <th scope="col">Status</th>
                        <th scope="col">Terlambat</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($transaksi as $item)
                        <tr>
                            <th scope="row">
                                <div class="media align-items-center">
                                    <div class="media-body">
                                        <span class="name mb-0 text-sm">{{ $item->anggota->nama }}</span>
                                    </div>
                                </div>
                            </th>
                            <td class="budget">
                                {{ $item->anggota->nim }}
                            </td>
                            <td>
                                <span class="status">{{ $item->kode_transaksi }}</span>
                            </td>
                            <td>{{ $item->buku->judul }}</td>
                            <td>{{ $item->tgl_pinjam }} <span class="text-muted">s/d</span> {{ $item->tgl_max_pinjam }}</td>
                            <td>
                                @if ($item->status == 'pinjam')
                                    <span class="badge badge-dot mr-4">
                                        <i class="bg-danger"></i>
                                        <span class="text-capitalize">{{ $item->status }}</span>
                                    </span>
                                @else
                                    <span class="badge badge-dot mr-4">
                                        <i class="bg-success"></i>
                                        <small class="text-capitalize">{{ $item->status }}</small>
                                    </span>
                                    <div>{{ $item->tgl_kembali }}</div>
                                @endif
                            </td>
                            <td>
                                <div>{{ $item->terlambat }} hari</div>
                                @if ($item->terlambat > 0)
                                    <small class="text-danger">Rp. {{ number_format($item->denda, 0, ',', '.') }}</small>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    @endsection
