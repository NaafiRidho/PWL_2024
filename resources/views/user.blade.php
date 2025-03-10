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
            <tr>
                <td>{{$user->user_id}}</td>    
                <td>{{$user->username}}</td> 
                <td>{{$user->name}}</td> 
                <td>{{$user->level_id}}</td>
            </tr>    
        </table>
    </body>
</html>