<?php include 'header.php'; ?>

<?php
// Fetch the information from the database
$informasi = mysqli_query($conn, "SELECT * FROM informasi WHERE id = '" . $_GET['id'] . "'");

if (mysqli_num_rows($informasi) == 0) {
    echo "<script>window.location='index.php'</script>";
}

$p = mysqli_fetch_object($informasi);

// Fetch latest news
$latest_news = mysqli_query($conn, "SELECT * FROM informasi ORDER BY created_at DESC LIMIT 5");
?>

<!-- Card for the article -->
<div class="card shadow-sm">
    <div class="w-full bg-white py-5"></div>

    <!-- Article Title -->
    <span class="text-center block pre-title text-lg font-semibold text-gray-400 rounded w-full">Berita</span>
    <h2 class="text-center my-2 mb-4 text-2xl font-semibold md:my-4 md:mb-8 md:text-5xl"><?= $p->judul ?></h2>
    <p class="text-muted text-center">
        <span style="display: inline-flex; align-items: center;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-5">
                <path fill="#1E40AF" fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
            </svg>
            <?= date('d M Y', strtotime($p->created_at)) ?>
        </span>

    </p>

    <div class=" bg-white py-10"></div>
    <!-- Article Content -->
    <div class="container mx-auto">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-12"></div>
        <!-- Image -->
        <div class="flex flex-col md:flex-row">
            <!-- Gambar di sebelah kiri -->
            <div class="md:w-1/1">
                <img class="myImg mb-10 aspect-[18/9] w-full cursor-pointer rounded-lg object-cover" src="uploads/informasi/<?= $p->gambar ?>">
                <p><?= $p->keterangan ?></p>
            </div>

            <!-- Card di sebelah kanan -->
            <div class="md:w-4/5 pl-10">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h3 class="text-gray-900 pb-2 text-xl font-bold sm:text-2xl mt-8">Berita Terbaru</h3>
                    <div class="space-y-4">
                        <?php while ($latest = mysqli_fetch_object($latest_news)): ?>
                            <div class="bg-white rounded-lg p-2">
                                <a href="detail.php?id=<?= $latest->id ?>" class="font-semibold text-lg mb-1 hover:text-blue-800 transition-colors duration-200"><?= $latest->judul ?></a>
                                <p class="text-sm text-gray-500"><?= date('d M Y', strtotime($latest->created_at)) ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>