<?php

require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";
?>



<!-- content -->
<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid px-4">
			<h1 class="mt-4">Edit Tentang sekolah</h1>
			<ol class="breadcrumb mb-4">
				<li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
				<li class="breadcrumb-items active">/ Edit Tentang sekolah</li>
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
					</div>

					<div class="card-body">
						<?php
						if (isset($_GET['success'])) {
							echo "<div class='alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4'>" . htmlspecialchars($_GET['success']) . "</div>";
						}
						?>
						<div class="col-12">


							<div class="mb-3 row">
								<label class="col-sm-2 col-form-label">Foto Sekolah</label>
								<label class="col-sm-1 col-form-label">:</label>
								<div class="col-sm-9" style="margin-left:-50px">
									<img src="../uploads/identitas/<?= $d->foto_sekolah ?>" width="200px" class="image mb-2">
									<input type="hidden" name="foto_lama" value="<?= $d->foto_sekolah ?>">
									<input type="file" name="foto_baru" class="input-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
								</div>

								<div class="mb-3 row">
									<label class="col-sm-2 col-form-label">Tentang sekolah</label>
									<label class="col-sm-1 col-form-label">:</label>
									<div class="col-sm-9" style="margin-left:-50px">
										<textarea name="tentang" class="input-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tentang Sekolah" id="keterangan"><?= $d->tentang_sekolah ?></textarea>
									</div>
								</div>






							</div>
						</div>
			</form>


			<?php
			if (isset($_POST['submit'])) {
				$tentang  = addslashes($_POST['tentang']);
				$currdate = date('Y-m-d H:i:s');

				// menampung dan validasi data foto sekolah
				if ($_FILES['foto_baru']['name'] != '') {
					$filename    = $_FILES['foto_baru']['name'];
					$tmpname     = $_FILES['foto_baru']['tmp_name'];
					$filesize    = $_FILES['foto_baru']['size'];

					$formatfile  = pathinfo($filename, PATHINFO_EXTENSION);
					$rename      = 'sekolah' . time() . '.' . $formatfile;

					$allowedtype = array('png', 'jpg', 'jpeg', 'gif');

					if (!in_array($formatfile, $allowedtype)) {
						echo '<div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Format file foto sekolah tidak diizinkan.</div>';
						return false;
					} elseif ($filesize > 1000000) {
						echo '<div class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Ukuran file foto sekolah tidak boleh lebih dari 1 MB.</div>';
						return false;
					} else {
						if (file_exists("../uploads/identitas/" . $_POST['foto_lama'])) {
							unlink("../uploads/identitas/" . $_POST['foto_lama']);
						}
						move_uploaded_file($tmpname, "../uploads/identitas/" . $rename);
					}
				} else {
					$rename = $_POST['foto_lama'];
				}

				$update = mysqli_query($koneksi, "UPDATE pengaturan SET
                        tentang_sekolah = '" . $tentang . "',
                        foto_sekolah = '" . $rename . "',
                        updated_at = '" . $currdate . "'
                        WHERE id = '" . $d->id . "'");

				if ($update) {
					echo "<script>window.location='tentang-sekolah.php?success=Edit Data Berhasil'</script>";
				} else {
					echo 'gagal edit ' . mysqli_error($koneksi);
				}
			}
			?>
		</div>
</div>
</div>
</div>