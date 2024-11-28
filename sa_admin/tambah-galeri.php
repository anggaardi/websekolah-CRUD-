<?php
require_once "koneksi.php";
$title = "Tambah Siswa - SMKN 1 Sukawati";
require_once "./tamplate/header.php";
require_once "./tamplate/navbar.php";
require_once "./tamplate/sidebar.php";
?>

<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid px-4">
			<h1 class="mt-4">Post Galeri</h1>
			<ol class="breadcrumb mb-4">
				<li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
				<li class="breadcrumb-items mx-1"><a href="galeri.php">/ Galeri </a></li>
				<li class="breadcrumb-items active">/ Post Galeri</li>
			</ol>

			<form action="proses-siswa.php" method="POST " enctype="multipart/form-data">
				<div class="card">
					<div class="card-header">
						<span class="h5 my-2"><i class="fa-solid fa-square-plus"></i> Tambah Siswa</span>
						<inp type="submit" name="submit" value="simpan" class="btn btn-primary float-end"><i class="fa-solid fa-floppy-disk"></i> Simpan</inp>
						<button type="reset" name="reset" class="btn btn-danger float-end mx-1"><i class="fa-solid fa-xmark"></i> Reset</button>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-8">
								<div class="mb-3 row">
									<label for="keterangan" class="col-sm-2 col-form-label">ketrangan</label>
									<label for="keterangan" class="col-sm-1 col-form-label">:</label>
									<div class="col-sm-9" style="margin-left:-50px">
										<input type="text" name="keterangan" class="form-control border-0 border-bottom ps-2" id="nama" required>
									</div>

									<div class="form-group mb-4">
										<label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
										<input type="file" name="gambar" class="input-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
									</div>

									<!-- <div class="flex space-x-2">
										<button type="button" class="bg-red-500 text-white font-bold py-2 px-4 rounded" onclick="window.location = 'galeri.php'">Kembali</button>
										<input type="submit" name="submit" value="Simpan" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-500 transition duration-200">
									</div> -->

								</div>


							</div>

						</div>

					</div>
					<?php require_once "tamplate/footer.php"; ?>
				</div>
			</form>
		</div>
	</main>
</div>


<?php
if (isset($_POST['submit'])) {
	$ket = addslashes(ucwords($_POST['keterangan']));

	$filename = $_FILES['gambar']['name'];
	$tmpname = $_FILES['gambar']['tmp_name'];
	$filesize = $_FILES['gambar']['size'];

	$formatfile = pathinfo($filename, PATHINFO_EXTENSION);
	$rename = 'galeri' . time() . '.' . $formatfile;

	$allowedtype = array('png', 'jpg', 'jpeg', 'gif');

	if (!in_array($formatfile, $allowedtype)) {
		echo '<div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Format file tidak diizinkan.</div>';
	} elseif ($filesize > 1000000) {
		echo '<div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Ukuran file tidak boleh lebih dari 1 MB.</div>';
	} else {
		move_uploaded_file($tmpname, "../uploads/galeri/" . $rename);

		$simpan = mysqli_query($koneksi, "INSERT INTO galeri VALUES (
                            null,
                            '" . $rename . "',
                            '" . $ket . "',
                            NOW(),  -- Menambahkan created_at dengan waktu saat ini
                            null
                        )");

		if ($simpan) {
			echo '<div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">Simpan Berhasil</div>';
		} else {
			echo '<div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Gagal simpan: ' . mysqli_error($conn) . '</div>';
		}
	}
}
?>