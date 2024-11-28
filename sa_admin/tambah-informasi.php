<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Post Informasi</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items mx-1"><a href="informasi.php">/ Informasi </a></li>
                <li class="breadcrumb-items active">/ Post Informasi</li>
            </ol>

            <form action="" method="POST" enctype="multipart/form-data" id="informasiForm">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-square-plus"></i> Tambah Informasi</span>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary float-end">
                        <button type="reset" name="reset" id="resetButton" class="btn btn-danger float-end mx-1"><i class="fa-solid fa-xmark"></i> Reset</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <div class="mb-3 row">
                                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                                    <label for="judul" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="judul" id="judul" placeholder="Judul" class="form-control border-0 border-bottom ps-2" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                    <label for="keterangan" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <textarea name="keterangan" id="keterangan" class="form-control border-0 border-bottom ps-2" placeholder="Keterangan"></textarea>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                    <label for="deskripsi" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi" class="form-control border-0 border-bottom ps-2" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="jenis_informasi" class="col-sm-2 col-form-label">Jenis Informasi</label>
                                    <label for="jenis_informasi" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <select name="jenis_informasi" id="jenis_informasi" class="form-control" required>
                                            <option value="">--Pilih Jenis Informasi--</option>
                                            <option value="Pengumuman" <?php echo (isset($_POST['jenis_informasi']) && $_POST['jenis_informasi'] == 'Pengumuman') ? 'selected' : ''; ?>>Pengumuman</option>
                                            <option value="Informasi" <?php echo (isset($_POST['jenis_informasi']) && $_POST['jenis_informasi'] == 'Informasi') ? 'selected' : ''; ?>>Informasi</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                                    <label for="gambar" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="file" name="gambar" id="gambar" class="form-control border-0 border-bottom ps-2" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="created_at" class="col-sm-2 col-form-label">Tanggal</label>
                                    <label for="created_at" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="date" name="created_at" id="created_at" class="form-control border-0 border-bottom ps-2" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <?php
            // Proses jika form disubmit
            if (isset($_POST['simpan'])) {
                // Mengambil data dari form
                $judul = isset($_POST['judul']) ? addslashes($_POST['judul']) : null;
                $ket = isset($_POST['keterangan']) ? addslashes($_POST['keterangan']) : null;
                $deskripsi = isset($_POST['deskripsi']) ? addslashes($_POST['deskripsi']) : null;
                $jenis_informasi = isset($_POST['jenis_informasi']) ? addslashes($_POST['jenis_informasi']) : null;
                $created_at = isset($_POST['created_at']) ? $_POST['created_at'] : null;

                // Proses file gambar
                $filename = $_FILES['gambar']['name'];
                $tmpname = $_FILES['gambar']['tmp_name'];
                $filesize = $_FILES['gambar']['size'];

                $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
                $rename = 'informasi' . time() . '.' . $formatfile;

                $allowedtype = array('png', 'jpg', 'jpeg', 'gif');

                // Validasi file
                if (!in_array($formatfile, $allowedtype)) {
                    echo "
                    <script>
                        Swal.fire({
                            title: 'Peringatan!',
                            text: 'Format file tidak di izinkan',
                            icon: 'warning',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            // Form tetap terisi setelah peringatan
                            document.getElementById('informasiForm').reset();
                        });
                    </script>";
                } elseif ($filesize > 1000000) {
                    echo "
                    <script>
                        Swal.fire({
                            title: 'Peringatan!',
                            text: 'Ukuran file tidak boleh lebih dari 1MB.',
                            icon: 'warning',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            // Form tetap terisi setelah peringatan
                            document.getElementById('informasiForm').reset();
                        });
                    </script>";
                } else {
                    // Pindahkan file gambar ke folder uploads
                    if (move_uploaded_file($tmpname, "../uploads/informasi/" . $rename)) {
                        // Query untuk menyimpan data ke database
                        $uid = $_SESSION['uid']; // Ambil uid dari session
                        $simpan = mysqli_query($koneksi, "INSERT INTO informasi (judul, keterangan, deskripsi, jenis_informasi, gambar, created_at, user_id) 
                                    VALUES ('$judul', '$ket', '$deskripsi', '$jenis_informasi', '$rename', '$created_at', '$uid')");

                        // Cek apakah query berhasil
                        if ($simpan) {
                            echo "
                            <script>
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: 'Informasi Berhasil di Simpan.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'informasi.php'; 
                                    }
                                });
                            </script>";
                        } else {
                            echo "
                            <script>
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat menyimpan data.',
                                    icon: 'error',
                                    confirmButtonText: 'Coba Lagi'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'form_tambah.php'; // Ganti dengan URL form atau halaman yang relevan
                                    }
                                });
                            </script>";
                        }
                    } else {
                        echo '<div class="alert alert-danger">Upload gambar gagal.</div>';
                    }
                }
            }
            ?>
        </div>
    </main>
    <?php require_once "tamplate/footer.php"; ?>
</div>
