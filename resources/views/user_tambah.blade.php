    <body>
        <h1>Form Tambah Data User</h1>
        <form method="post" action="{{Route('user.tambah.simpan')}}">

            {{ csrf_field() }}
            
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan Username">
            <br>
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Masukkan nama">
            <br>
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password">
            <br>
            <label>Level ID</label>
            <input type="number" name="level_id" placeholder="Masukkan ID Level">
            <br><br>
            <input type="submit" class="btn btn-success" value="Simpan">
        </form>
    </body>