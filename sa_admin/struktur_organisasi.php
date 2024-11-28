<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";

// Mengambil data siswa dari database
$query = "SELECT * FROM struktur_organisasi";
$result = mysqli_query($koneksi, $query);

?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Post Struktur</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items active mx-1">/ Tambah struktur</li>
            </ol>
            <div class="card">
                <div class="card-header">
                    <span class="h5 my-5"><i class="fa-solid fa-list">Data Struktur </i></span>
                    <a href="tambah-struktur.php" class="btn btn-sm btn-primary float-end"><i class="fa-solid fa-plus"></i>Tambah Struktur</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <center>No</center>
                                </th>
                                <th scope="col">
                                    <center>Foto</center>
                                </th>

                                <th scope="col">
                                    <center>Nama</center>
                                </th>
                                <th scope="col">
                                    <center>jabatan</center>
                                </th>
                                <th scope="col">
                                    <center>Aksi</center>
                                </th>

                            </tr>
                        </thead>


                        <?php
                        $no = 1;

                        $where = " WHERE 1=1 ";
                        if (isset($_GET['key'])) {
                            $where .= " AND nama LIKE '%" . addslashes($_GET['key']) . "%' ";
                        }

                        $struktur = mysqli_query($koneksi, "SELECT * FROM struktur_organisasi $where ORDER BY id DESC");
                        if (mysqli_num_rows($struktur) > 0) {
                            while ($p = mysqli_fetch_array($struktur)) {
                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <img src="../uploads/struktur_organisasi/<?= $p['foto'] ?>" class="img-thumbnail" width="100">
                                    </td>
                                    <td><?= htmlspecialchars($p['nama']) ?></td>
                                    <td><?= htmlspecialchars($p['deskripsi']) ?></td>
                                    <td class="text-center">
                                        <a href="edit-struktur.php?idstruktur=<?= $datapelajaran['id'] ?>" title="Edit Data" class="btn btn-sm btn-warning">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a href="hapus.php?idstruktur=<?= $datastruktur['id'] ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="5" class="text-center">Data tidak ada</td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

</div>

</div>