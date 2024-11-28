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
            <h1 class="mt-4">Post fasilitas</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items active mx-1">/ Tambah Fasilitas</li>
            </ol>

            <!-- Form Pencarian -->
            <div class="col-md-4 mb-3">
                <form method="GET" action="">
                    <div class="px-10 input-group mb-3">
                        <input type="text" name="key" class="form-control" placeholder="Cari berdasarkan jurusan dan keterangan" value="<?= isset($_GET['key']) ? htmlspecialchars($_GET['key']) : '' ?>">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <span class="h5 my-5"><i class="fa-solid fa-list"> Data Fasilitas</i></span>
                    <a href="tambah-jurusan.php" class="btn btn-sm btn-primary float-end"><i class="fa-solid fa-plus"></i> Tambah Jurusan</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <center>No</center>
                                </th>
                                <th scope="col">
                                    <center>Judul</center>
                                </th>
                                <th scope="col">
                                    <center>Keterangan</center>
                                </th>
                                <th scope="col">
                                    <center>Deskripsi</center>
                                </th>
                                <th scope="col">
                                    <center>Gambar</center>
                                </th>
                                <th scope="col">
                                    <center>kegiatan</center>
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
                            if (isset($_GET['key']) && $_GET['key'] != '') {
                                $key = addslashes($_GET['key']);
                                $where .= " AND (nama LIKE '%$key%' OR keterangan LIKE '%$key%') ";
                            }

                            // Perform the query
                            $jurusan_query = mysqli_query($koneksi, "SELECT * FROM fasilitas $where ORDER BY id DESC");

                            // Check if there are results
                            if (mysqli_num_rows($jurusan_query) > 0) {
                                // Loop through the results
                                while ($p = mysqli_fetch_object($jurusan_query)) {
                            ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $p->judul ?></td>
                                        <td><?= $p->keterangan ?></td>
                                        <td><?= $p->deskripsi ?></td>
                                        <td><img src="../uploads/fasilitas/<?= htmlspecialchars($p->gambar) ?>" width="100px"></td>

                                        <td class="text-center">
                                            <a href="edit-fasilitas.php?id=<?= $p->idfasilitas ?>" title="Edit Data" class="btn btn-sm btn-warning">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="hapus.php?idjurusan=<?= $p->id ?>" onclick="return confirm('Yakin ingin hapus?')" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                // If no results
                                ?>
                                <tr>
                                    <td colspan="7" class="text-center">Data tidak ada</td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
                <?php require_once "tamplate/footer.php"; ?>
            </div>
        </div>
    </main>
</div>
</div>