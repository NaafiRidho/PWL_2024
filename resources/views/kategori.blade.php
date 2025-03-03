<html>
    <head>
        <title>Bata kategori Pengguna</title>
    </head>
    <body>
        <h1>Data kategori Pengguna</h1>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <TH>Kode Kategori</TH>
                <th>Nama Kategori</th>
            </tr>
            @foreach ($data as $item)
            <tr>
                <td>{{$item->kategori_id}}</td>    
                <td>{{$item->kategori_kode}}</td> 
                <td>{{$item->kategori_nama}}</td> 
            </tr>    
            @endforeach
        </table>
    </body>
</html>