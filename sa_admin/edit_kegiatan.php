<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";

// Ensure the 'id' parameter exists in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query the database to fetch the data based on the id
    $query = "SELECT * FROM kegiatan_jurusan WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    // Check if data is found
    if (mysqli_num_rows($result) > 0) {
        // Fetch the data as an associative array
        $data = mysqli_fetch_assoc($result);
    } else {
        // If no data found, you might want to redirect or show an error message
        echo "<script>alert('Data tidak ditemukan'); window.location.href='index.php';</script>";
        exit();
    }
} else {
    // Redirect or show an error if 'id' is not passed in the URL
    echo "<script>alert('ID tidak ditemukan'); window.location.href='index.php';</script>";
    exit();
}
?>
<!-- Content -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Kegiatan Belajar</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items active mx-1">/ Edit Kegiatan Belajar</li>
            </ol>

            <!-- Form Edit Kegiatan -->
            <form action="kegiatan-belajar.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">

                <div class="form-group">
                    <label for="nama">Nama Jurusan</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="<?= $data['nama'] ?>" required>
                </div>

                <!-- Add image fields for gambar1 to gambar6 -->
                <div class="form-group">
                    <label for="gambar1">Gambar 1</label>
                    <input type="file" class="form-control" name="gambar1" id="gambar1">
                    <img src="../uploads/kegiatan/<?= $data['gambar1'] ?>" width="100px" alt="gambar1">
                </div>
                <div class="form-group">
                    <label for="gambar2">Gambar 2</label>
                    <input type="file" class="form-control" name="gambar2" id="gambar2">
                    <img src="../uploads/kegiatan/<?= $data['gambar2'] ?>" width="100px" alt="gambar2">
                </div>
                <div class="form-group">
                    <label for="gambar3">Gambar 3</label>
                    <input type="file" class="form-control" name="gambar3" id="gambar3">
                    <img src="../uploads/kegiatan/<?= $data['gambar3'] ?>" width="100px" alt="gambar3">
                </div>
                <div class="form-group">
                    <label for="gambar4">Gambar 4</label>
                    <input type="file" class="form-control" name="gambar4" id="gambar4">
                    <img src="../uploads/kegiatan/<?= $data['gambar4'] ?>" width="100px" alt="gambar4">
                </div>
                <div class="form-group">
                    <label for="gambar5">Gambar 5</label>
                    <input type="file" class="form-control" name="gambar5" id="gambar5">
                    <img src="../uploads/kegiatan/<?= $data['gambar5'] ?>" width="100px" alt="gambar5">
                </div>
                <div class="form-group">
                    <label for="gambar6">Gambar 6</label>
                    <input type="file" class="form-control" name="gambar6" id="gambar6">
                    <img src="../uploads/kegiatan/<?= $data['gambar6'] ?>" width="100px" alt="gambar6">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </main>
</div>

<?php
require_once "tamplate/footer.php";
?>