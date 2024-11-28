<?php
require_once "koneksi.php";

// Check if NIP is provided
if (!isset($_GET['nip'])) {
    header('Location: guru.php?error=NIP tidak ditemukan');
    exit;
}

$nip = $_GET['nip'];

// Fetch the teacher's current data
$query = "SELECT * FROM tbl_guru WHERE nip = '$nip'";
$result = mysqli_query($koneksi, $query);
if (mysqli_num_rows($result) == 0) {
    header('Location: guru.php?error=Data tidak ditemukan');
    exit;
}

$dataGuru = mysqli_fetch_array($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $telpon = $_POST['telpon'];
    $alamat = $_POST['alamat'];

    // Update query
    $updateQuery = "UPDATE tbl_guru SET nama = '$nama', telpon = '$telpon', alamat = '$alamat' WHERE nip = '$nip'";

    if (mysqli_query($koneksi, $updateQuery)) {
        header('Location: guru.php?success=Data berhasil diperbarui');
        exit;
    } else {
        $error = "Error: " . mysqli_error($koneksi);
    }
}

require_once "./tamplate/header.php";
require_once "./tamplate/navbar.php";
require_once "./tamplate/sidebar.php";
?>

<div class="card-body">

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Data Guru</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-items active mx-1">/ Edit Data Guru</li>
                </ol>

                <?php if (isset($error)): ?>
                    <div class='alert alert-danger'><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="card">
                        <div class="card-header">
                            <button type="submit" class="btn btn-primary">Perbarui Data</button>

                            Form Edit Guru
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" value="<?= htmlspecialchars($dataGuru['nip']) ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($dataGuru['nama']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="telpon" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="telpon" name="telpon" value="<?= htmlspecialchars($dataGuru['telpon']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" required><?= htmlspecialchars($dataGuru['alamat']) ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Perbarui Data</button>

                </form>
            </div>
    </div>

    <?php require_once "tamplate/footer.php"; ?>
</div>
</main>
</div>
</div>