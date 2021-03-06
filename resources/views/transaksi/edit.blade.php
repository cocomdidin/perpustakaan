<form action="{{ route('transaksi.update',$transaksi->id) }}" method="post">
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
                <div class="form-group">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="tgl_pinjam"class="form-control" value="{{ $transaksi->tgl_pinjam }}">
                    @error('tgl_pinjam')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Tgl Max Pinjam</label>
                    <input type="date" name="tgl_max_pinjam"class="form-control" value="{{ $transaksi->tgl_max_pinjam }}">
                    @error('tgl_max_pinjam')
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

                    <button type="submit" class="btn btn-primary">update</button>
                </div>
                </form>


