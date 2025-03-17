@extends('adminlte::page')

@section('title', 'Edit Kategori')

@section('content_header')
    <h1>Edit Kategori</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Edit Kategori</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('kategori_update/' .$kategori->kategori_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="kode">Kategori Kode</label>
                    <input type="text" name="kategori_kode" class="form-control" value="{{ old('kode', $kategori->kategori_kode) }}" required>
                </div>

                <div class="form-group">
                    <label for="nama">Kategori Nama</label>
                    <input type="text" name="kategori_nama" class="form-control" value="{{ old('nama', $kategori->kategori_nama) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ url('/kategori') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
