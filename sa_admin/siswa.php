<?php
require_once "koneksi.php";
require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";

// Mengecek apakah ada input pencarian
$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_POST['search']);
}

// Mengambil data siswa dari database berdasarkan pencarian
$query = "SELECT * FROM tbl_siswa WHERE nis LIKE '%$search%' OR nama LIKE '%$search%' OR jurusan LIKE '%$search%'";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Error: " . mysqli_error($koneksi));
}

// Jika ada id siswa yang ingin dihapus
if (isset($_GET['id'])) {
    $nis = mysqli_real_escape_string($koneksi, $_GET['id']);
    $deleteQuery = "DELETE FROM tbl_siswa WHERE nis = '$nis'";
    $deleteResult = mysqli_query($koneksi, $deleteQuery);

    // Menambahkan notifikasi menggunakan Notyf setelah penghapusan
    if ($deleteResult) {
        echo "<script>
                const notyf = new Notyf();
                notyf.success('Data siswa berhasil dihapus!');
                setTimeout(function() {
                    window.location = 'siswa.php';
                }, 1000); 
              </script>";
    } else {
        echo "<script>
                const notyf = new Notyf();
                notyf.error('Gagal menghapus data siswa!');
                setTimeout(function() {
                    window.location = 'siswa.php';
                }, 1000); 
              </script>";
    }
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Siswa</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-items mx-1"><a href="index.php">Home</a></li>
                <li class="breadcrumb-items active mx-1">/ Data Siswa</li>
            </ol>

            <!-- Form Pencarian -->
            <form method="POST" action="siswa.php" class="mb-3">
                <div class="input-group w-50"> <!-- Form lebar 50% -->
                    <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan NIS, Nama, atau Jurusan" value="<?php echo $search; ?>">
                    <button class="btn btn-primary" type="submit" name="search_button">Cari</button>
                </div>
            </form>


            <div class="card">
                <div class="card-header">
                    <span class="h5 my-5"><i class="fa-solid fa-list">Data Siswa</i></span>

                    <a href="add-siswa.php" class="btn btn-sm btn-primary float-end"><i class="fa-solid fa-plus"></i> Tambah Siswa</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <center>No</center>
                                </th>
                                <th scope="col">
                                    <center>NIS</center>
                                </th>
                                <th scope="col">
                                    <center>Nama</center>
                                </th>
                                <th scope="col">
                                    <center>Kelas</center>
                                </th>
                                <th scope="col">
                                    <center>Jurusan</center>
                                </th>
                                <th scope="col">
                                    <center>Alamat</center>
                                </th>
                                <th scope="col">
                                    <center>Aksi</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<th scope='row'>{$no}</th>";
                                echo "<td>{$row['nis']}</td>";
                                echo "<td>{$row['nama']}</td>";
                                echo "<td>{$row['kelas']}</td>";
                                echo "<td>{$row['jurusan']}</td>";
                                echo "<td>{$row['alamat']}</td>";

                                echo "<td align='center'>
                                <a href='edit-siswa.php?nis={$row['nis']}' class='btn btn-sm btn-warning' title='Edit Siswa'>
                                  <i class='fa-solid fa-pen'></i>
                                </a>
                                <a href='#' class='btn btn-sm btn-danger' title='Hapus Siswa' onclick='confirmDelete(\"{$row['nis']}\", \"{$row['nama']}\")'>
                                  <i class='fa-solid fa-trash'></i>
                                </a>
                                      </td>";
                                echo "</tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php require_once "tamplate/footer.php"; ?>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(nis, nama) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Data siswa ${nama} akan dihapus!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `siswa.php?id=${nis}`;
            }
        });
    }
</script>