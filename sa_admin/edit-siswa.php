<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";

// Ambil ID siswa dari parameter URL
$nis = $_GET['nis'] ?? null;

// Cek apakah ID valid
if (!$nis) {
    echo "<script>
            const notyf = new Notyf();
            notyf.error('ID siswa tidak valid.');
            setTimeout(function() {
                window.location.href = 'siswa.php';
            }, 3000); // Redirect after 3 seconds
          </script>";
    exit;
}

// Ambil data siswa berdasarkan NIS
$query = "SELECT * FROM tbl_siswa WHERE nis = '$nis'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) === 1) {
    $siswa = mysqli_fetch_assoc($result);
} else {
    echo "<script>
            const notyf = new Notyf();
            notyf.error('Data siswa tidak ditemukan.');
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 3000); // Redirect after 3 seconds
          </script>";
    exit;
}

// Proses update data jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $alamat = $_POST['alamat'];

    // Update data siswa di database
    $updateQuery = "UPDATE tbl_siswa SET 
                    nama = '$nama',
                    kelas = '$kelas',
                    jurusan = '$jurusan',
                    alamat = '$alamat'
                    WHERE nis = '$nis'";

    // Mengeksekusi query update
    if (mysqli_query($koneksi, $updateQuery)) {
        echo "<script>
                const notyf = new Notyf();
                notyf.success('Data siswa berhasil diperbarui.');
                setTimeout(function() {
                    window.location.href = 'siswa.php';
                }, 1000); // Redirect after 3 seconds
              </script>";
        exit;
    } else {
        echo "<script>
                const notyf = new Notyf();
                notyf.error('Terjadi kesalahan dalam memperbarui data.');
              </script>";
    }
}

?>


<body>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Siswa</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-items mx-1"><a href="index.php">Data Siswa</a></li>
                    <li class="breadcrumb-items active mx-1">/ Edit Siswa</li>
                </ol>
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-5"><i class="fa-solid fa-user-edit"></i> Edit Data Siswa</span>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="nis" class="form-label">NIS</label>
                                <input type="text" class="form-control" id="nis" name="nis" value="<?= $siswa['nis']; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $siswa['nama']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="kelas" class="form-label ps-1">Kelas</label>
                                <select name="kelas" id="kelas" class="form-select" required>
                                    <option value="" disabled>--Pilih Kelas--</option>
                                    <option value="X" <?= $siswa['kelas'] === 'X' ? 'selected' : '' ?>>X</option>
                                    <option value="XI" <?= $siswa['kelas'] === 'XI' ? 'selected' : '' ?>>XI</option>
                                    <option value="XII" <?= $siswa['kelas'] === 'XII' ? 'selected' : '' ?>>XII</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="jurusan" class="form-label ps-1">Jurusan</label>
                                <select class="form-select" id="jurusan" name="jurusan" required>
                                    <option value="" disabled>-- Pilih Jurusan --</option>
                                    <?php
                                    $queryjurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
                                    while ($datajurusan = mysqli_fetch_array($queryjurusan)) { ?>
                                        <option value="<?= htmlspecialchars($datajurusan['nama']) ?>"
                                            <?= $siswa['jurusan'] === $datajurusan['nama'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($datajurusan['nama']) ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= $siswa['alamat']; ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="siswa.php" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const notyf = new Notyf(); // Initialize Notyf
    </script>
</body>

</html>