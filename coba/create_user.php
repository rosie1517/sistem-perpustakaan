<?php
include('./template/head.php');
include('./config/database_connection.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $_POST['nama'];
  $tanggallahir = $_POST['tanggallahir'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $no_hp = $_POST['no_hp'];

  $sql = "INSERT INTO registrasi (nama,tanggallahir, username, password, no_hp) 
          VALUES ('$nama', '$tanggallahir', '$username', '$password', '$no_hp')";

if ($conn->query($sql) === TRUE) {
      header('Location: ./template/head.php');
  } 
  
}
?>

<div class="container py-5">
    <h2>Tambah Data User</h2>
    <form class="mt-4" method="POST">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input name="nama" type="text" class="form-control" id="nama">
        </div>
        <div class="mb-3">
            <label for="tanggallahir" class="form-label">Tanggal Lahir</label>
            <input name="tanggallahir" type="date" class="form-control" id="tanggallahir">
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Email</label>
            <input name="username" type="text" class="form-control" id="username">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input name="password" type="password" class="form-control" id="password">
        </div>
        <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input name="no_hp" type="text" class="form-control" id="no_hp">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<?php
include('./template/foot.php');
?>