<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Get the current data of the record
    $query = mysqli_query($koneksi, "SELECT * FROM fasilitas_jurusan WHERE id = '$id'");
    $data = mysqli_fetch_assoc($query);
} else {
    header("Location: fasilitas_jurusan.php");
    exit;
}

// Handle form submission for editing the data
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $gambar1 = $_FILES['gambar1']['name'];
    $gambar2 = $_FILES['gambar2']['name'];
    $gambar3 = $_FILES['gambar3']['name'];
    $gambar4 = $_FILES['gambar4']['name'];
    $gambar5 = $_FILES['gambar5']['name'];
    $gambar6 = $_FILES['gambar6']['name'];

    // Check and upload images
    $uploadDir = "../uploads/fasilitas_jurusan/";
    if ($gambar1) move_uploaded_file($_FILES['gambar1']['tmp_name'], $uploadDir . $gambar1);
    if ($gambar2) move_uploaded_file($_FILES['gambar2']['tmp_name'], $uploadDir . $gambar2);
    if ($gambar3) move_uploaded_file($_FILES['gambar3']['tmp_name'], $uploadDir . $gambar3);
    if ($gambar4) move_uploaded_file($_FILES['gambar4']['tmp_name'], $uploadDir . $gambar4);
    if ($gambar5) move_uploaded_file($_FILES['gambar5']['tmp_name'], $uploadDir . $gambar5);
    if ($gambar6) move_uploaded_file($_FILES['gambar6']['tmp_name'], $uploadDir . $gambar6);

    // Update the data in the database
    $updateQuery = "UPDATE fasilitas_jurusan SET 
                        nama = '$nama',
                        gambar1 = '$gambar1',
                        gambar2 = '$gambar2',
                        gambar3 = '$gambar3',
                        gambar4 = '$gambar4',
                        gambar5 = '$gambar5',
                        gambar6 = '$gambar6'
                    WHERE id = '$id'";

    if (mysqli_query($koneksi, $updateQuery)) {
        echo "<script>alert('Data berhasil diupdate!'); window.location = 'fasilitas_jurusan.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data!');</script>";
    }
}
?>

<!-- Form for editing the fasilitas jurusan -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Fasilitas Jurusan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items active mx-1">/ Edit Fasilitas Jurusan</li>
            </ol>

            <div class="card">
                <div class="card-header">
                    <span class="h5 my-5"><i class="fa-solid fa-list"> Edit Data Fasilitas Jurusan</i></span>
                    <a href="fasilitas_jurusan.php" class="btn btn-sm btn-secondary float-end"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                </div>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Jurusan</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= $data['nama'] ?>" required>
                        </div>
                        <!-- Gambar 1 -->
                        <div class="mb-3">
                            <label for="gambar1" class="form-label">Gambar 1</label>
                            <input type="file" class="form-control" name="gambar1" id="gambar1">
                            <img src="../uploads/fasilitas_jurusan/<?= $data['gambar1'] ?>" width="100px" alt="Gambar 1">
                        </div>
                        <!-- Gambar 2 -->
                        <div class="mb-3">
                            <label for="gambar2" class="form-label">Gambar 2</label>
                            <input type="file" class="form-control" name="gambar2" id="gambar2">
                            <img src="../uploads/fasilitas_jurusan/<?= $data['gambar2'] ?>" width="100px" alt="Gambar 2">
                        </div>
                        <!-- Gambar 3 -->
                        <div class="mb-3">
                            <label for="gambar3" class="form-label">Gambar 3</label>
                            <input type="file" class="form-control" name="gambar3" id="gambar3">
                            <img src="../uploads/fasilitas_jurusan/<?= $data['gambar3'] ?>" width="100px" alt="Gambar 3">
                        </div>
                        <!-- Gambar 4 -->
                        <div class="mb-3">
                            <label for="gambar4" class="form-label">Gambar 4</label>
                            <input type="file" class="form-control" name="gambar4" id="gambar4">
                            <img src="../uploads/fasilitas_jurusan/<?= $data['gambar4'] ?>" width="100px" alt="Gambar 4">
                        </div>
                        <!-- Gambar 5 -->
                        <div class="mb-3">
                            <label for="gambar5" class="form-label">Gambar 5</label>
                            <input type="file" class="form-control" name="gambar5" id="gambar5">
                            <img src="../uploads/fasilitas_jurusan/<?= $data['gambar5'] ?>" width="100px" alt="Gambar 5">
                        </div>
                        <!-- Gambar 6 -->
                        <div class="mb-3">
                            <label for="gambar6" class="form-label">Gambar 6</label>
                            <input type="file" class="form-control" name="gambar6" id="gambar6">
                            <img src="../uploads/fasilitas_jurusan/<?= $data['gambar6'] ?>" width="100px" alt="Gambar 6">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Update Data</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
require_once "tamplate/footer.php";
?>