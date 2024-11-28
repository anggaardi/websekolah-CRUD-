<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";

// Mengambil data siswa dari database dengan ID tertentu
$id = 1; // Ganti sesuai ID yang ingin diedit
$query = "SELECT * FROM pengaturan WHERE id = '$id'";
$result = mysqli_query($koneksi, $query);
$d = mysqli_fetch_object($result);

if (!$d) {
	die("Data tidak ditemukan.");
}

?>
<!-- content -->
<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid px-4">
			<h1 class="mt-4">Edit Tentang Sekolah</h1>
			<ol class="breadcrumb mb-4">
				<li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
				<li class="breadcrumb-items active">/ Edit Tentang Sekolah</li>
			</ol>

			<form action="" method="POST" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header">
						<span class="h5 my-2"><i class="fa-solid fa-square-pen"></i> Edit Tentang Sekolah</span>
						<span>
							<button type="submit" name="submit" class="btn btn-primary float-end">
								<i class="fa-solid fa-pen-nib me-1"></i> Update
							</button>
							<a href="index.php" class="btn btn-danger float-end mx-1"><i class="fa-solid fa-xmark"></i> Batal</a>
						</span>
					</div>

					<div class="card-body">
						<?php
						// Tampilkan pesan sukses jika ada
						if (isset($_GET['success'])) {
							echo "<div class='alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4'>" . htmlspecialchars($_GET['success']) . "</div>";
						}
						?>
						<div class="col-12">
							<div class="mb-3 row">
								<label for="nama_kepsek" class="col-sm-2 col-form-label">Nama Kepsek</label>
								<label class="col-sm-1 col-form-label">:</label>
								<div class="col-sm-9">
									<input type="text" name="nama_kepsek" placeholder="Nama Kepsek" value="<?= htmlspecialchars($d->nama_kepsek) ?>" class="form-control border-0 border-bottom ps-2" required>
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-2 col-form-label">Foto Kepsek</label>
								<label class="col-sm-1 col-form-label">:</label>
								<div class="col-sm-9">
									<img src="../uploads/identitas/<?= htmlspecialchars($d->foto_kepsek) ?>" width="200px" class="image mb-2">
									<input type="hidden" name="foto_lama" value="<?= htmlspecialchars($d->foto_kepsek) ?>">
									<input type="file" name="foto_baru" class="input-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-2 col-form-label">Sambutan Kepsek</label>
								<label class="col-sm-1 col-form-label">:</label>
								<div class="col-sm-9">
									<textarea name="sambutan_kepsek" id="keterangan" class="input-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Sambutan Kepsek"><?= htmlspecialchars($d->sambutan_kepsek) ?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>

			<?php
			if (isset($_POST['submit'])) {
				$nama_kepsek = addslashes(ucwords($_POST['nama_kepsek']));
				$sambutan_kepsek = addslashes($_POST['sambutan_kepsek']);
				$currdate = date('Y-m-d H:i:s');

				// Memproses upload foto baru jika ada
				if ($_FILES['foto_baru']['name'] != '') {
					$filename = $_FILES['foto_baru']['name'];
					$tmpname = $_FILES['foto_baru']['tmp_name'];
					$filesize = $_FILES['foto_baru']['size'];
					$formatfile = pathinfo($filename, PATHINFO_EXTENSION);
					$rename = 'kepsek' . time() . '.' . $formatfile;

					$allowedtype = array('png', 'jpg', 'jpeg', 'gif');

					if (!in_array($formatfile, $allowedtype)) {
						echo '<div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Format file foto tidak diizinkan.</div>';
					} elseif ($filesize > 1000000) {
						echo '<div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Ukuran file foto tidak boleh lebih dari 1 MB.</div>';
					} else {
						if (file_exists("../uploads/identitas/" . $_POST['foto_lama'])) {
							unlink("../uploads/identitas/" . $_POST['foto_lama']);
						}
						move_uploaded_file($tmpname, "../uploads/identitas/" . $rename);
					}
				} else {
					$rename = $_POST['foto_lama'];
				}

				// Query update
				$update = mysqli_query($koneksi, "UPDATE pengaturan SET
					nama_kepsek = '$nama_kepsek',
					sambutan_kepsek = '$sambutan_kepsek',
					foto_kepsek = '$rename',
					updated_at = '$currdate'
					WHERE id = '$id'
				");

				// Cek apakah query berhasil
				if ($update) {
					echo "<script>window.location='kepala-sekolah.php?success=Edit Data Berhasil'</script>";
				} else {
					echo '<div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Gagal edit: ' . mysqli_error($koneksi) . '</div>';
				}
			}
			?>
		</div>
		<?php
		require_once "tamplate/footer.php";
		?>
	</main>
</div>