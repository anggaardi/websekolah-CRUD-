<?php
require_once "koneksi.php";
require_once "./tamplate/header.php";
require_once "./tamplate/navbar.php";
require_once "./tamplate/sidebar.php";

// Ambil ID dari URL
$id = $_GET['id'];

// Query untuk mengambil data staff berdasarkan ID
$staff = mysqli_query($koneksi, "SELECT * FROM staff WHERE id = '$id'");

// Jika data tidak ditemukan, redirect ke halaman staff
if (mysqli_num_rows($staff) == 0) {
    echo "<script>window.location='staff.php'</script>";
    exit;
}

// Fetch data staff
$p = mysqli_fetch_object($staff);

// Proses update data
if (isset($_POST['submit'])) {
    $nama = addslashes(ucwords($_POST['nama']));
    $deskripsi = addslashes($_POST['deskripsi']);
    $currdate = date('Y-m-d H:i:s');

    // Proses upload gambar baru (jika ada)
    if ($_FILES['foto']['name'] != '') {
        $filename = $_FILES['foto']['name'];
        $tmpname = $_FILES['foto']['tmp_name'];
        $filesize = $_FILES['foto']['size'];

        $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
        $rename = 'staff' . time() . '.' . $formatfile;

        $allowedtype = array('png', 'jpg', 'jpeg', 'gif');

        if (!in_array($formatfile, $allowedtype)) {
            echo '<div class="alert bg-red-100 text-red-800 p-3 rounded mb-4">Format file tidak diizinkan.</div>';
        } elseif ($filesize > 1000000) {
            echo '<div class="alert bg-red-100 text-red-800 p-3 rounded mb-4">Ukuran file tidak boleh lebih dari 1 MB.</div>';
        } else {
            // Hapus gambar lama jika ada
            if (file_exists("../uploads/staff/" . $_POST['foto2'])) {
                unlink("../uploads/staff/" . $_POST['foto2']);
            }

            if (move_uploaded_file($tmpname, "../uploads/staff/" . $rename)) {
                // Gambar berhasil di-upload
            } else {
                echo '<div class="alert bg-red-100 text-red-800 p-3 rounded mb-4">Gagal meng-upload gambar.</div>';
            }
        }
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $rename = $_POST['foto2'];
    }

    // Update data staff di database
    $update = mysqli_query($koneksi, "UPDATE staff SET
                                    nama = '$nama',
                                    deskripsi = '$deskripsi',
                                    foto = '$rename',
                                    updated_at = '$currdate'
                                    WHERE id = '$id'");

    if ($update) {
        echo "<script>window.location='staff.php?success=Edit Data Berhasil'</script>";
    } else {
        echo 'Gagal edit: ' . mysqli_error($koneksi);
    }
}
?>

<!-- content -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Staff</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items mx-1"><a href="informasi.php">/ Staff </a></li>
                <li class="breadcrumb-items active">/ Edit Staff</li>
            </ol>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-square-pen"></i> Edit Staff</span>
                        <span>
                            <button type="submit" name="submit" class="btn btn-primary float-end">
                                <i class="fa-solid fa-pen-nib me-1"></i> Update
                            </button>
                            <a href="staff.php" class="btn btn-danger float-end mx-1"><i class="fa-solid fa-xmark"></i> Batal</a>
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="col-12">

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Nama</label>
                                <label for="nama" class="col-sm-1 col-form-label">:</label>
                                <div class="col-sm-9" style="margin-left:-50px">
                                    <input type="text" name="nama" placeholder="Nama" value="<?= htmlspecialchars($p->nama) ?>" class="form-control w-full p-2 border-0 border-bottom ps-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Deskripsi</label>
                                <label for="deskripsi" class="col-sm-1 col-form-label">:</label>
                                <div class="col-sm-9" style="margin-left: -50px">
                                    <textarea name="deskripsi" class="form-control" id="deskripsi" rows="6" required><?= htmlspecialchars($p->deskripsi) ?></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Foto</label>
                                <label for="foto" class="col-sm-1 col-form-label">:</label>
                                <div class="col-sm-9" style="margin-left: -50px">
                                    <img src="../uploads/staff/<?= htmlspecialchars($p->foto) ?>" width="200px" class="mb-4 rounded-md">
                                    <input type="hidden" name="foto2" value="<?= htmlspecialchars($p->foto) ?>">
                                    <input type="file" name="foto" class="input-control w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php
        require_once "./tamplate/footer.php";
        ?>
    </main>
</div>