
<div class="card mb-3">
    <div class="row">
        <div class="col-md-4 pl-3">
            <img class="border border-secondary rounded" width="100%" src="{{ asset($buku->gambar ? 'storage/'.$buku->gambar : 'assets/img/system/Book-icon.png') }}" />
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <div class="card-text">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"> {{ $buku->judul }}</li>
                        <li class="list-group-item">Edisi : {{ $buku->edisi }}</li>
                        <li class="list-group-item">Penerbit : {{ $buku->penerbit }}</li>
                        <li class="list-group-item">Tahun : {{ $buku->tahun_terbit }}</li>
                        <li class="list-group-item">Stok : {{ $buku->jumlah_buku }}</li>
                    </ul>
                </div>
                <div class="card-text text-right"><small class="text-muted">{{  $buku->penulis }}</small></div>
            </div>
        </div>
    </div>
</div>

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
