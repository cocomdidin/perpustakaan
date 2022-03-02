<form action="{{ route('buku.update',$buku->id) }}" method="post" enctype="multipart/form-data">
@csrf
@method('put')
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="">Kode</label>
            <input type="text" name="kode" value="{{ $buku->kode }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">ISBN</label>
            <input type="text" name="isbn" value="{{ $buku->isbn }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Judul</label>
            <input type="text" name="judul" value="{{ $buku->judul }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Edisi</label>
            <input type="text" name="edisi" value="{{ $buku->edisi }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Pengarang</label>
            <input type="text" name="penulis" value="{{ $buku->penulis }}" class="form-control">
        </div>
        <div class="form-group">
            <img width="150" height="150" @if($buku->gambar) src="{{ asset('Storage/'.$buku->gambar) }}" @endif />
            <input type="file" name="gambar" value="{{ $buku->gambar }}" class="uploads form-control mt-2">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="">Penerbit</label>
            <input type="text" name="penerbit" value="{{ $buku->penerbit }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Tahun</label>
            <input type="number" name="tahun_terbit" value="{{ $buku->tahun_terbit }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Stok</label>
            <input type="number" name="jumlah_buku" value="{{ $buku->jumlah_buku }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Lokasi</label>
            <select name="lokasi" class="form-control">
                <option disabled selected>--pilih rak --</option>
                @foreach($rak as $rk)
                    <option @if($buku->rak_id == $rk->id) selected @endif value="{{ $rk->id }}">{{ $rk->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="form-control">{{ $buku->deskripsi }}</textarea>
        </div>
    </div>
</div>
<div class="float-right">
    <button type="reset" class="btn btn-danger">reset</button>
    <button type="submit" class="btn btn-primary">update</button>
</div>
</form>

<script>
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

</script>
