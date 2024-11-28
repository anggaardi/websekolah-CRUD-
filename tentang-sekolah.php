	<?php include 'header.php'; ?>


	<img src="uploads/identitas/<?= $d->foto_sekolah ?>" class="w-full h-64 object-cover ">
	<div class="container mx-auto mt-10">

		<?= $d->tentang_sekolah ?>
	</div>


	<?php include 'footer.php'; ?>
	<script src="https://cdn.tiny.cloud/1/6kvrps9mr93fvjl80xzf7br92qlrgpsekt08nl86i3c7cscu/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
	<script>
		tinymce.init({
			selector: '#keterangan', // Ganti dengan ID elemen textarea kamu
			menubar: false, // Menonaktifkan menubar jika tidak diperlukan
			toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | code', // Aktifkan styleselect
			style_formats: [{
					title: 'Heading 1',
					block: 'h1'
				}, // Tambahkan h1 di sini
				{
					title: 'Heading 2',
					block: 'h2'
				},
				{
					title: 'Heading 3',
					block: 'h3'
				},
				{
					title: 'Paragraph',
					block: 'p'
				}
			],
			plugins: 'code' // Tambahkan plugin code jika diperlukan
		});
	</script>