<form action="{{ route('transaksi.kembalikan',$transaksi->id) }}" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label>NIM Mahasiswa</label>
                    <input type="text" placeholder="masukkan nim" name="nim"class="form-control" autocomplete="off" value="{{ $transaksi->anggota->nim }}" disabled>
                    @error('nim')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Buku</label>
                    {{-- <select name="buku_id" class="form-control" disabled>
                        <option disabled selected>-- Pilih Buku --</option>
                        @foreach ($buku as $item)
                        <option @if($transaksi->buku->id == $item->id) selected @endif value="{{ $item->id }}">{{ $item->judul }}</option>
                        @endforeach
                    </select> --}}
                    <input type="text" name="judul" class="form-control" autocomplete="off" value="{{ $transaksi->buku->judul }}" disabled>
                    @error('buku_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- <div class="form-group">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="tgl_pinjam"class="form-control" value="{{ $transaksi->tgl_pinjam }}">
                    @error('tgl_pinjam')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div> --}}
                <div class="form-group">
                    <label>Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali"class="form-control" value="{{ $transaksi->tgl_kembali }}">
                    @error('tgl_kembali')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- <div class="form-group">
                    <label for="">Status</label>
                    <select name="status" class="form-control">
                        <option disabled selected>-- Pilih Status --</option>
                        <option @if($transaksi->status == 'pinjam') selected @endif value="pinjam">Pinjam</option>
                        <option @if($transaksi->status == 'kembali') selected @endif value="kembali">Kembali</option>
                    </select>
                </div> --}}
                @if ($transaksi->ket)
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea  name="ket"class="form-control" placeholder="optional">{{ $transaksi->ket }}</textarea>
                    </div>
                @endif

                <div class="float-right">

                    <button type="submit" class="btn btn-primary">Kembalikan</button>
                </div>
                </form>


