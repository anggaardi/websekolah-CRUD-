<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";

// Mendapatkan ID informasi dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) {
    echo "ID informasi tidak ditemukan.";
    exit;
}

// Mengambil data informasi berdasarkan ID
$query = "SELECT * FROM informasi WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$informasi = $result->fetch_assoc();

if (!$informasi) {
    echo "Informasi tidak ditemukan.";
    exit;
}

// Memproses data yang di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $jenis_informasi = $_POST['jenis_informasi'];
    $keterangan = $_POST['keterangan'];
    $deskripsi = $_POST['deskripsi']; // Menambahkan deskripsi

    // Memproses upload gambar jika ada
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $target_dir = "../uploads/informasi/";
        $target_file = $target_dir . basename($foto);

        // Mengupload file
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            // Menghapus gambar lama jika ada
            if (!empty($informasi['gambar'])) {
                unlink($target_dir . $informasi['gambar']);
            }
        }
    } else {
        $foto = $informasi['gambar']; // Menggunakan gambar yang sudah ada
    }

    // Update data ke database
    $updateQuery = "UPDATE informasi SET judul = ?, jenis_informasi = ?, keterangan = ?, gambar = ?, deskripsi = ? WHERE id = ?";
    $stmt = $koneksi->prepare($updateQuery);
    $stmt->bind_param("sssssi", $judul, $jenis_informasi, $keterangan, $foto, $deskripsi, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Informasi berhasil diperbarui'); window.location.href='index.php';</script>";
    } else {
        echo "Gagal memperbarui informasi.";
    }
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Informasi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items active mx-1">/ Edit Informasi</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-pen"></i> Form Edit Informasi
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($informasi['judul']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_informasi" class="form-label">Jenis Informasi</label>
                            <input type="text" name="jenis_informasi" class="form-control" value="<?= htmlspecialchars($informasi['jenis_informasi']); ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="input-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Keterangan"><?= htmlspecialchars($informasi['keterangan']); ?></textarea>
                        </div>

                        <!-- Deskripsi Section -->
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="input-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Deskripsi"><?= htmlspecialchars($informasi['deskripsi']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control">
                            <?php if ($informasi['gambar']): ?>
                                <img src="../uploads/informasi/<?= htmlspecialchars($informasi['gambar']); ?>" style="width: 150px; height: auto; margin-top: 10px;">
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="index.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
                <?php require_once "tamplate/footer.php"; ?>
            </div>
        </div>
    </main>
</div>