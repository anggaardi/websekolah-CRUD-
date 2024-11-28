<?php include 'header.php'; ?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    // Mengambil data tanpa kolom created_by
    $informasi = mysqli_query($conn, "SELECT * FROM informasi WHERE id = '$id'");

    if (mysqli_num_rows($informasi) > 0) {
        $p = mysqli_fetch_object($informasi);
    } else {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>

<div class="w-full bg-white py-5"></div>
<span class="text-center block pre-title text-lg font-semibold text-gray-400 rounded w-full">Berita</span>
<h2 class="text-center my-2 mb-4 text-2xl font-semibold md:my-4 md:mb-8 md:text-5xl"><?= $p->judul ?></h2>
<p class="text-muted text-center">
    <span style="display: inline-flex; align-items: center;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-5">
            <path fill="#1E40AF" fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
        </svg>
        <?= date('d M Y', strtotime($p->created_at)) ?>
    </span>
    <!-- Hapus bagian ini jika tidak ada nama penulis -->
    <span style="display: inline-flex; align-items: center;">
        <svg xmlns="http://www.w3.org/2000/svg" height="24" width="40.25" viewBox="0 0 640 512">
            <path fill="#1E40AF" d="M337.8 5.4C327-1.8 313-1.8 302.2 5.4L166.3 96 48 96C21.5 96 0 117.5 0 144L0 464c0 26.5 21.5 48 48 48l208 0 0-96c0-35.3 28.7-64 64-64s64 28.7 64 64l0 96 208 0c26.5 0 48-21.5 48-48l0-320c0-26.5-21.5-48-48-48L473.7 96 337.8 5.4zM96 192l32 0c8.8 0 16 7.2 16 16l0 64c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-64c0-8.8 7.2-16 16-16zm400 16c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16l0 64c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-64zM96 320l32 0c8.8 0 16 7.2 16 16l0 64c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-64c0-8.8 7.2-16 16-16zm400 16c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16l0 64c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-64zM232 176a88 88 0 1 1 176 0 88 88 0 1 1 -176 0zm88-48c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-16 0 0-16c0-8.8-7.2-16-16-16z" />
        </svg>
        <!-- Hapus atau ganti dengan informasi lain jika tidak ada penulis -->
        <!-- <?= $p->nama ?> -->
    </span>
</p>
<div class="w-full bg-white py-5"></div>

<div class="container mx-auto">
    <div class="flex flex-col md:flex-row">
        <div class="md:w-1/1">
            <img class="myImg mb-10 aspect-[18/9] w-full cursor-pointer rounded-lg object-cover" src="uploads/informasi/<?= $p->gambar ?>">
            <p><?= $p->keterangan ?></p>
        </div>

        <div class="md:w-4/5 pl-10">
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="text-gray-900 pb-2 text-xl font-bold sm:text-2xl mt-8">Berita Terbaru</h3>
                <div class="space-y-4">
                    <?php
                    // Fetch latest news without created_by
                    $latest_news = mysqli_query($conn, "SELECT * FROM informasi ORDER BY created_at DESC LIMIT 5");

                    if ($latest_news) {
                        while ($latest = mysqli_fetch_object($latest_news)) {
                            echo '<div class="bg-white rounded-lg p-2">';
                            echo '<a href="detail.php?id=' . $latest->id . '" class="font-semibold text-lg mb-1 hover:text-blue-800 transition-colors duration-200">' . $latest->judul . '</a>';
                            echo '<p class="text-sm text-gray-500">' . date('d M Y', strtotime($latest->created_at)) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Tidak ada berita terbaru.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>