<?php
require_once "koneksi.php";
require_once "./tamplate/header.php";
require_once "./tamplate/navbar.php";
require_once "./tamplate/sidebar.php";
?>

<!-- content -->
<div class="card-body">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Guru</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-items active mx-1">/ Tambah Guru</li>
                </ol>



                <!-- Form Pencarian -->
                <form method="GET" action="data-guru.php" class="mb-3 w-50">
                    <div class="input-group">
                        <input type="text" name="key" class="form-control" placeholder="Cari berdasarkan NIP, Nama, atau Telpon" value="<?php echo isset($_GET['key']) ? htmlspecialchars($_GET['key']) : ''; ?>">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>

                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-5"><i class="fa-solid fa-list"> Data Siswa</i></span>
                        <a href="tambah-guru.php" class="btn btn-sm btn-primary float-end"><i class="fa-solid fa-plus"></i> Tambah Guru</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <center>No</center>
                                    </th>
                                    <th scope="col">
                                        <center>Nip</center>
                                    </th>
                                    <th scope="col">
                                        <center>Nama</center>
                                    </th>
                                    <th scope="col">
                                        <center>Alamat</center>
                                    </th>
                                    <th scope="col">
                                        <center>Telpon</center>
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
                                    $searchKey = addslashes($_GET['key']);
                                    $where .= " AND (nama LIKE '%$searchKey%' OR nip LIKE '%$searchKey%' OR alamat LIKE '%$searchKey%' OR telpon LIKE '%$searchKey%') ";
                                }

                                // Mengurutkan berdasarkan NIP secara DESC
                                $guru = mysqli_query($koneksi, "SELECT * FROM tbl_guru $where ORDER BY nip DESC");
                                if (mysqli_num_rows($guru) > 0) {
                                    while ($p = mysqli_fetch_array($guru)) {
                                ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $p['nip'] ?></td>
                                            <td><?= $p['nama'] ?></td>
                                            <td><?= $p['alamat'] ?></td>
                                            <td><?= $p['telpon'] ?></td>
                                            <td align="center">
                                                <a href="edit-guru.php?nip=<?= $p['nip'] ?>" title="Edit Data" class="btn btn-sm btn-warning">
                                                    <i class='fa-solid fa-pen'></i>
                                                </a>
                                                <button onclick="confirmDelete('<?= $p['nip'] ?>')" title="Hapus Data" class="btn btn-sm btn-danger">
                                                    <i class='fa-solid fa-trash'></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Data tidak ada</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php require_once "tamplate/footer.php"; ?>
            </div>
        </main>
    </div>

</div>

<script>
    function confirmDelete(nip) {
        Swal.fire({
            title: 'Yakin ingin hapus?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `hapus.php?nip=${nip}&confirm=true`;
            }
        });
    }
</script>
<?php
require_once "koneksi.php";

// Lakukan penghapusan data
if (isset($_GET['nip'])) {
    $nip = $_GET['nip'];
    $query = "DELETE FROM tbl_guru WHERE nip = '$nip'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
                window.onload = function() {
                    const notyf = new Notyf();
                    notyf.success('Data berhasil dihapus');
                };
                window.location.href = 'data-guru.php';
              </script>";
    } else {
        echo "<script>
                const notyf = new Notyf();
                notyf.error('Terjadi kesalahan saat menghapus data');
              </script>";
    }
}
?>