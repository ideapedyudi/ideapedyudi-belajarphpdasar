<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");


// read / menampilkan data dari database
function query($query)
{
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}

// tambah data
function tambah($data) {
	// ambil data dati tiap elemen dalam form
	  global $conn;
	  $nrp = htmlspecialchars($data["nrp"]);
	  $nama = htmlspecialchars($data["nama"]);
	  $email = htmlspecialchars($data["email"]);
	  $jurusan = htmlspecialchars($data["jurusan"]);

	  // upload gambar
	  $gambar = upload();
	  if (!$gambar) {
	  	return false;
	  }

	// query inser data
	  $query = "INSERT INTO mahasiswa VALUES('', '$nama', '$nrp', '$email', '$jurusan', '$gambar')";
	  mysqli_query($conn, $query);

	  return mysqli_affected_rows($conn);
}

// functuons upload
function upload() {
	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah tidak ada gambar yang diupload
	if ($error === 4) {
		echo "
				<script>
					alert('pilih gambar terlebih dahulu');
				</script>
			";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
		echo "
				<script>
					alert('yang anda aploud bukan gambar!');
				</script>
			";
		return false;
	}

	// cek ukurannya terlalu besar
	if ($ukuranFile > 1000000) {
		echo "
				<script>
					alert('ukuran gambar terlalu besar!');
				</script>
			";
		return false;
	}

	// lolos pengecekan, gambar siap di upload
	// generate nama gambar baru

	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;


	move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

	return $namaFileBaru; 

}

// hapus data
function hapus($id) {	
	global $conn;
	mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

	return mysqli_affected_rows($conn);
}


// update data
function ubah($data) {
	global $conn;

	$id = $data["id"];
	$nrp = htmlspecialchars($data["nrp"]);
	$nama = htmlspecialchars($data["nama"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	// cek apakah user pilih gambar baru atau tidak
	if ($_FILES['gambar']['error'] === 4) {
		$gambar = $gambarLama;
	} else {
		$gambar = upload();
	}

	$query = "UPDATE mahasiswa SET
				nrp = '$nrp',
				nama = '$nama',
				email = '$email',
				jurusan = '$jurusan',	
				gambar = '$gambar'
			  WHERE id = $id
			";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);		
}


// functions pencarian
function cari($keyword) {
	$query = "SELECT * FROM mahasiswa WHERE
	nama LIKE '%$keyword%' OR
	nrp LIKE '%$keyword%' OR
	email LIKE '%$keyword%' OR
	jurusan LIKE '%$keyword%'
	";

	return query($query);
}

?>