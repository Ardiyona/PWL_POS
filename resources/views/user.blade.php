<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Data User</title>
    </head>
    <body>
        <h1>Data User</h1>
        {{-- <table border="1" cellpadding="1" cellspacing="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th>
            </tr>
            @foreach ($data as $d)
                <tr>
                    <td>{{ $d->user_id}}</td>
                    <td>{{ $d->username}}</td>
                    <td>{{ $d->nama}}</td>
                    <td>{{ $d->level_id}}</td>
                </tr>
            @endforeach
        </table> --}}
        <table border="1" cellpadding="1" cellspacing="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th>
            </tr>
            <tr>
                <td>{{ $data->user_id}}</td>
                <td>{{ $data->username}}</td>
                <td>{{ $data->nama}}</td>
                <td>{{ $data->level_id}}</td>
            </tr>
        </table>
    </body>
</html>