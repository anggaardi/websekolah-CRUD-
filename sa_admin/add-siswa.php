<?php
require_once "koneksi.php";
$title = "Tambah Siswa - SMKN 1 Sukawati";
require_once "./tamplate/header.php";
require_once "./tamplate/navbar.php";
require_once "./tamplate/sidebar.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Siswa</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items mx-1"><a href="siswa.php">/ Siswa </a></li>
                <li class="breadcrumb-items active">/ Tambah Siswa</li>
            </ol>

            <form action="" method="POST">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-square-plus"></i> Tambah Siswa</span>
                        <button type="submit" name="simpan" class="btn btn-primary float-end"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                        <button type="reset" name="reset" class="btn btn-danger float-end mx-1"><i class="fa-solid fa-xmark"></i> Reset</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <div class="mb-3 row">
                                    <label for="nis" class="col-sm-2 col-form-label">NIS</label>
                                    <label for="nis" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left:-50px">
                                        <input type="text" name="nis" class="form-control border-0 border-bottom ps-2" id="nis" value="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                    <label for="nama" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left:-50px">
                                        <input type="text" name="nama" class="form-control border-0 border-bottom ps-2" id="nama" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                                    <label for="kelas" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left:-50px">
                                        <select name="kelas" id="kelas" class="form-select border-0 border-bottom" required>
                                            <option value="" disabled selected>--Pilih Kelas--</option>
                                            <option value="X">X</option>
                                            <option value="XI">XI</option>
                                            <option value="XII">XII</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                                    <label for="jurusan" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left:-50px">
                                        <select class="form-select border-0 border-bottom" id="jurusan" name="jurusan" required>
                                            <option value="" selected>-- Pilih Jurusan --</option>
                                            <?php
                                            $queryjurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
                                            while ($datajurusan = mysqli_fetch_array($queryjurusan)) { ?>
                                                <option value="<?= htmlspecialchars($datajurusan['nama']) ?>"><?= htmlspecialchars($datajurusan['nama']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                    <label for="alamat" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9" style="margin-left:-50px">
                                        <textarea name="alamat" id="alamat" cols="30" rows="3" placeholder="Alamat Siswa" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <?php require_once "tamplate/footer.php"; ?>
</div>
<?php
require_once "koneksi.php";

if (isset($_POST['simpan'])) {
    // Ambil data dari form
    $nis = htmlspecialchars($_POST['nis']); // Mengambil NIS dari input
    $nama = htmlspecialchars($_POST['nama']);
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $alamat = htmlspecialchars($_POST['alamat']);

    // Query untuk menyimpan data
    $query = "INSERT INTO tbl_siswa (nis, nama, alamat, kelas, jurusan) VALUES ('$nis', '$nama', '$alamat', '$kelas', '$jurusan')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                const notyf = new Notyf();
                notyf.success('Data Siswa berhasil disimpan!');
                setTimeout(function() {
                    window.location.href = 'add-siswa.php';
                }, 2000); // 
              </script>";
    } else {
        echo "<script>
                const notyf = new Notyf();
                notyf.error('Data Siswa gagal disimpan: " . mysqli_error($koneksi) . "');
              </script>";
    }
}
?>
<link href="https://cdn.jsdelivr.net/npm/notyf@3.6.0/notyf.min.css" rel="stylesheet">
<!-- Link to Notyf JS -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3.6.0/notyf.min.js"></script>