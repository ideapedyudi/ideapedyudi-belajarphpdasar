<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

// cek id ada apa tidak
if (!isset($_GET["id"])) {
  header("Location: index.php");
  exit;
}

// ambil data di URL
$id = $_GET["id"];

// query data mahasiswa berdasarkan id
$mhs = query("SELECT * FROM mahasiswa WHERE id = $id")[0];


// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
  
  // cek apakah data berhasil diubah atau tidak
  if( ubah($_POST) > 0 ) {
    echo "
      <script>
        alert('data berhasil diubah!');
        document.location.href = 'index.php';
      </script>
    ";
  } else {
    echo "
      <script>
        alert('data gagal diubah!');
        document.location.href = 'index.php';
      </script>
    ";
  }


}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Ubah data mahasiswa</title>
</head>
<style>
  img {
    width: 100px;
  }
</style>
<body>
  <h1>Ubah data mahasiswa</h1>
  <form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $mhs["id"]; ?>">
    <input type="hidden" name="gambarLama" value="<?= $mhs["gambar"]; ?>">
    <ul>
      <li>
        <label for="nrp">NRP : </label>
        <input type="text" name="nrp" id="nrp" required value="<?= $mhs["nrp"]; ?>">
      </li>
      <li>
        <label for="nama">Nama : </label>
        <input type="text" name="nama" id="nama" value="<?= $mhs["nama"]; ?>">
      </li>
      <li>
        <label for="email">Email :</label>
        <input type="text" name="email" id="email" value="<?= $mhs["email"]; ?>">
      </li>
      <li>
        <label for="jurusan">Jurusan :</label>
        <input type="text" name="jurusan" id="jurusan" value="<?= $mhs["jurusan"]; ?>">
      </li>
      <li>
        <label for="gambar">Gambar :</label><br>
        <img src="img/<?php echo $mhs['gambar']; ?>" alt=""><br>
        <input type="file" name="gambar" id="gambar">
      </li>
      <li>
        <button type="submit" name="submit">Ubah Data!</button>
      </li>
    </ul>

  </form>
</body>
</html>