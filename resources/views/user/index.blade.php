@extends('layout.app')

@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title">{{ $page->title }}</h3>
      <div class="card-tools">
        <button onclick="modalAction('{{ url('/user/import') }}')" class="btn btn-info btn-sm mt-1">Import Barang</button>
        <a href="{{ url('/user/export_excel') }}" class="btn btn-primary btn-sm mt-1"><i class="fa fa-file-excel"></i> Export Barang</a>
        <a href="{{ url('/user/export_pdf') }}" class="btn btn-warning btn-sm mt-1"><i class="fa fa-file-pdf"></i> Export Barang</a>
        <button onclick="modalAction('{{url('user/create_ajax')}}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
      </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{session('error')}}</div>
        @endif
        <div class="row">
          <div class="col-md-12">
            <div class="form-group row">
              <label for="name" class="col-1 control-label col-form-label">Filer:</label>
              <div class="col-3">
                <select class="form-control" name="level_id" id="level_id">
                  <option value="">- SEMUA -</option>
                @foreach($level as $item)
                  <option value="{{$item->level_id}}">{{$item->level_nama}}</option>
                @endforeach
                </select>
                <small class="form-text text-muted">Level Pengguna</small>
              </div>
            </div>
          </div>
        </div>
      <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>Level Pengguna</th>
            <th>Aksi</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@push('css')
@endpush

@push('js')
<script>
  function modalAction(url = ''){
    $('#myModal').load(url,function(){
        $('#myModal').modal('show');
    });
}

  $(document).ready(function() {
    window.dataUser = $('#table_user').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ url('user/list') }}",
        dataType: "json",
        type: "POST",
        data: function(e){
          e.level_id = $('#level_id').val()
        }
      },
      columns: [
        {
          data: "DT_RowIndex",
          className: "text-center",
          orderable: false,
          searchable: false
        },
        {
          data: "username",
          className: "",
          orderable: true,
          searchable: true
        },
        {
          data: "name",
          className: "",
          orderable: true,
          searchable: true
        },
        {
          data: "level.level_nama",
          className: "",
          orderable: false,
          searchable: false
        },
        {
          data: "aksi",
          className: "",
          orderable: false,
          searchable: false
        }
      ]
    });
    $('#level_id').on('change', function(){
      dataUser.ajax.reload();
    })
  });
</script>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
 data-width="75%" aria-hidden="true"></div>
@endpush
