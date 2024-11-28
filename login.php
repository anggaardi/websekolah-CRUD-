<?php
session_start();
include 'koneksi.php';

// Pengecekan cookie
if (isset($_COOKIE['admin_login']) && isset($_COOKIE['admin_uid'])) {
	$_SESSION['status_login'] = true;
	$_SESSION['uid'] = $_COOKIE['admin_uid'];
	$_SESSION['uname'] = $_COOKIE['admin_uname'];
	$_SESSION['ulevel'] = $_COOKIE['admin_ulevel'];
	echo "<script>window.location = 'sa_admin/index.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Form</title>
	<link rel="stylesheet" type="text/css" href="src/login.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<!-- Notyf CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
	<!-- Notyf JS -->
	<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

</head>

<body>
	<img class="wave" src="assets/wave.png">
	<div class="container">
		<div class="img">
			<img src="assets/bg.svg">
		</div>
		<div class="login-content">
			<form method="POST">
				<img src="assets/avatar.svg" width="200px" height="100px">
				<h2 class="title">Welcome</h2>
				<div class="input-div one">
					<div class="i">
						<i class="fas fa-user"></i>
					</div>
					<div class="div">
						<h5>Username</h5>
						<input type="text" name="user" class="input" required>
					</div>
				</div>
				<div class="input-div pass">
					<div class="i">
						<i class="fas fa-lock"></i>
					</div>
					<div class="div">
						<h5>Password</h5>
						<input type="password" name="pass" class="input" required>
					</div>
				</div>
				<a href="index.php">Kembali Ke halaman Utama?</a>
				<input type="submit" name="submit" class="btn" value="Login">
			</form>
		</div>
	</div>

	<script>
		const inputs = document.querySelectorAll(".input");

		function addcl() {
			let parent = this.parentNode.parentNode;
			parent.classList.add("focus");
		}

		function remcl() {
			let parent = this.parentNode.parentNode;
			if (this.value == "") {
				parent.classList.remove("focus");
			}
		}

		inputs.forEach(input => {
			input.addEventListener("focus", addcl);
			input.addEventListener("blur", remcl);
		});

		// Notyf initialization
		const notyf = new Notyf();
	</script>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
	$user = mysqli_real_escape_string($conn, $_POST['user']);
	$pass = mysqli_real_escape_string($conn, $_POST['pass']);

	$cek = mysqli_query($conn, "SELECT * FROM pengguna WHERE username = '$user'");

	if (mysqli_num_rows($cek) > 0) {
		$d = mysqli_fetch_object($cek);

		if (md5($pass) == $d->password) {
			$_SESSION['status_login'] = true;
			$_SESSION['uid'] = $d->id;
			$_SESSION['uname'] = $d->nama;
			$_SESSION['ulevel'] = $d->level;

			// Set cookies untuk sesi tetap hidup
			setcookie('admin_login', true, time() + (86400 * 7), "/");
			setcookie('admin_uid', $d->id, time() + (86400 * 7), "/");
			setcookie('admin_uname', $d->nama, time() + (86400 * 7), "/");
			setcookie('admin_ulevel', $d->level, time() + (86400 * 7), "/");

			echo "<script>window.location = 'sa_admin/index.php'</script>";
		} else {
			echo "<script>notyf.error('Password yang Anda masukkan salah. Silakan coba lagi.');</script>";
		}
	} else {
		echo "<script>notyf.error('Username tidak ditemukan. Silakan periksa kembali.');</script>";
	}
}
?>