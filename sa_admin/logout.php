<?php
session_start();

// Menghapus semua session
session_unset();
session_destroy();

// Menghapus semua cookie terkait
if (isset($_COOKIE['admin_login'])) {
	setcookie('admin_login', '', time() - 3600, '/');
}
if (isset($_COOKIE['admin_uid'])) {
	setcookie('admin_uid', '', time() - 3600, '/');
}
if (isset($_COOKIE['admin_uname'])) {
	setcookie('admin_uname', '', time() - 3600, '/');
}
if (isset($_COOKIE['admin_ulevel'])) {
	setcookie('admin_ulevel', '', time() - 3600, '/');
}

// Redirect ke halaman login atau halaman utama setelah logout
echo "<script>window.location = '../login.php'</script>";
