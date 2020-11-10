<?php 
usleep(500000);
require '../functions.php';
$keyword = $_GET['keyword']; 

$mahasiswa = query("SELECT * FROM mahasiswa WHERE
nama LIKE '%$keyword%' OR
nrp LIKE '%$keyword%' OR
email LIKE '%$keyword%' OR
jurusan LIKE '%$keyword%'
");


?>

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