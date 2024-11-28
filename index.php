<?php include 'header.php'; ?>

<?php

function get_translation($key, $language)
{
	// Buat koneksi ke database
	$koneksi = mysqli_connect('localhost', 'root', '', 'db_sekolah') or die('Gagal terhubung ke database');

	// Query untuk mendapatkan terjemahan
	$stmt = $koneksi->prepare("SELECT translation FROM translations WHERE translation_key = ? AND language = ?");
	$stmt->bind_param("ss", $key, $language);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($row = $result->fetch_assoc()) {
		return $row['translation'];
	} else {
		return $key; // Jika tidak ada terjemahan, kembalikan key-nya
	}
}

// Ambil bahasa dari query parameter, jika tidak ada, gunakan 'id' sebagai default
$language = isset($_GET['language']) ? $_GET['language'] : 'id';
?>

<style>
	.slide-in-up {
		opacity: 0;
		transform: translateY(200px);
		transition: opacity 1s ease-out, transform 1s ease-out;
	}

	.slide-in-up.show {
		opacity: 1;
		transform: translateY(0);
	}
</style>

<link rel="stylesheet" href="slider.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<body>
	<!-- Pastikan Swiper CSS dan JS sudah terlink -->
	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
	<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

	<div class="swiper-container slider-container">
		<div class="swiper-wrapper">
			<!-- Slider Item -->
			<div class="swiper-slide slider-item">
				<div class="slide-content">
					<h3 class="slide-subtitle">SMKN 1 Sukawati</h3>
					<h2 class="slide-title">Raih Kualifikasimu Bersama Kami</h2>
					<p class="slide-description">
						SMK Negeri 1 Sukawati merupakan Sekolah Kejuruan yang satu-satunya di Bali dan Indonesia yang memiliki keunggulan dalam bidang seni rupa dan kerajinan yang berbasis budaya dan sangat relevan dalam mendukung pariwisata di Bali khususnya dan nasional umumnya. </p>
				</div>
			</div>
			<div class="swiper-slide slider-item">
				<div class="slide-content">
					<h3 class="slide-subtitle">SMKN 1 Sukawati</h3>
					<h2 class="slide-title">Raih Kualifikasimu Bersama Kami</h2>
					<p class="slide-description">
						SMK Negeri 1 Sukawati merupakan Sekolah Kejuruan yang satu-satunya di Bali dan Indonesia yang memiliki keunggulan dalam bidang seni rupa dan kerajinan yang berbasis budaya dan sangat relevan dalam mendukung pariwisata di Bali khususnya dan nasional umumnya. </p>
				</div>
			</div>
			<div class="swiper-slide slider-item">
				<div class="slide-content">
					<h3 class="slide-subtitle">Slide 01</h3>
					<h2 class="slide-title">Raih Kualifikasimu Bersama Kami</h2>
					<p class="slide-description">
						SMK Negeri 1 Sukawati merupakan Sekolah Kejuruan yang satu-satunya di Bali dan Indonesia yang memiliki keunggulan dalam bidang seni rupa dan kerajinan yang berbasis budaya dan sangat relevan dalam mendukung pariwisata di Bali khususnya dan nasional umumnya. </p>
				</div>
			</div>
			<!-- Slide lainnya... -->
		</div>
	</div>


	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const swiper = new Swiper(".swiper-container", {
				loop: true, // Pastikan looping diaktifkan
				autoplay: {
					delay: 4000, // Waktu delay antar slide
				},
				effect: "fade", // Menggunakan efek fade untuk transisi
				speed: 1000, // Kecepatan transisi
			});
		});
	</script>

	<div class="w-full bg-white py-20"></div>
	<div class="container mx-auto px-4">
		<div class="flex flex-wrap md:flex-nowrap gap-6">
			<!-- Bagian kiri: YouTube + Profil Sekolah -->
			<div class="w-full md:w-1/2">
				<div class="relative w-full h-64 md:h-96 overflow-hidden rounded-md mb-6">
					<iframe
						class="absolute top-0 left-0 w-full h-full z-10"
						src="https://www.youtube.com/embed/hEO88waGe4U?si=jXj0Z48vCSDYdI6n"
						title="YouTube video player"
						frameborder="0"
						allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
						allowfullscreen>
					</iframe>
				</div>
				<div>
					<span class="pre-title text-lg font-semibold text-gray-400 rounded">Profile Sekolah</span>
					<h1 class="text-xl md:text-2xl mb-4 font-bold text-slate-700"><?= $d->nama ?></h1>
					<p class="text-sm md:text-base text-slate-500">
						SMK Negeri 1 Sukawati merupakan Sekolah Kejuruan yang satu-satunya di Bali dan Indonesia yang memiliki keunggulan dalam bidang seni rupa dan kerajinan yang berbasis budaya dan sangat relevan dalam mendukung pariwisata di Bali khususnya dan nasional umumnya. SMK Negeri 1 Sukawati hadir tidak hanya mengedepankan seni rupa dan kerajinan traditional namun kini juga memanfaatkan teknologi terkini dalam proses inovasinya.
					</p>
				</div>
			</div>

			<!-- Bagian kanan: Slider Daftar Jurusan -->
			<div class="w-full md:w-1/2">
				<!-- Swiper Container -->
				<div class="swiper-container">
					<div class="swiper-wrapper">
						<?php
						$jurusan = mysqli_query($conn, "SELECT * FROM jurusan ORDER BY id DESC LIMIT 9");
						if (mysqli_num_rows($jurusan) > 0) {
							while ($p = mysqli_fetch_array($jurusan)) {
						?>
								<div class="swiper-slide">
									<div class="w-full p-4 bg-white rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300 ease-in-out">
										<a href="detail-informasi.php?id=<?= $p['id'] ?>" class="thumbnail-link">
											<img class="w-full h-40 object-cover rounded-t-lg"
												src="uploads/jurusan/<?= $p['gambar'] ?>"
												alt="<?= $p['nama'] ?>"
												onerror="this.src='path-to-placeholder.jpg';" />
											<div class="p-4">
												<h2 class="text-lg font-semibold"><?= $p['nama'] ?></h2>
												<p class="text-gray-600 mt-2">
													<?= strlen($p['keterangan']) > 100 ? substr($p['keterangan'], 0, 100) . '...' : $p['keterangan'] ?>
												</p>
											</div>
										</a>
									</div>
								</div>
								<div class="swiper-slide">
									<div class="w-full p-4 bg-white rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300 ease-in-out">
										<a href="detail-informasi.php?id=<?= $p['id'] ?>" class="thumbnail-link">
											<img class="w-full h-40 object-cover rounded-t-lg"
												src="uploads/jurusan/<?= $p['gambar'] ?>"
												alt="<?= $p['nama'] ?>"
												onerror="this.src='path-to-placeholder.jpg';" />
											<div class="p-4">
												<h2 class="text-lg font-semibold"><?= $p['nama'] ?></h2>
												<p class="text-gray-600 mt-2">
													<?= strlen($p['keterangan']) > 100 ? substr($p['keterangan'], 0, 100) . '...' : $p['keterangan'] ?>
												</p>
											</div>
										</a>
									</div>
								</div>
								<div class="swiper-slide">
									<div class="w-full p-4 bg-white rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300 ease-in-out">
										<a href="detail-informasi.php?id=<?= $p['id'] ?>" class="thumbnail-link">
											<img class="w-full h-40 object-cover rounded-t-lg"
												src="uploads/jurusan/<?= $p['gambar'] ?>"
												alt="<?= $p['nama'] ?>"
												onerror="this.src='path-to-placeholder.jpg';" />
											<div class="p-4">
												<h2 class="text-lg font-semibold"><?= $p['nama'] ?></h2>
												<p class="text-gray-600 mt-2">
													<?= strlen($p['keterangan']) > 100 ? substr($p['keterangan'], 0, 100) . '...' : $p['keterangan'] ?>
												</p>
											</div>
										</a>
									</div>
								</div>

							<?php }
						} else { ?>
							<p class="text-gray-500">Tidak ada data</p>
						<?php } ?>
					</div>

					<!-- Pagination -->

				</div>
			</div>
		</div>

		<!-- Swiper JS Script -->
		<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
		<script>
			var swiper = new Swiper('.swiper-container', {
				slidesPerView: 2, // Menampilkan 2 card
				spaceBetween: 30, // Jarak antar card
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
				breakpoints: {
					640: {
						slidesPerView: 1, // Pada layar kecil, hanya tampil 1 card
					},
					1024: {
						slidesPerView: 2, // Pada layar lebih besar, tampilkan 2 card
					}
				}
			});
		</script>

		<div class="w-full bg-white py-20"></div>


		<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
		<script src="slider.js"></script>

		<!-- Bagian Sambutan Kepala Sekolah -->
		<div class="w-full bg-white py-20"></div>

		<div class="flex flex-col md:flex-row">
			<!-- Bagian kiri: Gambar dan teks di atas gambar -->
			<div class="relative w-full md:w-1/2 px-4 mb-8 md:mb-0">
				<div class="relative w-full h-64 md:h-96 overflow-hidden rounded-md">
					<!-- Gambar -->
					<img class="w-full h-full object-cover" src="uploads/identitas/<?= $d->foto_kepsek ?>" alt="Foto Kepala Sekolah">
					<!-- Card dengan teks di atas gambar -->
					<div class="absolute bottom-5 left-1/2 transform -translate-x-1/2 bg-white px-8 py-3 text-center rounded-lg shadow-lg">
						<p class="font-semibold text-black md:text-2xl"><?= $d->nama_kepsek ?></p>
						<span class="block text-base font-normal text-gray-500">Headmaster</span>
					</div>
				</div>
			</div>
			<!-- Bagian kanan: Teks sambutan -->
			<div class="w-full md:w-1/2 px-10">
				<span class="pre-title text-lg font-semibold text-gray-400 rounded">Sambutan</span>
				<h1 class="text-xl md:text-2xl mb-4 font-bold text-slate-700">Sambutan Kepala Sekolah<br> <?= $d->nama ?></h1>
				<p class="text-sm md:text-base text-slate-500"><?= $d->sambutan_kepsek ?></p>
			</div>
		</div>

		<div class="w-full bg-white py-20"></div>





		<div class="w-full bg-white py-40">
			<div class="container mx-auto slide-in-up">
				<div class="w-full bg-white py-20">
					<div class="container mx-auto">
						<div class="max-w-xl mb-16 text-center mx-auto">
							<h2 id="Kenapa Harus SMK Negeri 1 Sukawati?" class="text-2xl font-semibold mb-4">
								<?php echo get_translation('Why Should SMK Negeri 1 Sukawati?', $language); ?>
							</h2>
						</div>
						<div class="w-full flex flex-wrap justify-between ">
							<!-- Kolom 1 -->
							<div class="w-full md:w-1/2 lg:w-1/4 bg-white p-4 rounded-md shadow-md flex flex-col justify-center items-center text-center">
								<div class="space-y-3 hover:scale-110 transition-all duration-300">
									<img src="assets/ux.png" alt="" class="w-16">
								</div>
								<div>
									<a href="" class="font-semibold text-xl text-slate-800 hover:text-blue-600">
										<?php echo get_translation('The best quality', $language); ?>
									</a>
									<p><?php echo get_translation('Penunjang Belajar dengan kualitas terbaik', $language); ?></p>
								</div>
							</div>
							<!-- Kolom 2 -->
							<div class="w-full md:w-1/2 lg:w-1/4 bg-white p-4 rounded-md shadow-md flex flex-col justify-center items-center text-center">
								<div>
									<img src="assets/kerjasama.png" alt="" class="w-16">
								</div>
								<div>
									<a href="" class="font-semibold text-xl text-slate-800 hover:text-blue-600">
										<?php echo get_translation('Kerjasama luas', $language); ?>
									</a>
									<p><?php echo get_translation('Dapat kesempatan kerja yang lebih terjamin', $language); ?></p>
								</div>
							</div>
							<!-- Kolom 3 -->
							<div class="w-full md:w-1/2 lg:w-1/4 bg-white p-4 rounded-md shadow-md flex flex-col justify-center items-center text-center">
								<div>
									<img src="assets/teacher.png" alt="" class="w-16">
								</div>
								<div>
									<a href="" class="font-semibold text-xl text-slate-800 hover:text-blue-600">
										<?php echo get_translation('pengajar berkualitas', $language); ?>
									</a>
									<p><?php echo get_translation('Guru terbaik dengan pengalaman yang menjanjikan', $language); ?></p>
								</div>
							</div>
							<!-- Kolom 4 -->
							<div class="w-full md:w-1/2 lg:w-1/4 bg-white p-4 rounded-md shadow-md flex flex-col justify-center items-center text-center">
								<div>
									<img src="assets/trophy.png" alt="" class="w-16 hover:scale-110 transition-all duration-500">
								</div>
								<div>
									<a href="" class="font-semibold text-xl text-slate-800 hover:text-blue-600">Prestasi</a>
									<p>Setiap siswa didorong untuk berprestasi, baik dalam lomba tingkat nasional maupun internasional</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Bagian Jurusan -->
			<div class="relative w-full h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('');">
				<div class="text-center px-4 md:px-8 lg:px-12 bg-white/70 rounded-lg animate-fade-up">
					<h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800">
						Dapatkan Layanan dan Fasilitas <span class="text-blue-500">Terbaik Kami</span>.
						Tunggu apalagi, mari bergabung bersama kami!
					</h2>
					<a href="" target="_blank" rel="noopener" class="mt-6 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300">
						Pendaftaran <i class="icon-4"></i>
					</a>
				</div>
			</div>

			<!-- bagian informasi -->
			<div class="w-full bg-white py-20"></div>

			<div class="section slide-in-up">
				<div class="container text-center mx-auto">
					<?php
					// Ambil jenis berita dari database
					$jenis_informasi_result = mysqli_query($conn, "SELECT jenis_informasi FROM informasi ORDER BY id DESC LIMIT 1");
					$jenis_informasi = mysqli_fetch_array($jenis_informasi_result)['jenis_informasi'];
					?>

					<!-- Jenis Berita di Atas Judul -->
					<?php if (!empty($jenis_informasi)) { ?>
						<span class="pre-title text-lg font-semibold text-gray-400 px-3 py-1 rounded">Informasi</span>
					<?php } else { ?>
						<span class="pre-title text-lg font-semibold text-gray-400 px-3 py-1 rounded">Informasi</span>
					<?php } ?>

					<h1 class="font-bold text-slate-800 text-4xl capitalize mb-6">Informasi<span class="text-blue-600"> terkini</span></h1>
				</div>

				<div class="container mx-auto px-4">
					<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
						<?php
						// Ambil data informasi diurutkan berdasarkan created_at terbaru
						$informasi = mysqli_query($conn, "SELECT * FROM informasi ORDER BY created_at DESC LIMIT 9");
						if (mysqli_num_rows($informasi) > 0) {
							while ($p = mysqli_fetch_array($informasi)) {
						?>
								<div class="col-span-1">
									<a href="detail-informasi.php?id=<?= $p['id'] ?>" class="thumbnail-link">
										<div class="w-full p-4 bg-white rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300 ease-in-out">

											<img class="w-full h-40 object-cover rounded-t-lg" src="uploads/informasi/<?= $p['gambar'] ?>" alt="<?= $p['judul'] ?>">
											<div class="p-4">

												<div class="inline-block bg-blue-500 hover:bg-blue-700 text-xs text-white font-semibold py-1 px-2 rounded-md transition-all duration-300">
													<?= $jenis_informasi ?>
												</div>
												<div class="py-2 flex items-center">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-5">
														<path fill="#1E40AF" fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
													</svg>

													<?= date('d M Y', strtotime($p['created_at'])) ?>
												</div>

												<h2 class="text-lg font-semibold mt-2">
													<?= $p['judul'] ?>
												</h2>
												<p class="text-gray-600 mt-2">
													<?= strlen($p['deskripsi']) > 100 ? substr($p['deskripsi'], 0, 100) . '...' : $p['deskripsi'] ?>
												</p>
											</div>
										</div>
									</a>
								</div>

							<?php }
						} else { ?>
							<p class="text-gray-500">Tidak ada data</p>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include 'footer.php'; ?>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const slideInUpElements = document.querySelectorAll('.slide-in-up');

			function handleScroll() {
				slideInUpElements.forEach(el => {
					const rect = el.getBoundingClientRect();
					if (rect.top <= window.innerHeight - 50) {
						el.classList.add('show'); // Menambahkan kelas 'show' saat elemen terlihat
					}
				});
			}

			window.addEventListener('scroll', handleScroll);
			handleScroll(); // Jalankan sekali untuk memastikan animasi jika elemen sudah terlihat saat halaman dimuat
		});
	</script>
	<script>
		const mobileMenu = document.getElementById("mobileMenu");

		function showMobileMenu() {
			if (mobileMenu) {
				mobileMenu.classList.toggle("hidden");
			}
		}
	</script>