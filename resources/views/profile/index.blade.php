@extends('layout.app')

@section('content')
  <div class="card card-outline card-primary">
    <div class="card-header">
      <h3 class="card-title">Profil Pengguna</h3>
      <div class="card-tools">
        <a class="btn btn-sm btn-primary mt-1" href="{{ url('profile/edit') }}">Edit Profil</a>
      </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-3">
                <!-- Gambar profil dengan button untuk mengganti gambar -->
                <img id="profile-image" src="{{ asset($user->photo ? $user->photo : 'images/default-avatar.jpg') }}" class="img-fluid" alt="Profile Image">
                <br>
                <button id="change-photo-btn" class="btn btn-sm btn-info mt-2">Ubah Foto</button>
            </div>
            <div class="col-md-9">
                <h4>{{ $user->username }}</h4>
                <p>Name: {{ $user->name }}</p>
                <p>Level: {{ $user->level->level_nama ?? 'N/A' }}</p> <!-- Jika ada relasi dengan level -->
                <p>Password: *******</p>
            </div>
        </div>

        <!-- Modal untuk mengganti foto -->
        <div id="change-photo-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Ubah Foto Profil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <form id="change-photo-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                  <div class="form-group">
                    <label for="foto">Pilih Foto Baru:</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan Foto</button>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
  </div>
@endsection

@push('css')
<!-- Tambahkan CSS jika diperlukan -->
@endpush

@push('js')
<script>
  $(document).ready(function () {
    // Ketika tombol "Ubah Foto" diklik, tampilkan modal
    $('#change-photo-btn').click(function () {
      $('#change-photo-modal').modal('show');
    });

    // AJAX untuk mengubah foto profil
    $('#change-photo-form').submit(function (e) {
      e.preventDefault();

      var formData = new FormData(this); // Ambil data form

      $.ajax({
        url: "{{ route('profile.updateFoto') }}", // Ganti dengan route yang sesuai
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if (response.success) {
            // Update gambar profil dengan gambar baru
            $('#profile-image').attr('src', response.new_image_url);
            $('#change-photo-modal').modal('hide');
            alert('Foto profil berhasil diubah');
          } else {
            alert('Terjadi kesalahan saat mengubah foto profil');
          }
        },
        error: function (xhr, status, error) {
          alert('Terjadi kesalahan: ' + error);
        }
      });
    });
  });
</script>
@endpush
