<html>
    <head>
        <title>Bata Level Pengguna</title>
    </head>
    <body>
        <h1>Data Level Pengguna</h1>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <TH>Kode Level</TH>
                <th>Nama Level</th>
            </tr>
            @foreach ($data as $item)
            <tr>
                <td>{{$item->level_id}}</td>    
                <td>{{$item->level_kode}}</td> 
                <td>{{$item->level_nama}}</td> 
            </tr>    
            @endforeach
        </table>
    </body>
</html>