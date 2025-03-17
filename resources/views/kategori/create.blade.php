@extends('layout.app');
@section('subtitle','kategori');
@section('content_header_title','kategori');
@section('content_header_subtitle','create');

@section('content')
<form method="POST" action="{{ url('/kategori') }}">
    @csrf
    <div class="form-group">
        <label for="kodeKategori">Kode Kategori</label>
        <input type="text" class="form-control" name="kategori_kode" required>
    </div>
    <div class="form-group">
        <label for="namaKategori">Nama Kategori</label>
        <input type="text" class="form-control" name="kategori_nama" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection