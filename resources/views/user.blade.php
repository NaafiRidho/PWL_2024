<html>
    <head>
        <title>Bata User</title>
    </head>
    <body>
        <h1>Data User</h1>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <TH>Username</TH>
                <th>Nama</th>
                <th>ID level Pengguna</th>
            </tr>
            @foreach ($user as $item)
            <tr>
                <td>{{$item->user_id}}</td>    
                <td>{{$item->username}}</td> 
                <td>{{$item->name}}</td> 
                <td>{{$item->level_id}}</td>
            </tr>    
            @endforeach
        </table>
    </body>
</html>