<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";

// Pastikan ID jurusan ada di parameter URL
if (!isset($_GET['id'])) {
	echo "ID jurusan tidak ditemukan!";
	exit;
}

$id_jurusan = $_GET['id'];

// Ambil data jurusan berdasarkan ID
$query = "SELECT * FROM jurusan WHERE id = '$id_jurusan'";
$result = mysqli_query($koneksi, $query);

// Cek apakah data jurusan ditemukan
if (mysqli_num_rows($result) == 0) {
	echo "Data jurusan tidak ditemukan!";
	exit;
}

$data = mysqli_fetch_assoc($result);

// Proses update data jurusan jika form disubmit
if (isset($_POST['submit'])) {
	$nama = $_POST['nama'];
	$keterangan = $_POST['keterangan'];
	$deskripsi = $_POST['deskripsi'];

	// Proses update gambar jurusan
	if ($_FILES['gambar']['error'] == 0) {
		$gambar = $_FILES['gambar']['name'];
		$tmp_name = $_FILES['gambar']['tmp_name'];
		move_uploaded_file($tmp_name, "../uploads/jurusan/" . $gambar);
		$update_query = "UPDATE jurusan SET nama = '$nama', keterangan = '$keterangan', deskripsi = '$deskripsi', gambar = '$gambar' WHERE id = '$id_jurusan'";
	} else {
		$update_query = "UPDATE jurusan SET nama = '$nama', keterangan = '$keterangan', deskripsi = '$deskripsi' WHERE id = '$id_jurusan'";
	}

	// Proses update gambar kegiatan
	for ($i = 1; $i <= 6; $i++) {
		if ($_FILES['kegiatan' . $i]['error'] == 0) {
			$kegiatan = $_FILES['kegiatan' . $i]['name'];
			$tmp_name = $_FILES['kegiatan' . $i]['tmp_name'];
			move_uploaded_file($tmp_name, "../uploads/kegiatan/" . $kegiatan);
			$update_query_kegiatan = "UPDATE jurusan SET kegiatan$i = '$kegiatan' WHERE id = '$id_jurusan'";
			mysqli_query($koneksi, $update_query_kegiatan);
		}
	}

	// Eksekusi query update
	if (mysqli_query($koneksi, $update_query)) {
		echo "<script>alert('Data jurusan berhasil diupdate!'); window.location='jurusan.php';</script>";
	} else {
		echo "<script>alert('Gagal mengupdate data!');</script>";
	}
}
?>

<!-- content -->
<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid px-4">
			<h1 class="mt-4">Edit Jurusan</h1>
			<ol class="breadcrumb mb-4">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="jurusan.php">Data Jurusan</a></li>
				<li class="breadcrumb-item active">Edit Jurusan</li>
			</ol>
			<form action="edit-jurusan.php?id=<?= $id_jurusan ?>" method="POST" enctype="multipart/form-data">

				<div class="card">
					<div class="card-header">
						<span class="h5">Edit Data Jurusan</span>
						<button type="submit" name="submit" class="btn btn-primary float-end">Update</button>
					</div>
					<div class="card-body">
						<div class="mb-3">
							<label for="nama" class="form-label">Nama Jurusan</label>
							<input type="text" class="form-control" id="nama" name="nama" value="<?= $data['nama'] ?>" required>
						</div>
						<div class="mb-3">
							<label for="keterangan" class="form-label">Keterangan</label>
							<input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $data['keterangan'] ?>" required>
						</div>
						<div class="mb-3">
							<label for="deskripsi" class="form-label">Deskripsi</label>
							<textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= $data['deskripsi'] ?></textarea>
						</div>
						<div class="mb-3">
							<label for="gambar" class="form-label">Gambar</label>
							<input type="file" class="form-control" id="gambar" name="gambar">
							<small>Jika tidak ingin mengganti gambar, biarkan kosong.</small><br>
							<img src="../uploads/jurusan/<?= $data['gambar'] ?>" width="100px" alt="Gambar Jurusan">
						</div>

						<!-- Gambar Kegiatan 1 -->
						<div class="mb-3">
							<input type="file" class="form-control" id="kegiatan1" name="kegiatan1">
							<img src="../uploads/kegiatan/<?= $data['kegiatan1'] ?>" width="100px" alt="Gambar Kegiatan 1">
						</div>

						<!-- Gambar Kegiatan 2 -->
						<div class="mb-3">
							<input type="file" class="form-control" id="kegiatan2" name="kegiatan2">
							<img src="../uploads/kegiatan/<?= $data['kegiatan2'] ?>" width="100px" alt="Gambar Kegiatan 2">
						</div>

						<!-- Gambar Kegiatan 3 -->
						<div class="mb-3">
							<input type="file" class="form-control" id="kegiatan3" name="kegiatan3">
							<img src="../uploads/kegiatan/<?= $data['kegiatan3'] ?>" width="100px" alt="Gambar Kegiatan 3">
						</div>

						<!-- Gambar Kegiatan 4 -->
						<div class="mb-3">
							<input type="file" class="form-control" id="kegiatan4" name="kegiatan4">
							<img src="../uploads/kegiatan/<?= $data['kegiatan4'] ?>" width="100px" alt="Gambar Kegiatan 4">
						</div>

						<!-- Gambar Kegiatan 5 -->
						<div class="mb-3">
							<input type="file" class="form-control" id="kegiatan6" name="kegiatan6">
							<img src="../uploads/kegiatan/<?= $data['kegiatan5'] ?>" width="100px" alt="Gambar Kegiatan 5">

						</div>

						<!-- Gambar Kegiatan 6 -->
						<div class="mb-3">
							<input type="file" class="form-control" id="kegiatan6" name="kegiatan6">
							<img src="../uploads/kegiatan/<?= $data['kegiatan6'] ?>" width="100px" alt="Gambar Kegiatan 6">
						</div>

					</div>
				</div>

			</form>
			<?php
			require_once "tamplate/footer.php";
			?>
		</div>
	</main>
</div>

</div>