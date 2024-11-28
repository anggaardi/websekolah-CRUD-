<?php include 'header.php'; ?>

<?php
// Menghitung total informasi
$total_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM informasi");
$total_row = mysqli_fetch_assoc($total_query);
$total_informasi = $total_row['total'];

$limit = 15; // Jumlah informasi per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman yang sedang diakses
$offset = ($page - 1) * $limit; // Hitung offset untuk query

// Fetch informasi dari database dengan batasan
$informasi_query = mysqli_query($conn, "SELECT id, judul, deskripsi, created_at, gambar, jenis_informasi FROM informasi ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
?>

<div class="section">
    <div class="container mx-auto">
        <div class="w-full bg-white py-5"></div>

        <h3 class="text-center pre-title text-lg font-semibold text-gray-400 rounded">Informasi</h3>
        <h1 class="font-bold text-black text-2xl uppercase text-center">
            <a href="index.php" class="hover:text-blue-800 transition-colors duration-200"><?= $d->nama ?></a>
        </h1>
        <div class="w-full bg-white py-5"></div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
            <?php if (mysqli_num_rows($informasi_query) > 0): ?>
                <?php while ($p = mysqli_fetch_array($informasi_query)): ?>
                    <div class="col-span-1">
                        <a href="detail-informasi.php?id=<?= $p['id'] ?>" class="thumbnail-link">
                            <div class="w-96 p-4 bg-white rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300 ease-in-out">
                                <!-- Gambar -->
                                <img class="w-full h-40 object-cover rounded-t-lg" src="uploads/informasi/<?= $p['gambar'] ?>" alt="<?= $p['judul'] ?>">

                                <!-- Konten Card -->
                                <div class="p-4">
                                    <!-- Judul -->
                                    <h2 class="text-xl font-semibold"><?= strlen($p['judul']) > 50 ? substr($p['judul'], 0, 50) . '...' : $p['judul'] ?></h2>

                                    <!-- Jenis Informasi -->

                                    <!-- Deskripsi -->
                                    <p class="text-gray-600 mt-2">
                                        <?= strlen($p['deskripsi']) > 100 ? substr($p['deskripsi'], 0, 100) . '...' : $p['deskripsi'] ?>
                                    </p>

                                    <!-- Tanggal -->
                                    <p class="text-gray-400 mt-1"><?= date('d M Y', strtotime($p['created_at'])) ?></p>

                                    <!-- Tombol -->
                                    <div class="flex justify-between items-center mt-4">
                                        <button class="text-blue-500">
                                            Learn More
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-gray-500">Tidak ada data</p>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center my-4">
            <?php
            $total_pages = ceil($total_informasi / $limit); // Hitung total halaman
            for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?= $i ?>" class="mx-2 <?= ($i == $page) ? 'font-bold text-blue-600' : 'text-gray-600' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
</div>
''
<?php include 'footer.php'; ?>