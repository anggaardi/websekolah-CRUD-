<?php include 'header.php'; ?>

<div class="section">
	<div class="container mx-auto px-4">
		<?php
		// Get the current jurusan based on the id from the URL
		$jurusan = mysqli_query($conn, "SELECT * FROM jurusan WHERE id = '" . $_GET['id'] . "' ");
		if (mysqli_num_rows($jurusan) == 0) {
			echo "<script>window.location='index.php'</script>";
		}
		$p = mysqli_fetch_object($jurusan);
		?>
	</div>
</div>

<div class="card shadow-sm">
	<div class="w-full bg-white py-5"></div>

	<!-- Article Title -->
	<div class="container mx-auto px-4 text-center">
		<span class="block pre-title text-lg font-semibold text-gray-400 rounded w-full">Jurusan</span>
		<h2 class="my-2 mb-4 text-2xl font-semibold md:my-4 md:mb-8 md:text-5xl"><?= $p->nama ?></h2>
		<p class="text-muted">
			<span style="display: inline-flex; align-items: center;">
				<!-- Icon here (optional) -->
			</span>
		</p>
	</div>

	<div class="bg-white py-10"></div>

	<!-- Article Content -->
	<div class="container mx-auto px-4">
		<div class="grid grid-cols-1 gap-10 md:grid-cols-12">
			<!-- Gambar di sebelah kiri -->
			<div class="md:col-span-8">
				<img class="myImg mb-10 aspect-[18/9] w-full cursor-pointer rounded-lg object-cover" src="uploads/jurusan/<?= $p->gambar ?>">
				<p><?= $p->keterangan ?></p>
			</div>

			<!-- Card di sebelah kanan -->
			<div class="md:col-span-4  md:pl-13">
				<div class="bg-white rounded-lg shadow-md p-4">
					<h3 class="text-gray-900 pb-2 text-xl font-bold sm:text-2xl mt-8">Jurusan Lainnya</h3>
					<div class="space-y-4">
						<?php
						// Get the list of other jurusan
						$jurusan_lain = mysqli_query($conn, "SELECT * FROM jurusan WHERE id != '" . $_GET['id'] . "' ORDER BY id DESC LIMIT 5");

						if (!$jurusan_lain) {
							echo "Error: " . mysqli_error($conn);
						}
						while ($lain = mysqli_fetch_object($jurusan_lain)): ?>
							<div class="bg-white rounded-lg p-2">
								<a href="option-jurusan.php?id=<?= $lain->id ?>" class="font-semibold text-lg mb-1 hover:text-blue-800 transition-colors duration-200"><?= $lain->nama ?></a>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Kegiatan Jurusan Section -->
		<div class="mt-10 p-6">
			<h3 class="text-xl font-bold mb-4 text-blue-500">Kegiatan Jurusan</h3>
			<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
				<?php
				// Cek apakah gambar kegiatan ada
				$gambarKegiatan1 = "uploads/kegiatan/" . $p->kegiatan1;
				$gambarKegiatan2 = "uploads/kegiatan/" . $p->kegiatan2;
				$gambarKegiatan3 = "uploads/kegiatan/" . $p->kegiatan3;
				$gambarKegiatan4 = "uploads/kegiatan/" . $p->kegiatan4;
				$gambarKegiatan5 = "uploads/kegiatan/" . $p->kegiatan5;
				$gambarKegiatan6 = "uploads/kegiatan/" . $p->kegiatan6;

				// Array for checking activities
				$kegiatan = [
					$gambarKegiatan1,
					$gambarKegiatan2,
					$gambarKegiatan3,
					$gambarKegiatan4,
					$gambarKegiatan5,
					$gambarKegiatan6
				];

				// Flag to check if any activity exists
				$hasActivity = false;

				// Loop through and check if any valid image or data exists
				foreach ($kegiatan as $gambar) {
					if (file_exists($gambar) && !empty($gambar)) {
						$hasActivity = true;
						break; // Exit loop if any valid data is found
					}
				}

				if (!$hasActivity) {
					// Display message if no data is found
					echo "<p class='text-center text-gray-500'>No activities available for this jurusan.</p>";
				} else {
					// Display images if activities exist
					foreach ($kegiatan as $gambar) {
						if (file_exists($gambar) && !empty($gambar)) {
							echo "<div class='flex items-center space-x-4'>
                            <img src='$gambar' class='w-full h-40 object-cover rounded-t-lg border'>
                          </div>";
						}
					}
				}
				?>
			</div>
		</div>
	</div>

	<?php include 'footer.php'; ?>