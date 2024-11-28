<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Post Kegiatan Pembelajaran</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items mx-1"><a href="kegiatan-belajar.php">/ Kegiatan Belajar</a></li>
                <li class="breadcrumb-items active">/ Post Kegiatan</li>
            </ol>

            <form action="" method="POST" enctype="multipart/form-data" id="informasiForm" class="space-y-4">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-square-plus"></i> Tambah Kegiatan</span>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary float-end">
                        <button type="reset" name="reset" class="btn btn-danger float-end mx-1"><i class="fa-solid fa-xmark"></i> Reset</button>
                    </div>



                    <div class="card-body py-4 px-4 space-y-4">
                        <!-- Select Jurusan -->
                        <div class="flex items-center mb-4">
                            <label for="jurusan" class="w-1/4 text-right pr-4">Nama Jurusan :</label>
                            <select class="form-control w-3/4 border-0 border-b p-2" id="nama" name="nama" required>
                                <option value="" selected>-- Pilih Jurusan --</option>
                                <?php
                                $queryjurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
                                while ($datajurusan = mysqli_fetch_array($queryjurusan)) { ?>
                                    <option value="<?= htmlspecialchars($datajurusan['nama']) ?>"><?= htmlspecialchars($datajurusan['nama']) ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Gambar Upload -->
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <div class="flex items-center mb-4">
                                <label for="gambar<?= $i ?>" class="w-1/4 text-right pr-4">Gambar <?= $i ?>:</label>
                                <div class="w-3/4">
                                    <input type="file" name="gambar<?= $i ?>" id="gambar<?= $i ?>" class="form-control border-0 border-b p-2 w-full" <?= $i === 1 ? 'required' : '' ?> onchange="previewImage(event, <?= $i ?>)">
                                    <div class="mt-2">
                                        <img id="preview<?= $i ?>" src="" alt="Preview Image <?= $i ?>" style="max-width: 100px; display: none;">
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </form>
            <?php require_once "tamplate/footer.php"; ?>
        </div>
    </main>
</div>

<?php

if (isset($_POST['simpan'])) {
    $nama = isset($_POST['nama']) ? addslashes($_POST['nama']) : null;

    $allowedtype = array('png', 'jpg', 'jpeg', 'gif');
    $gagal_upload = false;
    $gambar_filenames = [];

    for ($i = 1; $i <= 6; $i++) {
        if (isset($_FILES["gambar$i"]) && $_FILES["gambar$i"]['name'] != '') {
            $filename = $_FILES["gambar$i"]['name'];
            $tmpname = $_FILES["gambar$i"]['tmp_name'];
            $filesize = $_FILES["gambar$i"]['size'];
            $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
            $rename = 'jurusan' . time() . "_$i." . $formatfile;

            if (!in_array($formatfile, $allowedtype)) {
                echo "
                    <script>
                        Swal.fire({
                            title: 'Peringatan!',
                            text: 'Format file gambar $i tidak diizinkan',
                            icon: 'warning',
                            confirmButtonText: 'Ok'
                        });
                    </script>";
                $gagal_upload = true;
                break;
            } elseif ($filesize > 1000000) {
                echo "
                    <script>
                        Swal.fire({
                            title: 'Peringatan!',
                            text: 'Ukuran file gambar $i tidak boleh lebih dari 1MB.',
                            icon: 'warning',
                            confirmButtonText: 'Ok'
                        });
                    </script>";
                $gagal_upload = true;
                break;
            } else {
                if (move_uploaded_file($tmpname, "../uploads/kegiatan/" . $rename)) {
                    $gambar_filenames[] = $rename;
                } else {
                    echo '<div class="alert alert-danger">Upload gambar ' . $i . ' gagal.</div>';
                    $gagal_upload = true;
                    break;
                }
            }
        } else {
            $gambar_filenames[] = null;
        }
    }

    if (!$gagal_upload) {
        $simpan = mysqli_query($koneksi, "INSERT INTO kegiatan_jurusan (nama, gambar1, gambar2, gambar3, gambar4, gambar5, gambar6) 
                                  VALUES ('$nama', '$gambar_filenames[0]', '$gambar_filenames[1]', '$gambar_filenames[2]', '$gambar_filenames[3]', '$gambar_filenames[4]', '$gambar_filenames[5]')");

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
                            window.location.href = 'kegiatan-belajar.php';
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
                    });
                </script>";
        }
    }
}
?>


<script>
    function previewImage(event, index) {
        const reader = new FileReader();
        reader.onload = function() {
            const preview = document.getElementById(`preview${index}`);
            preview.src = reader.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>