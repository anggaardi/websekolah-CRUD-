<?php
// Include required files
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";

// Get the ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "ID not specified!";
    exit;
}

// Fetch the fasilitas data from the database based on the ID
$query = mysqli_query($koneksi, "SELECT * FROM fasilitas WHERE id = $id");
$data = mysqli_fetch_object($query);

// Check if the data exists
if (!$data) {
    echo "Fasilitas not found!";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $keterangan = $_POST['keterangan'];
    $deskripsi = $_POST['deskripsi'];

    // Handle image upload
    $gambar = $data->gambar; // Default to the existing image

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $target_dir = "../uploads/fasilitas/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an image
        if (getimagesize($_FILES["gambar"]["tmp_name"])) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $gambar = basename($_FILES["gambar"]["name"]);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    // Update the fasilitas record in the database
    $update_query = "UPDATE fasilitas SET judul = '$judul', keterangan = '$keterangan', deskripsi = '$deskripsi', gambar = '$gambar' WHERE id = $id";
    $update_result = mysqli_query($koneksi, $update_query);

    if ($update_result) {
        echo "<script>alert('Data updated successfully!'); window.location='fasilitas.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Fasilitas</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items active mx-1">/ Edit Fasilitas</li>
            </ol>

            <!-- Edit Form -->
            <div class="card">
                <div class="card-header">
                    <span class="h5 my-5"><i class="fa-solid fa-pen"></i> Edit Data Fasilitas</span>
                </div>
                <div class="card-body">
                    <form action="edit-fasilitas.php?id=<?= $data->id ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" value="<?= $data->judul ?>" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $data->keterangan ?>" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?= $data->deskripsi ?></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label for="gambar">Gambar</label><br>
                            <img src="../uploads/fasilitas/<?= htmlspecialchars($data->gambar) ?>" width="100px" alt="Current Image">
                            <input type="file" class="form-control mt-2" id="gambar" name="gambar">
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Update Fasilitas</button>
                            <a href="fasilitas.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<?php
require_once "tamplate/footer.php";
?>