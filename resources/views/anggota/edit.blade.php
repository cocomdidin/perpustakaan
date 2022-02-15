<form action="{{ route('anggota.update',$anggota->id) }}" method="post">
@csrf
@method('put')
<div class="form-group">
    <label>Nama</label>
    <input type="text" name="nama"  class="form-control" value="{{ $anggota->nama }}">
</div>
<div class="form-group">
    <label>No Anggota</label>
    <input type="number" name="nim"  class="form-control" value="{{ $anggota->nim }}">
</div>
<div class="form-group">
    <label>No HP</label>
    <input type="number" name="no_hp"  class="form-control" value="{{ $anggota->no_hp }}">
</div>

<div class="form-group">
    <label>Tgl Lahir</label>
    <input type="date" name="tgl_lahir"  class="form-control" value="{{ $anggota->tgl_lahir }}">
</div>
<div class="form-group">
    <label>Kelas</label>
    <input type="text" name="jurusan"  class="form-control" value="{{ $anggota->jurusan }}">
</div>
<div class="form-group">
    <label>Jenis Kelamin</label>
    <select name="jenis_kelamin" class="form-control">
        <option selected disabled>-- Pilih Jenis Kelamin -- </option>
        <option @if($anggota->jenis_kelamin=='pria') selected @endif value="pria">Pria</option>
        <option @if($anggota->jenis_kelamin=='wanita') selected @endif value="wanita">Wanita</option>
    </select>

</div>
<div class="form-group">
    <label>Petugas</label>
    <select name="user_id"  class="form-control">
        <option selected disabled>-- Pilih Petugas -- </option>
        @foreach ($users as $item)
        <option @if($anggota->user_id == $item->id) selected @endif value="{{ $item->id }}"> {{  $item->level }}</option>
        @endforeach
    </select>
</div>
<div class="float-right">
    <button type="submit" class="btn btn-primary">Update</button>
</div>
</form>
