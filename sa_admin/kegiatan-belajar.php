<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";


?>
<!-- content -->

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Post Kegiatan Belajar</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items active mx-1">/ Tambah Kegiatan Belajar</li>
            </ol>

            <!-- Form Pencarian -->


            <div class="card">
                <div class="card-header">
                    <span class="h5 my-5"><i class="fa-solid fa-list"> Data Siswa</i></span>
                    <a href="tambah-kegiatan.php" class="btn btn-sm btn-primary float-end"><i class="fa-solid fa-plus"></i> Tambah Kegiatan</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <center>No</center>
                                </th>
                                <th scope="col">
                                    <center>Nama_jurusan</center>
                                </th>
                                <th scope="col">
                                    <center>Gambar/1</center>
                                </th>
                                <th scope="col">
                                    <center>Gambar/2</center>
                                </th>
                                <th scope="col">
                                    <center>Gambar/3</center>
                                </th>
                                <th scope="col">
                                    <center>Gambar/4</center>
                                </th>
                                <th scope="col">
                                    <center>Gambar/5</center>
                                </th>
                                <th scope="col">
                                    <center>Gambar/6</center>
                                </th>
                                <th scope="col">
                                    <center>Aksi</center>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 1;

                            $where = " WHERE 1=1 ";
                            if (isset($_GET['key'])) {
                                $where .= " AND nama LIKE '%" . addslashes($_GET['key']) . "%' ";
                            }

                            $jurusan = mysqli_query($koneksi, "SELECT * FROM kegiatan_jurusan $where ORDER BY id DESC");
                            if (mysqli_num_rows($jurusan) > 0) {
                                while ($p = mysqli_fetch_array($jurusan)) {
                            ?>

                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $p['nama'] ?></td>


                                        <td><img src="../uploads/kegiatan/<?= $p['gambar1'] ?>" width="100px"></td>
                                        <td><img src="../uploads/kegiatan/<?= $p['gambar2'] ?>" width="100px"></td>
                                        <td><img src="../uploads/kegiatan/<?= $p['gambar3'] ?>" width="100px"></td>
                                        <td><img src="../uploads/kegiatan/<?= $p['gambar4'] ?>" width="100px"></td>
                                        <td><img src="../uploads/kegiatan/<?= $p['gambar5'] ?>" width="100px"></td>
                                        <td><img src="../uploads/kegiatan/<?= $p['gambar6'] ?>" width="100px"></td>


                                        <td class="text-center">
                                            <a href="edit_kegiatan.php?id=<?= $p['id'] ?>" title="Edit Data" class="btn btn-sm btn-warning">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="hapus.php?idkegiatan=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="konfirmasiHapus(event, 'hapus.php?idkegiatan=<?= $p['id'] ?>')">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>

                                            <script>
                                                function konfirmasiHapus(event, url) {
                                                    event.preventDefault(); // Menghentikan aksi default

                                                    Swal.fire({
                                                        title: 'Yakin ingin hapus?',
                                                        text: "Data yang dihapus tidak dapat dikembalikan!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#d33',
                                                        cancelButtonColor: '#3085d6',
                                                        confirmButtonText: 'Ya, hapus!',
                                                        cancelButtonText: 'Batal'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href = url; // Melanjutkan ke URL penghapusan jika dikonfirmasi
                                                        }
                                                    });
                                                }
                                            </script>
                                        </td>
                                    </tr>

                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan="5">Data tidak ada</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>

            </div>

        </div>

</div>