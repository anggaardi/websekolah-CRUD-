<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Post Jurusan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items mx-1"><a href="jurusan.php">/ Jurusan </a></li>
                <li class="breadcrumb-items active">/ Post Jurusan</li>
            </ol>

            <form action="" method="POST" enctype="multipart/form-data" id="informasiForm">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-square-plus"></i> Tambah Jurusan</span>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary float-end">
                        <button type="reset" name="reset" id="resetButton" class="btn btn-danger float-end mx-1"><i class="fa-solid fa-xmark"></i> Reset</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <!-- Form Nama Jurusan -->
                                <div class="mb-3 row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama Jurusan</label>
                                    <label for="nama" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama" id="nama" placeholder="Nama" class="form-control border-0 border-bottom ps-2" required>
                                    </div>
                                </div>

                                <!-- Form Keterangan -->
                                <div class="mb-3 row">
                                    <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                    <label for="keterangan" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <textarea name="keterangan" id="keterangan" class="form-control border-0 border-bottom ps-2" placeholder="Keterangan"></textarea>
                                    </div>
                                </div>

                                <!-- Form Deskripsi -->
                                <div class="mb-3 row">
                                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                    <label for="deskripsi" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi" class="form-control border-0 border-bottom ps-2" required>
                                    </div>
                                </div>

                                <!-- Form Gambar -->
                                <div class="mb-3 row">
                                    <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                                    <label for="gambar" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="file" name="gambar" id="gambar" class="form-control border-0 border-bottom ps-2" required>
                                    </div>
                                </div>

                                <!-- Form Kegiatan (Gambar) -->
                                <div class="mb-3 row">
                                    <label for="kegiatan1" class="col-sm-2 col-form-label">Kegiatan 1 (Gambar)</label>
                                    <label for="kegiatan1" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="file" name="kegiatan1" id="kegiatan1" class="form-control border-0 border-bottom ps-2" accept="image/*">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kegiatan2" class="col-sm-2 col-form-label">Kegiatan 2 (Gambar)</label>
                                    <label for="kegiatan2" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="file" name="kegiatan2" id="kegiatan2" class="form-control border-0 border-bottom ps-2" accept="image/*">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kegiatan3" class="col-sm-2 col-form-label">Kegiatan 3 (Gambar)</label>
                                    <label for="kegiatan3" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="file" name="kegiatan3" id="kegiatan3" class="form-control border-0 border-bottom ps-2" accept="image/*">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kegiatan4" class="col-sm-2 col-form-label">Kegiatan 4 (Gambar)</label>
                                    <label for="kegiatan4" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="file" name="kegiatan4" id="kegiatan4" class="form-control border-0 border-bottom ps-2" accept="image/*">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kegiatan5" class="col-sm-2 col-form-label">Kegiatan 5 (Gambar)</label>
                                    <label for="kegiatan5" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="file" name="kegiatan5" id="kegiatan5" class="form-control border-0 border-bottom ps-2" accept="image/*">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kegiatan6" class="col-sm-2 col-form-label">Kegiatan 6 (Gambar)</label>
                                    <label for="kegiatan6" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="file" name="kegiatan6" id="kegiatan6" class="form-control border-0 border-bottom ps-2" accept="image/*">
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
                $ket = isset($_POST['keterangan']) ? addslashes($_POST['keterangan']) : null;
                $deskripsi = isset($_POST['deskripsi']) ? addslashes($_POST['deskripsi']) : null;

                // Proses file gambar utama
                $filename = $_FILES['gambar']['name'];
                $tmpname = $_FILES['gambar']['tmp_name'];
                $filesize = $_FILES['gambar']['size'];
                $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
                $rename = 'jurusan' . time() . '.' . $formatfile;

                $allowedtype = array('png', 'jpg', 'jpeg', 'gif');

                if (!in_array($formatfile, $allowedtype)) {
                    echo "<script>Swal.fire({title: 'Peringatan!', text: 'Format file tidak diizinkan', icon: 'warning'});</script>";
                } elseif ($filesize > 1000000) {
                    echo "<script>Swal.fire({title: 'Peringatan!', text: 'Ukuran file tidak boleh lebih dari 1MB.', icon: 'warning'});</script>";
                } else {
                    if (move_uploaded_file($tmpname, "../uploads/jurusan/" . $rename)) {
                        // Proses untuk kegiatan gambar
                        $kegiatan_gambar = [];
                        for ($i = 1; $i <= 6; $i++) {
                            if (isset($_FILES["kegiatan$i"]) && $_FILES["kegiatan$i"]['error'] == 0) {
                                $file = $_FILES["kegiatan$i"];
                                $kegiatan_filename = $file['name'];
                                $kegiatan_tmpname = $file['tmp_name'];
                                $kegiatan_filesize = $file['size'];
                                $kegiatan_formatfile = pathinfo($kegiatan_filename, PATHINFO_EXTENSION);
                                $kegiatan_rename = "kegiatan$i" . time() . '.' . $kegiatan_formatfile;
                                if (in_array($kegiatan_formatfile, $allowedtype) && $kegiatan_filesize <= 1000000) {
                                    if (move_uploaded_file($kegiatan_tmpname, "../uploads/kegiatan/" . $kegiatan_rename)) {
                                        $kegiatan_gambar[$i] = $kegiatan_rename;
                                    }
                                }
                            }
                        }

                        // Simpan data ke database
                        $simpan = mysqli_query($koneksi, "INSERT INTO jurusan (nama, keterangan, deskripsi, gambar, kegiatan1, kegiatan2, kegiatan3, kegiatan4, kegiatan5, kegiatan6) 
                        VALUES ('$nama', '$ket', '$deskripsi', '$rename', '{$kegiatan_gambar[1]}', '{$kegiatan_gambar[2]}', '{$kegiatan_gambar[3]}', '{$kegiatan_gambar[4]}', '{$kegiatan_gambar[5]}', '{$kegiatan_gambar[6]}')");

                        if ($simpan) {
                            echo "<script>Swal.fire({title: 'Berhasil!', text: 'Data jurusan berhasil disimpan.', icon: 'success', confirmButtonText: 'Ok'}).then((result) => { document.getElementById('informasiForm').reset(); });</script>";
                        }
                    }
                }
            }

            ?>
        </div>
    </main>
    <?php require_once "tamplate/footer.php"; ?>
</div>