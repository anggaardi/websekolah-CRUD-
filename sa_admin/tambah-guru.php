<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Guru</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items mx-1"><a href="guru.php">/ Guru </a></li>
                <li class="breadcrumb-items active">/ Tambah Guru</li>
            </ol>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-square-plus"></i> Tambah Guru</span>
                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary float-end">
                        <button type="reset" name="reset" class="btn btn-danger float-end mx-1"><i class="fa-solid fa-xmark"></i> Reset</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10">
                                <div class="mb-3 row">
                                    <label for="nip" class="col-sm-2 col-form-label">Nip</label>
                                    <label for="nip" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="text" name="nip" id="nip" placeholder="Masukan nip" class="form-control border-0 border-bottom ps-2" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama Guru</label>
                                    <label for="nama" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama" id="nama" placeholder="Masukan nama Guru" class="form-control border-0 border-bottom ps-2" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                    <label for="alamat" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="text" name="alamat" id="alamat" placeholder="Masukan alamat" class="form-control border-0 border-bottom ps-2" required>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="telpon" class="col-sm-2 col-form-label">Telpon</label>
                                    <label for="telpon" class="col-sm-1 col-form-label">:</label>
                                    <div class="col-9">
                                        <input type="tel" name="telpon" id="telpon" placeholder="Masukan No telpon" class="form-control border-0 border-bottom ps-2" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $nip = $_POST['nip'];
                $nama = $_POST['nama'];
                $alamat = $_POST['alamat'];
                $telpon = $_POST['telpon'];

                if ($nip == '' || $nama == '' || $alamat == '' || $telpon == '') {
                    echo "<div class='alert bg-red-100 text-red-800 p-3 rounded mb-4'>Semua field harus diisi!</div>";
                } else {
                    $insert = mysqli_query($koneksi, "INSERT INTO tbl_guru (nip, nama, alamat, telpon) 
                        VALUES ('$nip', '$nama', '$alamat', '$telpon')");

                    if ($insert) {
                        echo "<script>
                        window.onload = function() {
                            const notyf = new Notyf();
                            notyf.success('Data berhasil ditambahkan!');
                            setTimeout(() => {
                                window.location = 'tambah-guru.php';
                            }, 2000);
                        };
                    </script>";
                    } else {
                        echo "<script>
                        window.onload = function() {
                            const notyf = new Notyf();
                            notyf.error('Gagal menambahkan data!');
                        };
                    </script>";
                    }
                }
            }
            ?>