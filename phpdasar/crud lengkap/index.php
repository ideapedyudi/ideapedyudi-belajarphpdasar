<?php

session_start();

if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}

require 'functions.php';

// pagination
// konfigurasi
$jumlahDataPerhalaman = 3;
$jumlahData = count(query("SELECT * FROM mahasiswa"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;


$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $awalData	, $jumlahDataPerhalaman");
// order by untuk meanmpilkan sesuai yang mana disitu id
// asc menampilkan yang lama di atas
// desc menampilkan yang baru di atas

// tombol pencarian
if (isset($_POST["cari"])) {
	$mahasiswa = cari($_POST["keyword"]);
}

// ambil data mahasiswa dari objek result
// mysqli_fect_row() // array numerik
// mysqli_fect_assoc() // array assosiative
// mysqli_fect_array() // megembalikan
// mysqli_fect_object()

// while ($mhs = mysqli_fetch_assoc($result)) {
// 	var_dump($mhs);
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Halaman Admin</title>
	<style>
		img {
			width: 60px;
		}
	</style>
</head>

<body>
	<a href="logout.php">Logout</a>
	<h1>Daftar Mahasiswa</h1>
	<a href="tambah.php">Tambah Data Mahasiswa</a><br><br>
	<form action="" method="POST">
		<input type="text" name="keyword" size="40" autofocus placeholder="Masukkan keyword pencarian..." autocomplete="off">
		<button type="submit" name="cari">Cari!</button>
	</form><br>

	<!-- navigasi -->
	<?php if (!isset($_POST['cari'])) :?>
	<!-- prev -->
	<div class="pagination">
		<?php if($halamanAktif > 1) : ?>
		<a href="?halaman=<?= $halamanAktif - 1  ?> ">&laquo;</a>
		<?php endif; ?>


		<?php for($i = 1; $i <= $jumlahHalaman; $i++) : ?>
			<?php if($i == $halamanAktif) : ?>
				<a href="?halaman=<?= $i; ?>" style="font-weight: bold;color: red;"><?= $i; ?></a>
			<?php else : ?>
				<a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
			<?php endif; ?>
		<?php endfor; ?>
		
		<!-- next -->
		<?php if($halamanAktif < $jumlahHalaman) : ?>
		<a href="?halaman=<?= $halamanAktif + 1  ?> ">&raquo;</a>
		<?php endif; ?>
	</div>
		<?php endif; ?>

	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>No. </th>
			<th>Aksi</th>
			<th>Gambar</th>
			<th>NRP</th>
			<th>Nama</th>
			<th>Email</th>
			<th>Jurusan</th> 
		</tr>

		<?php $i = 1;
		foreach ($mahasiswa as $row) : ?>

			<tr>
				<td><?php echo $i++; ?></td>
				<td>
					<a href="ubah.php?id=<?php echo $row["id"]; ?>">Ubah</a> |
					<a href="hapus.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('yakin data di hapus');">Hapus</a>
				</td>
				<td><img src="img/<?php echo $row["gambar"]; ?>" alt=""></td>
				<td><?php echo $row["nrp"]; ?></td>
				<td><?php echo $row["nama"]; ?></td>
				<td><?php echo $row["email"]; ?></td>
				<td><?php echo $row["jurusan"]; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>

</body>

</html>