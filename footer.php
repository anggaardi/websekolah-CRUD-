<div id="progress">
	<span id="progress-value">&#x1F815;</span>
</div>
<div class="mb-20"></div>
<footer class="text-white bg-blue-800">
	<div class="container mx-auto px-6 py-12">
		<div class="flex flex-wrap justify-between items-center mb-10">
			<!-- Logo dan Nama -->
			<div class="flex items-center">
				<img src="uploads/identitas/<?= $d->logo ?>" width="50" class="mr-3" alt="Logo">
				<h1 class="font-bold text-white text-xl uppercase">
					<a href="index.php" class="hover:text-blue-400"><?= $d->nama ?></a>
				</h1>
			</div>
		</div>

		<!-- Grid Footer -->
		<div class="grid grid-cols-1 md:grid-cols-12 gap-8">
			<!-- Tentang -->
			<div class="lg:col-span-4 col-span-12">
				<img class="h-12 mb-4">
				<p class="text-gray-300">
					SMKN 1 Sukawati yang juga dikenal dengan SSRI merupakan salah satu Sekolah Menengah Kejuruan Negeri
					yang ada di lingkungan Sukawati, dikelola oleh Yayasan Perguruan Rakyat.
				</p>
			</div>

			<!-- Links -->
			<div class="lg:col-span-2 md:col-span-4 col-span-12">
				<h5 class="text-lg font-semibold tracking-wide text-gray-100">Links</h5>
				<ul class="list-none mt-4 space-y-3">
					<li><a href="tentang-sekolah.php" class="hover:text-gray-400">Tentang Kami</a></li>
					<li><a href="informasi.php" class="hover:text-gray-400">Informasi</a></li>
					<li><a href="jurusan.php" class="hover:text-gray-400">Program Keahlian</a></li>
					<li><a href="fasilitas.php" class="hover:text-gray-400">Fasilitas</a></li>
					<li><a href="staff.php" class="hover:text-gray-400">Staff</a></li>
				</ul>
			</div>

			<!-- Kontak -->
			<div class="lg:col-span-3 md:col-span-4 col-span-12">
				<h5 class="text-lg font-semibold tracking-wide text-gray-100">Kontak</h5>
				<ul class="list-none mt-4 space-y-3">
					<li><a href="#" class="hover:text-gray-400">(0361) 263287</a></li>
					<li><a href="#" class="hover:text-gray-400">smkn1sukawati@gmail.com</a></li>
					<li>
						<a href="#" class="hover:text-gray-400">
							Kampus Kesenian Bali di Batubulan, Jalan SMKI, Br. Pegambanga, Batubulan, Gianyar Regency, Bali
						</a>
					</li>
				</ul>
			</div>

			<!-- Alamat dan Maps -->
			<div class="lg:col-span-3 md:col-span-4 col-span-12">
				<h5 class="text-lg font-semibold tracking-wide text-gray-100">Alamat Lengkap</h5>
				<div class="mt-4">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4473.929366970142!2d115.25611434542105!3d-8.60887583074473!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd23fb6eae9d0cb%3A0xa31b667573196fb1!2sSMK%20NEGERI%201%20SUKAWATI!5e0!3m2!1sid!2sid!4v1732030760958!5m2!1sid!2sid"
						width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
			</div>
		</div>

		<!-- Footer Bottom -->
		<div class="mt-10 border-t border-gray-700 pt-6 text-center">
			<p class="text-gray-400">© <?= date('Y') ?> SMKN 1 Sukawati. All Rights Reserved.</p>
		</div>
	</div>
</footer>