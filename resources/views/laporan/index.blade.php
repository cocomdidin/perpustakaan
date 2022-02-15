@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12 mt-4">
                <div class="card">
                  <div class="card-header">
                    <div class="row align-items-center">
                      <div class="col">
                        <h3 class="mb-0">Laporan Anggota & Transaksi </h3>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                            <div class="card-text mb-2"><i class="ni ni-book-bookmark"></i> Buku</div>
                            <section class="buku">
                                <a class="btn btn-danger " href="{{ route('buku.pdf') }}" target="_blank"><i class="ni ni-cloud-download-95"></i> Export Pdf</a>
                                <a class="btn btn-success" href="{{ route('buku.excel') }}" target="_blank">
                                 <i class="ni ni-cloud-download-95"></i> Export Excel</a>
                            </section>
                          </div>
                       <div class="col-md-6 text-right">
                            <div class="card-text mb-2 ">Transaksi <i class="ni ni-ruler-pencil"></i></div>
                                <section class="transaksi">
                                    <a class="btn btn-danger " href="{{ route('transaksi.pdf') }}" target="_blank"><i class="ni ni-cloud-download-95"></i> Export Pdf</a>
                                    <a class="btn btn-success " href="{{ route('transaksi.excel') }}"><i class="ni ni-cloud-download-95"></i>  Export Excel</a>
                                </section>
                            </div>
                       </div>
                      </div>
                </div>

                <div class="card">
                  <div class="card-header">
                    <div class="row align-items-center">
                      <div class="col">
                        <h3 class="mb-0">Laporan Kunjungan </h3>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">


                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th scope="col" class="sort" data-sort="nim">No Anggota</th>
                                            <th scope="col" class="sort" data-sort="nama">Nama</th>
                                            <th scope="col" class="sort" data-sort="waktu">Waktu</th>
                                            <th scope="col" class="sort" data-sort="jenis">jenis</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @foreach ($kunjungan as $key => $item)
                                            <tr>
                                                <td>
                                                    {{ $kunjungan->firstItem() + $key }}
                                                </td>
                                                <td>
                                                    {{ $item->anggota->nim }}
                                                </td>
                                                <td>
                                                    {{ $item->anggota->nama }}
                                                </td>
                                                <td>
                                                    {{ $item->waktu }}
                                                </td>
                                                <td>
                                                    {{ $item->jenis }}
                                                </td>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                      </div>
                </div>
                <!-- Card footer -->
                <div class="card-footer py-4">
                    <nav aria-label="...">

                        {{-- pagination --}}
                        @if ($kunjungan->lastPage() != 1)
                            <ul class="pagination justify-content-end mb-0">
                                <li class="page-item">
                                    <a class="page-link" href="{{ $kunjungan->previousPageUrl() }}" tabindex="-1">
                                        <i class="fas fa-angle-left"></i>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $kunjungan->lastPage(); $i++)
                                    <li class="page-item {{ $i == $kunjungan->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $kunjungan->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item">
                                    <a class="page-link" href="{{ $kunjungan->nextPageUrl() }}">
                                        <i class="fas fa-angle-right"></i>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        @endif

                        @if (count($kunjungan) == 0)
                            <div class="text-center"> Tidak ada data!</div>
                        @endif

                    </nav>
                </div>
              </div>
        </div>
    </div>
@endsection
