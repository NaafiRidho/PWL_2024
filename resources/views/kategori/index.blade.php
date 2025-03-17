@extends('layout.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Kategori')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-muted">Manage Kategori</h1>
        <a href="{{ url('/kategori/create') }}" class="btn btn-primary">Add Kategori</a>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Kategori</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
