<?php
require_once "./tamplate/header.php";
require_once "./tamplate/navbar.php";
require_once "./tamplate/sidebar.php";
?>


<?php
$galeri = mysqli_query($koneksi, "SELECT * FROM galeri WHERE id = '" . $_GET['id'] . "' ");

if (mysqli_num_rows($galeri) == 0) {
	echo "<script>window.location='galeri.php'</script>";
}

$p = mysqli_fetch_object($galeri);
?>

<!-- content -->
<div class="content py-8">
	<div class="container mx-auto px-4">
		<div class="box bg-white shadow-md rounded-lg p-6">
			<div class="box-header text-2xl font-semibold mb-6">
				Edit Galeri
			</div>

			<div class="box-body">
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="form-group mb-4">
						<label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
						<input type="text" name="keterangan" placeholder="Keterangan" value="<?= htmlspecialchars($p->keterangan) ?>" class="input-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
					</div>

					<div class="form-group mb-4">
						<label class="block text-sm font-medium text-gray-700 mb-2">Gambar</label>
						<img src="../uploads/galeri/<?= htmlspecialchars($p->foto) ?>" width="200px" class="mb-4 rounded-md">
						<input type="hidden" name="gambar2" value="<?= htmlspecialchars($p->foto) ?>">
						<input type="file" name="gambar" class="input-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
					</div>

					<div class="flex space-x-2">
						<button type="button" class="bg-red-500 text-white font-bold py-2 px-4 rounded" onclick="window.location = 'galeri.php'">Kembali</button>
						<input type="submit" name="submit" value="Simpan" class="bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-500 transition duration-200">
					</div>
				</form>

				<?php
				if (isset($_POST['submit'])) {
					$ket = addslashes(ucwords($_POST['keterangan']));
					$currdate = date('Y-m-d H:i:s');

					if ($_FILES['gambar']['name'] != '') {
						$filename = $_FILES['gambar']['name'];
						$tmpname = $_FILES['gambar']['tmp_name'];
						$filesize = $_FILES['gambar']['size'];

						$formatfile = pathinfo($filename, PATHINFO_EXTENSION);
						$rename = 'galeri' . time() . '.' . $formatfile;

						$allowedtype = array('png', 'jpg', 'jpeg', 'gif');

						if (!in_array($formatfile, $allowedtype)) {
							echo '<div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Format file tidak diizinkan.</div>';
							return false;
						} elseif ($filesize > 1000000) {
							echo '<div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Ukuran file tidak boleh lebih dari 1 MB.</div>';
							return false;
						} else {
							if (file_exists("../uploads/galeri/" . $_POST['gambar2'])) {
								unlink("../uploads/galeri/" . $_POST['gambar2']);
							}
							move_uploaded_file($tmpname, "../uploads/galeri/" . $rename);
						}
					} else {
						$rename = $_POST['gambar2'];
					}

					$update = mysqli_query($conn, "UPDATE galeri SET
                        keterangan = '" . $ket . "',
                        foto = '" . $rename . "',
                        updated_at = '" . $currdate . "'
                        WHERE id = '" . $_GET['id'] . "'
                    ");

					if ($update) {
						echo "<script>window.location='galeri.php?success=Edit Data Berhasil'</script>";
					} else {
						echo '<div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Gagal edit: ' . mysqli_error($conn) . '</div>';
					}
				}
				?>
			</div>
		</div>
	</div>
</div>

