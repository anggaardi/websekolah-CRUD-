<?php
include 'koneksi.php';

// Ambil data identitas
$identitas = mysqli_query($conn, "SELECT * FROM pengaturan ORDER BY id DESC LIMIT 1");
$d = mysqli_fetch_object($identitas);

// Ambil bahasa dari query parameter, jika tidak ada, gunakan 'id' sebagai default
$language = isset($_GET['language']) ? $_GET['language'] : 'id';

// Tentukan path gambar berdasarkan bahasa yang dipilih
$flagSrc = ($language == 'en') ? 'assets/inggris.png' : 'assets/indonesia.png';
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="header.css" />
	<link rel="stylesheet" href="coba.css" />
	<script src="scrollProgress.js"></script>

	<link rel="icon" href="uploads/identitas/<?= $d->favicon ?>">
	<title><?= $d->nama ?></title>
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto+Mono:wght@100..700&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
</head>

<body>
	<header class="w-full bg-white py-1 sticky top-0 shadow" style="z-index:1000;">
		<div class="container mx-auto flex flex-wrap justify-between items-center px-4">
			<div class="flex items-center">
				<img src="uploads/identitas/<?= $d->logo ?>" width="50" class="mr-2">
				<h1 class="font-bold text-black text-xl uppercase">
					<a href="index.php" class="hover:text-blue-800"><?= $d->nama ?></a>
				</h1>
			</div>

			<!-- Navigasi Desktop -->
			<nav class="hidden md:flex space-x-4 text-sm font-bold text-slate-800">
				<a href="index.php" class="hover:text-blue-600 text-blue-600">Beranda</a>
				<a href="tentang-sekolah.php" class="hover:text-blue-600">Tentang Kami</a>
				<a href="informasi.php" class="hover:text-blue-600">Informasi</a>
				<a href="jurusan.php" class="hover:text-blue-600">Program Keahlian</a>
				<a href="staff.php" class="hover:text-blue-600">Guru Dan Pegawai</a>
			</nav>

			<!-- Menu Bahasa -->
			<form id="languageForm" method="get" class="flex items-center">
				<div class="relative">
					<div class="flex items-center cursor-pointer" onclick="toggleDropdown()">
						<img id="selectedFlag" src="<?= $flagSrc; ?>" alt="Flag" class="w-6 h-4 mr-2">
					</div>
					<div id="selectOptions" class="hidden absolute bg-white shadow-lg rounded-lg">
						<div onclick="selectLanguage('id', 'assets/indonesia.png')" class="px-4 py-2 hover:bg-gray-200 flex items-center">
							<img src="assets/indonesia.png" class="w-6 h-4 mr-2">
							<span>Indonesia</span>
						</div>
						<div onclick="selectLanguage('en', 'assets/inggris.png')" class="px-4 py-2 hover:bg-gray-200 flex items-center">
							<img src="assets/inggris.png" class="w-6 h-4 mr-2">
							<span>English</span>
						</div>
					</div>
				</div>
				<input type="hidden" name="language" id="languageInput" value="<?= $language; ?>">
			</form>

			<!-- Tombol Menu Mobile -->
			<button id="mobileMenuButton" class="text-blue-600 md:hidden">
				<i class="fas fa-bars"></i>
			</button>
		</div>

		<!-- Dropdown untuk Mobile -->
		<div id="dropdownMenu" class="hidden md:hidden flex flex-col space-y-2 px-4 py-2 bg-white shadow-lg">
			<a href="index.php" class="hover:text-blue-600 text-blue-600">Beranda</a>
			<a href="tentang-sekolah.php" class="hover:text-blue-600">Tentang Kami</a>
			<a href="informasi.php" class="hover:text-blue-600">Informasi</a>
			<a href="jurusan.php" class="hover:text-blue-600">Program Keahlian</a>
			<a href="staff.php" class="hover:text-blue-600">Staff</a>
		</div>
	</header>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Mobile menu toggle
			const mobileMenuButton = document.getElementById('mobileMenuButton');
			const dropdownMenu = document.getElementById('dropdownMenu');

			if (mobileMenuButton && dropdownMenu) {
				mobileMenuButton.addEventListener('click', function() {
					dropdownMenu.classList.toggle('hidden');
				});
			}

			// Language dropdown
			const selectOptions = document.getElementById('selectOptions');
			document.addEventListener('click', function(event) {
				if (!event.target.closest('.relative')) {
					selectOptions.classList.add('hidden');
				}
			});
		});

		function toggleDropdown() {
			const selectOptions = document.getElementById('selectOptions');
			selectOptions.classList.toggle('hidden');
		}

		function selectLanguage(language, flag) {
			document.getElementById('languageInput').value = language;
			document.getElementById('selectedFlag').src = flag;
			document.getElementById('languageForm').submit();
		}
	</script>
</body>

</html>