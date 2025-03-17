<html>
    <head>
        <title>Tambah user</title>
    </head>
    <body>
        <h1>Form Tambah Data User</h1>
        <form method="POST" action="{{ url('/user/tambah_simpan') }}">
            {{ csrf_field() }}
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan Username">
            <br>
            <label>Nama</label>
            <input type="text" name="name" placeholder="Masukkan Nama">
            <br>
            <label>password</label>
            <input type="password" name="password" placeholder="Masukkan password">
            <br>
            <label>Level ID</label>
            <input type="number" name="level_id" placeholder="Masukkan ID Level">
            <br><br>
            <input type="submit" class="btn btn-success" value="simpan">
        </form>
    </body>
</html>