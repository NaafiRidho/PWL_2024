<html>
    <header>
        <title>Mengubah data User</title>
    </header>
    <body>
        <h1>Form Ubah Data User</h1>
        <a href="/user">Kembali</a>
        <br>
        <form method="post" action="{{url('/user/ubah_simpan/'.$data->user_id)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}

            <label for="">Username</label>
            <input type="text" name="username" placeholder="Masukkan Username" value="{{$data->username}}">
            <br>
            <label>Nama</label>
            <input type="text" name="name" placeholder="Masukkan Nama" value="{{$data->name}}">
            <br>
            <label>password</label>
            <input type="password" name="password" placeholder="Masukkan password" value="{{$data->password}}">
            <br>
            <label>Level ID</label>
            <input type="number" name="level_id" placeholder="Masukkan ID Level" value="{{$data->level_id}}">
            <br><br>
            <input type="submit" class="btn btn-success" value="simpan">
        </form>
    </body>
</html>