<?php
// Aktifkan error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "koneksi.php"; // Pastikan koneksi ke database sudah benar

// Cek jika form disubmit
if (isset($_POST['simpan'])) {
    $pelajaran = $_POST['pelajaran'];
    $jurusan = $_POST['jurusan'];
    $guru = $_POST['guru'];

    // Query untuk menyimpan data pelajaran
    $queryInsert = "INSERT INTO tbl_pelajaran (pelajaran, jurusan, guru) VALUES ('$pelajaran', '$jurusan', '$guru')";

    // Eksekusi query
    if (mysqli_query($koneksi, $queryInsert)) {
        header("Location: pelajaran.php?message=Pelajaran berhasil ditambahkan");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi); // Menampilkan error SQL
    }
}

// Cek jika ada pencarian
$search = $_POST['search'] ?? ''; // Menggunakan null coalescing operator

// Query untuk mengambil total data pelajaran
$totalQuery = "SELECT COUNT(*) as total FROM tbl_pelajaran WHERE 1=1"; // Awal query
if (!empty($search)) {
    $searchEscaped = mysqli_real_escape_string($koneksi, $search);
    $totalQuery .= " AND (pelajaran LIKE '%$searchEscaped%' OR jurusan LIKE '%$searchEscaped%')";
}

$totalResult = mysqli_query($koneksi, $totalQuery);
$totalData = mysqli_fetch_assoc($totalResult)['total'];

// Pagination settings
$limit = 5; // Jumlah data per halaman
$totalPages = ceil($totalData / $limit); // Menghitung total halaman
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$currentPage = max(1, min($totalPages, $currentPage)); // Membatasi halaman
$offset = ($currentPage - 1) * $limit; // Menghitung offset

// Query untuk mengambil data pelajaran dengan LIMIT dan OFFSET
$querypelajaran = "SELECT * FROM tbl_pelajaran WHERE 1=1"; // Awal query
if (!empty($search)) {
    $querypelajaran .= " AND (pelajaran LIKE '%$searchEscaped%' OR jurusan LIKE '%$searchEscaped%')";
}

$querypelajaran .= " ORDER BY id LIMIT $limit OFFSET $offset"; // Menyusun berdasarkan id
$resultPelajaran = mysqli_query($koneksi, $querypelajaran);

require_once "./tamplate/header.php";
require_once "./tamplate/navbar.php";
require_once "./tamplate/sidebar.php";
?>

<!-- content -->
<div class="card-body">

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Pelajaran</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item mx-1"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active mx-1">Data Pelajaran</li>
                </ol>

                <div class="row">
                    <!-- Kolom untuk Pencarian -->
                    <div class="col-md-4 mb-3">
                        <form action="" method="POST">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Cari Pelajaran atau Jurusan" value="<?= htmlspecialchars($search) ?>">
                                <button class="btn btn-primary" type="submit" name="search_button">Cari</button>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <!-- Kolom untuk Tambah Pelajaran -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    Tambah Pelajaran
                                </div>
                                <div class="card-body">
                                    <form action="" method="POST">
                                        <div class="mb-3">
                                            <label for="pelajaran" class="form-label ps-1">Pelajaran</label>
                                            <input type="text" class="form-control" id="pelajaran" name="pelajaran" placeholder="Nama Pelajaran" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jurusan" class="form-label ps-1">Jurusan</label>
                                            <select class="form-select" id="jurusan" name="jurusan" required>
                                                <option value="" selected>-- Pilih Jurusan --</option>
                                                <?php
                                                $queryjurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
                                                while ($datajurusan = mysqli_fetch_array($queryjurusan)) { ?>
                                                    <option value="<?= htmlspecialchars($datajurusan['nama']) ?>"><?= htmlspecialchars($datajurusan['nama']) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="guru" class="form-label ps-1">Guru</label>
                                            <select class="form-select" id="guru" name="guru" required>
                                                <option value="" selected>-- Pilih Guru --</option>
                                                <?php
                                                $queryguru = mysqli_query($koneksi, "SELECT * FROM tbl_guru");
                                                while ($dataguru = mysqli_fetch_array($queryguru)) { ?>
                                                    <option value="<?= htmlspecialchars($dataguru['nama']) ?>"><?= htmlspecialchars($dataguru['nama']) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary float-end">
                                        <button type="reset" name="reset" class="btn btn-danger float-end mx-1"><i class="fa-solid fa-xmark"></i> Reset</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom untuk Data Pelajaran -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    Data Pelajaran
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover">
                                        <thead>
                                            <?php if (isset($_GET['message'])): ?>
                                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                                <script>
                                                    const notyf = new Notyf();
                                                    notyf.success('Data berhasil disimpan!');
                                                </script>

                                            <?php endif; ?>

                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col" class="text-center">Mata Pelajaran</th>
                                                <th scope="col" class="text-center">Jurusan</th>
                                                <th scope="col" class="text-center">Guru</th>
                                                <th scope="col" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = $offset + 1; // Menghitung nomor urut
                                            while ($datapelajaran = mysqli_fetch_array($resultPelajaran)) { ?>
                                                <tr>
                                                    <th scope="row"><?= $no++ ?></th>
                                                    <td class=""><?= htmlspecialchars($datapelajaran['pelajaran']) ?></td>
                                                    <td class=""><?= htmlspecialchars($datapelajaran['jurusan']) ?></td>
                                                    <td class=""><?= htmlspecialchars($datapelajaran['guru']) ?></td>
                                                    <td class="text-center">
                                                        <a href="edit-pelajaran.php?id=<?= $datapelajaran['id'] ?>" title="Edit Data" class="btn btn-sm btn-warning">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= $datapelajaran['id'] ?>')"><i class="fa-solid fa-trash"></i></a>
                                                        <script>
                                                            function confirmDelete(idPelajaran) {
                                                                Swal.fire({
                                                                    title: 'Apakah Anda yakin?',
                                                                    text: 'Data pelajaran ini akan dihapus!',
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonText: 'Ya, hapus!',
                                                                    cancelButtonText: 'Batal',
                                                                    reverseButtons: true, // Membalik posisi tombol Cancel dan Confirm
                                                                    allowOutsideClick: true, // Izinkan menutup dengan klik di luar alert
                                                                    allowEscapeKey: true, // Izinkan menutup dengan tombol Escape
                                                                    focusCancel: true // Fokuskannya pada tombol cancel agar lebih mudah menutup alert
                                                                }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        window.location.href = 'hapus.php?idpelajaran=' + idPelajaran;
                                                                    }
                                                                });
                                                            }
                                                        </script>


                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                    <!-- Pagination -->
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                                <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php
        require_once "./tamplate/footer.php"; // Mengambil footer
        mysqli_close($koneksi); // Menutup koneksi
        ?>
    </div>
</div>