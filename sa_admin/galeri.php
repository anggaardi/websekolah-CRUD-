<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";

// Ambil nilai pencarian dari input
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

// Modifikasi query untuk memasukkan filter pencarian
$query = "SELECT * FROM informasi WHERE judul LIKE '%$search_query%' OR jenis_informasi LIKE '%$search_query%'";
$result = mysqli_query($koneksi, $query);
?>

<div id="layoutSidenav_content">
	<main>
		<div class="container-fluid px-4">
			<h1 class="mt-4">Post Informasi</h1>
			<ol class="breadcrumb mb-4">
				<li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
				<li class="breadcrumb-items active mx-1">/ Tambah Informasi</li>
			</ol>

			<!-- Form Pencarian -->
			<div class="mb-3">
				<form action="" method="GET">
					<div class="input-group">
						<input type="text" name="search_query" class="form-control" placeholder="Cari Informasi" value="<?= htmlspecialchars($search_query) ?>">
						<button type="submit" class="btn btn-primary">Cari</button>
					</div>
				</form>
			</div>

			<div class="card">
				<div class="card-header">
					<span class="h5 my-5"><i class="fa-solid fa-list"> Data Siswa</i></span>
					<a href="tambah-informasi.php" class="btn btn-sm btn-primary float-end"><i class="fa-solid fa-plus"></i> Tambah Siswa</a>
				</div>
				<div class="card-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<th scope="col">
									<center>No</center>
								</th>
								<th scope="col">
									<center>Judul</center>
								</th>
								<th scope="col">
									<center>Foto</center>
								</th>
								<th scope="col">
									<center>Jenis Informasi</center>
								</th>
								<th scope="col">
									<center>Isi Informasi</center>
								</th>
								<th scope="col">
									<center>Aksi</center>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							while ($row = mysqli_fetch_assoc($result)) {
								echo "<tr>";
								echo "<th scope='row'>{$no}</th>";
								echo "<td>{$row['judul']}</td>";

								// Menyesuaikan path gambar
								$imagePath = "../uploads/informasi/{$row['gambar']}";
								// Menampilkan gambar
								echo "<td><img src='{$imagePath}' style='width: 300px; height: auto;'></td>";

								echo "<td>{$row['jenis_informasi']}</td>";
								echo "<td>{$row['keterangan']}</td>";

								echo "<td align='center'>
                                    <a href='edit-informasi.php?id={$row['id']}' class='btn btn-sm btn-warning' title='Update Siswa'><i class='fa-solid fa-pen'></i></a>
                                    <a href='hapus.php?idinformasi={$row['id']}' class='btn btn-sm btn-danger' title='Hapus Siswa' onclick='return confirm(\"Yakin ingin menghapus informasi ini?\");'><i class='fa-solid fa-trash'></i></a>
                                   </td>";
								echo "</tr>";
								$no++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<?php require_once "tamplate/footer.php"; ?>
		</div>
	</main>
</div>