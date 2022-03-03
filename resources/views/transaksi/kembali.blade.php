<form action="{{ route('transaksi.kembalikan',$transaksi->id) }}" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label>No Anggota</label>
                    <input type="text" placeholder="masukkan no anggota" name="nim"class="form-control" autocomplete="off" value="{{ $transaksi->anggota->nim }}" disabled>
                    @error('nim')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Buku</label>
                    <input type="text" name="judul" class="form-control" autocomplete="off" value="{{ $transaksi->buku->judul }}" disabled>
                    @error('buku_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Tgl Max Pinjam</label>
                    <input type="date" name="tgl_max_pinjam"class="form-control" value="{{ $transaksi->tgl_max_pinjam }}" disabled>
                    @error('tgl_max_pinjam')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali"class="form-control" value="{{ date('Y-m-d') }}" disabled>
                    @error('tgl_kembali')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea  name="ket"class="form-control" placeholder="optional">{{ $transaksi->ket }}</textarea>
                </div>

                <div class="float-right">

                    <button type="submit" class="btn btn-primary">Kembalikan</button>
                </div>
                </form>


