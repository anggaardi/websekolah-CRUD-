<?php
require_once 'koneksi.php';
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";


// Cek apakah pengguna sudah login
if (!isset($_SESSION['status_login'])) {
	echo "<script>window.location = 'login.php'</script>";
}

// Proses ubah password
if (isset($_POST['submit'])) {
	$id = $_SESSION['uid'];
	$current_password = mysqli_real_escape_string($koneksi, $_POST['current_password']);
	$new_password = mysqli_real_escape_string($koneksi, $_POST['new_password']);
	$confirm_password = mysqli_real_escape_string($koneksi, $_POST['confirm_password']);

	// Ambil password lama dari database
	$query = mysqli_query($koneksi, "SELECT password FROM pengguna WHERE id = '$id'");
	$data = mysqli_fetch_object($query);

	if (md5($current_password) != $data->password) {
		echo '<div class="alert alert-error">Password lama salah</div>';
	} else {
		if ($new_password != $confirm_password) {
			echo '<div class="alert alert-error">Konfirmasi password baru tidak cocok</div>';
		} else {
			// Update password
			$new_password_hashed = md5($new_password);
			$update = mysqli_query($koneksi, "UPDATE pengguna SET password = '$new_password_hashed' WHERE id = '$id'");

			if ($update) {
				echo '<div class="alert alert-success">Password berhasil diubah</div>';
				echo "<script>window.location = 'logout.php'</script>";
			} else {
				echo '<div class="alert alert-error">Gagal mengubah password</div>';
			}
		}
	}
}
?>
<!-- 
<!DOCTYPE html>
<html>

<head>
	<title>Ubah Password</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>

	<div class="page-change-password">
		<div class="box box-change-password">
			<div class="box-header text-center">
				Ubah Password
			</div>
			<div class="box-body">
				<form action="" method="POST">
					<div class="form-group">
						<label>Password Lama</label>
						<input type="password" name="current_password" placeholder="Password Lama" class="input-control" required>
					</div>
					<div class="form-group">
						<label>Password Baru</label>
						<input type="password" name="new_password" placeholder="Password Baru" class="input-control" required>
					</div>
					<div class="form-group">
						<label>Konfirmasi Password Baru</label>
						<input type="password" name="confirm_password" placeholder="Konfirmasi Password Baru" class="input-control" required>
					</div>
					<input type="submit" name="submit" value="Ubah Password" class="btn">
				</form>
			</div>
		</div>
	</div>

</body>

</html> -->

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<title>Ubah Password</title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
	<div id="layoutSidenav_content">
		<div class="container mx-auto p-6">
			<h1 class="text-2xl font-bold mb-4">Ubah Password</h1>
			<form method="POST" action="" class="bg-white p-6 rounded-lg shadow-md">
				<div class="mb-4">
					<label for="translation_key" class="block text-sm font-medium text-gray-700">Password Lama</label>
					<input type="password" name="current_password" placeholder="Password Lama" required
						class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
				</div>

				<div class="mb-4">
					<label for="language" class="block text-sm font-medium text-gray-700">Password Baru</label>
					<input type="password" name="new_password" placeholder="Password Baru" required
						class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
				</div>

				<div class="mb-4">
					<label for="translation" class="block text-sm font-medium text-gray-700">Password Baru</label>
					<input type="password" name="confirm_password" placeholder="Konfirmasi Password Baru" required
						class="mt-1 block w-full p-2 border border-gray-300 rounded-md"></textarea>
				</div>

				<input type="submit" name="submit" value="Ubah Password" class="w-full bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600">

				</button>
			</form>
		</div>
	</div>
</body>

</html>