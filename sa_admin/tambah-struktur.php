<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Post Struktur Baru</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items mx-1"><a href="struktur_organisasi.php">/ Struktur </a></li>
                <li class="breadcrumb-items active">/ Post Struktur</li>
            </ol>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-square-plus"></i> Tambah Struktur</span>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary float-end">
                        <button type="reset" name="reset" class="btn btn-danger float-end mx-1"><i class="fa-solid fa-xmark"></i> Reset</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <div class="mb-3 row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama Struktur</label>
                                    <label for="nama" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama" id="nama" placeholder="Nama " class="form-control border-0 border-bottom ps-2" required>
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
                                    <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                                    <label for="foto" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="file" name="foto" id="foto" class="form-control border-0 border-bottom ps-2" required>
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
                $nama = isset($_POST['nama']) ? addslashes($_POST['nama']) : null;
                $deskripsi = isset($_POST['deskripsi']) ? addslashes($_POST['deskripsi']) : null;

                // Proses file foto
                $filename = $_FILES['foto']['name'];
                $tmpname = $_FILES['foto']['tmp_name'];
                $filesize = $_FILES['foto']['size'];

                $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
                $rename = 'struktur_' . time() . '.' . $formatfile;

                $allowedtype = array('png', 'jpg', 'JPG', 'jpeg', 'gif');

                // Validasi file
                if (!in_array($formatfile, $allowedtype)) {
                    echo '<div class="alert alert-danger">Format file tidak diizinkan.</div>';
                } elseif ($filesize > 1000000) {
                    echo '<div class="alert alert-danger">Ukuran file tidak boleh lebih dari 1 MB.</div>';
                } else {
                    // Pindahkan file foto ke folder uploads
                    if (move_uploaded_file($tmpname, "../uploads/struktur_organisasi/" . $rename)) {
                        // Query untuk menyimpan data ke database
                        $uid = $_SESSION['uid']; // Ambil uid dari session
                        $simpan = mysqli_query($koneksi, "INSERT INTO struktur_organisasi (nama, deskripsi, foto) 
                        VALUES ('$nama', '$deskripsi', '$rename')");


                        // Cek apakah query berhasil
                        if ($simpan) {
                            echo '<div class="alert alert-success">Simpan Berhasil</div>';
                        } else {
                            echo '<div class="alert alert-danger">Gagal menyimpan data: ' . mysqli_error($koneksi) . '</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger">Upload foto gagal.</div>';
                    }
                }
            }
            ?>
        </div>
    </main>
    <?php require_once "tamplate/footer.php"; ?>
</div>