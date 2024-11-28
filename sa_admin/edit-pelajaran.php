<?php
require_once "koneksi.php";

// Check if ID is provided
if (!isset($_GET['id'])) {
    header('Location: pelajaran.php?error=id tidak ditemukan');
    exit;
}

$id = $_GET['id'];

// Fetch the subject's current data
$query = "SELECT * FROM tbl_pelajaran WHERE id = '$id'";
$result = mysqli_query($koneksi, $query);
if (mysqli_num_rows($result) == 0) {
    header('Location: pelajaran.php?error=Data tidak ditemukan');
    exit;
}

$data = mysqli_fetch_array($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pelajaran = $_POST['pelajaran'];
    $jurusan = $_POST['jurusan'];
    $guru = $_POST['guru'];

    // Update query
    $updateQuery = "UPDATE tbl_pelajaran SET pelajaran = '$pelajaran', jurusan = '$jurusan', guru = '$guru' WHERE id = '$id'";

    if (mysqli_query($koneksi, $updateQuery)) {
        header('Location: pelajaran.php?success=Data berhasil diperbarui');
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
                <h1 class="mt-4">Edit Data Mapel</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-items active mx-1">/ Edit Data Mapel</li>
                </ol>

                <?php if (isset($error)): ?>
                    <div class='alert alert-danger'><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        Form Edit Mapel
                        <button type="submit" name="submit" class="btn btn-primary float-end">
                            <i class="fa-solid fa-pen-nib me-1"></i> Update
                        </button>
                        <a href="pelajaran.php" class="btn btn-danger float-end mx-1"><i class="fa-solid fa-xmark"></i> Batal</a>
                    </div>
                    <div class="card-body">

                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="pelajaran" class="form-label">Mata Pelajaran</label>
                                <input type="text" class="form-control" id="pelajaran" name="pelajaran" value="<?= htmlspecialchars($data['pelajaran']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="jurusan" class="form-label ps-1">Jurusan</label>
                                <select class="form-select" id="jurusan" name="jurusan" required>
                                    <option value="" disabled>-- Pilih Jurusan --</option>
                                    <?php
                                    $queryjurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
                                    while ($datajurusan = mysqli_fetch_array($queryjurusan)) { ?>
                                        <option value="<?= htmlspecialchars($datajurusan['nama']) ?>"
                                            <?= $data['jurusan'] === $datajurusan['nama'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($datajurusan['nama']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="guru" class="form-label">Guru</label>
                                <select class="form-select" id="guru" name="guru" required>
                                    <option value="" disabled>-- Pilih Guru --</option>
                                    <?php
                                    $queryGuru = mysqli_query($koneksi, "SELECT * FROM tbl_guru");
                                    while ($guru = mysqli_fetch_assoc($queryGuru)) {
                                        $selected = $data['guru'] == $guru['nama'] ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($guru['nama']) . "' $selected>" . htmlspecialchars($guru['nama']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </main>
        <?php require_once "tamplate/footer.php"; ?>
    </div>
</div>