<?php include 'header.php'; ?>

<div class="section py-10">
	<div class="container mx-auto">
		<h3 class="text-center text-3xl font-bold mb-8">Galeri</h3>

		<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
			<?php
			$galeri = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
			if (mysqli_num_rows($galeri) > 0) {
				while ($p = mysqli_fetch_array($galeri)) {
			?>
					<div class="object-cover rounded-t-lg">
						<!-- Open Modal on Click -->
						<a href="#" class="block karya"

							<div class="h-48 bg-cover bg-center" style="background-image: url('uploads/galeri/<?= $p['foto'] ?>');">
					</div>
					</a>
		</div>
	<?php }
			} else { ?>
	<p class="text-center col-span-4 text-gray-500">Tidak ada data.</p>
<?php } ?>
	</div>
</div>
</div>

<!-- Modal Structure -->
<div id="myModal" class="modal">
	<div class="modal-content">
		<span class="close" onclick="closeModal()">&times;</span>
		<img id="modalImage" src="" alt="Karya Gambar" class="w-full h-96 object-cover mb-4">
		<h3 id="modalTitle" class="text-2xl font-bold mb-2"></h3>
		<p id="modalDescription" class="text-lg mb-4"></p>
		<p><strong id="modalAuthor"></strong></p>
		<p><strong>Kelas: </strong><span id="modalClassLevel"></span></p>
	</div>
</div>

<?php include 'footer.php'; ?>
<script>
	// Function to open modal and set content
	function openModal(image, title, description, author, classLevel) {
		document.getElementById('modalImage').src = 'uploads/galeri/' + image;
		document.getElementById('modalTitle').innerText = title;
		document.getElementById('modalDescription').innerText = description;
		document.getElementById('modalAuthor').innerText = 'Oleh: ' + author;
		document.getElementById('modalClassLevel').innerText = classLevel;
		document.getElementById('myModal').style.display = 'flex';
	}

	// Function to close modal
	function closeModal() {
		document.getElementById('myModal').style.display = 'none';
	}

	// Attaching click event to all gallery images
	const galleryItems = document.querySelectorAll('.karya');
	galleryItems.forEach(item => {
		item.addEventListener('click', function(event) {
			event.preventDefault(); // Prevent default behavior
			const image = item.getAttribute('data-image');
			const title = item.getAttribute('data-title');
			const description = item.getAttribute('data-description');
			const author = item.getAttribute('data-author');
			const classLevel = item.getAttribute('data-class');
			openModal(image, title, description, author, classLevel);
		});
	});

	// Modal close functionality when clicking the "X" button
	document.querySelector('.close').addEventListener('click', function() {
		closeModal();
	});

	// Smooth scroll functionality (Optional)
	document.addEventListener('DOMContentLoaded', () => {
		document.querySelectorAll('a[href^="#"]').forEach(anchor => {
			anchor.addEventListener('click', function(event) {
				event.preventDefault();
				const targetId = this.getAttribute('href');
				const targetElement = document.querySelector(targetId);
				if (targetElement) {
					targetElement.scrollIntoView({
						behavior: 'smooth',
						block: 'start'
					});
				}
			});
		});
	});
</script>