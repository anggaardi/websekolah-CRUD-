<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";
?>

<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid px-4">
			<h1 class="mt-4">Post Informsi</h1>
			<ol class="breadcrumb mb-4">
				<li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
				<li class="breadcrumb-items mx-1"><a href="informasi.php">/ Informasi </a></li>
				<li class="breadcrumb-items active">/ Post Informasi</li>
			</ol>

			<form action="" method="POST" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header">
						<span class="h5 my-2"><i class="fa-solid fa-square-plus"></i> Tambah Informasi</span>
						<input type="submit" name="simpan" value="Simpan" class="btn btn-primary float-end">
						<button type="reset" name="reset" class="btn btn-danger float-end mx-1"><i class="fa-solid fa-xmark"></i> Reset</button>
					</div>
					<?php
					if (isset($_GET['success'])) {
						echo "<div class='bg-green-100 text-green-700 p-4 rounded mb-4'>" . $_GET['success'] . "</div>";
					}
					?>

					<div class="card-body">
						<div class="row">
							<div class="col-10">

								<div class="mb-3 row">
									<label for="nama" class="col-sm-2 col-form-label">Nama Struktur</label>
									<label for="nama" class="col-sm-1 col-form-label">:</label>
									<div class="col-sm-9">
										<input type="text" name="nama" placeholder="Nama Sekolah" value="<?= htmlspecialchars($d->nama) ?>" class="form-control border-0 border-bottom ps-2" required>
									</div>
								</div>

								<div class="mb-3 row">
									<label for="email" class="col-sm-2 col-form-label">Email</label>
									<label for="email" class="col-sm-1 col-form-label">:</label>
									<div class="col-sm-9">
										<input type="email" name="email" value="<?= htmlspecialchars($d->email) ?>" class="form-control border-0 border-bottom ps-2" required>
									</div>
								</div>

								<div class="mb-3 row">
									<label for="telp" class="col-sm-2 col-form-label">No telpon sekolah</label>
									<label for="telp" class="col-sm-1 col-form-label">:</label>
									<div class="col-sm-9">
										<input type="text" name="telp" placeholder="Telpon Sekolah" value="<?= htmlspecialchars($d->telepon) ?>" class="form-control border-0 border-bottom ps-2" required>
									</div>
								</div>

								<div class="mb-3 row">
									<label for="alamat" class="col-sm-2 col-form-label">Alamat Sekolah</label>
									<label for="alamat" class="col-sm-1 col-form-label">:</label>
									<div class="col-sm-9">
										<input type="text" name="alamat" placeholder="Alamat Sekolah" value="<?= htmlspecialchars($d->alamat) ?>" class="form-control border-0 border-bottom ps-2" required>
									</div>
								</div>
								<div class="mb-3 row">
									<label for="gmaps" class="col-sm-2 col-form-label">Goggle maps</label>
									<label for="gmaps" class="col-sm-1 col-form-label">:</label>
									<div class="col-sm-9">
										<textarea name="gmaps" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Google Maps"><?= htmlspecialchars($d->google_maps) ?></textarea>
									</div>
								</div>

								<div class="mb-3 row">
									<label for="gmaps" class="col-sm-2 col-form-label">Logo</label>
									<label for="gmaps" class="col-sm-1 col-form-label">:</label>
									<div class="col-sm-9">
										<img src="../uploads/identitas/<?= htmlspecialchars($d->logo) ?>" width="200px" class="mb-2">
										<input type="hidden" name="logo_lama" value="<?= htmlspecialchars($d->logo) ?>">
										<input type="file" name="logo_baru" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
									</div>
								</div>

								<div class="mb-3 row">
									<label for="gmaps" class="col-sm-2 col-form-label">Favicon</label>
									<label for="gmaps" class="col-sm-1 col-form-label">:</label>
									<div class="col-sm-9">
										<img src="../uploads/identitas/<?= htmlspecialchars($d->favicon) ?>" width="32" class="mb-2">
										<input type="hidden" name="favicon_lama" value="<?= htmlspecialchars($d->favicon) ?>">
										<input type="file" name="logo_baru" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
									</div>
								</div>
							</div>
						</div>
			</form>
			<?php
			if (isset($_POST['submit'])) {
				$nama    = addslashes(ucwords($_POST['nama']));
				$email   = addslashes($_POST['email']);
				$telp    = addslashes($_POST['telp']);
				$alamat  = addslashes($_POST['alamat']);
				$gmaps   = addslashes($_POST['gmaps']);
				$currdate = date('Y-m-d H:i:s');

				// Validasi data logo
				if ($_FILES['logo_baru']['name'] != '') {
					$filename_logo  = $_FILES['logo_baru']['name'];
					$tmpname_logo   = $_FILES['logo_baru']['tmp_name'];
					$filesize_logo  = $_FILES['logo_baru']['size'];
					$formatfile_logo = pathinfo($filename_logo, PATHINFO_EXTENSION);
					$rename_logo    = 'logo' . time() . '.' . $formatfile_logo;
					$allowedtype_logo = ['png', 'jpg', 'jpeg', 'gif'];

					if (!in_array($formatfile_logo, $allowedtype_logo)) {
						echo '<div class="bg-red-100 text-red-700 p-4 rounded mb-4">Format file logo sekolah tidak diizinkan.</div>';
						return false;
					} elseif ($filesize_logo > 1000000) {
						echo '<div class="bg-red-100 text-red-700 p-4 rounded mb-4">Ukuran file logo sekolah tidak boleh lebih dari 1 MB.</div>';
						return false;
					} else {
						if (file_exists("../uploads/identitas/" . $_POST['logo_lama'])) {
							unlink("../uploads/identitas/" . $_POST['logo_lama']);
						}
						move_uploaded_file($tmpname_logo, "../uploads/identitas/" . $rename_logo);
					}
				} else {
					$rename_logo = $_POST['logo_lama'];
				}

				// Validasi data favicon
				if ($_FILES['favicon_baru']['name'] != '') {
					$filename_favicon  = $_FILES['favicon_baru']['name'];
					$tmpname_favicon   = $_FILES['favicon_baru']['tmp_name'];
					$filesize_favicon  = $_FILES['favicon_baru']['size'];
					$formatfile_favicon = pathinfo($filename_favicon, PATHINFO_EXTENSION);
					$rename_favicon   = 'favicon' . time() . '.' . $formatfile_favicon;
					$allowedtype_favicon = ['png', 'jpg', 'jpeg', 'gif'];

					if (!in_array($formatfile_favicon, $allowedtype_favicon)) {
						echo '<div class="bg-red-100 text-red-700 p-4 rounded mb-4">Format file favicon sekolah tidak diizinkan.</div>';
						return false;
					} elseif ($filesize_favicon > 1000000) {
						echo '<div class="bg-red-100 text-red-700 p-4 rounded mb-4">Ukuran file favicon sekolah tidak boleh lebih dari 1 MB.</div>';
						return false;
					} else {
						if (file_exists("../uploads/identitas/" . $_POST['favicon_lama'])) {
							unlink("../uploads/identitas/" . $_POST['favicon_lama']);
						}
						move_uploaded_file($tmpname_favicon, "../uploads/identitas/" . $rename_favicon);
					}
				} else {
					$rename_favicon = $_POST['favicon_lama'];
				}

				$update = mysqli_query($koneksi, "UPDATE pengaturan SET
                    nama = '$nama',
                    email = '$email',
                    telepon = '$telp',
                    alamat = '$alamat',
                    google_maps = '$gmaps',
                    logo = '$rename_logo',
                    favicon = '$rename_favicon',
                    updated_at = '$currdate'
                    WHERE id = '" . $d->id . "'");

				if ($update) {
					echo "<script>window.location='identitas-sekolah.php?success=Edit Data Berhasil'</script>";
				} else {
					echo '<div class="bg-red-100 text-red-700 p-4 rounded mb-4">Gagal edit: ' . mysqli_error($conn) . '</div>';
				}
			}
			?>

			<?php require_once "tamplate/footer.php"; ?>
		</div>
</div>