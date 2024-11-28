<?php

require_once "./tamplate/header.php";
require_once "./tamplate/navbar.php";
require_once "./tamplate/sidebar.php";
?>

<!-- content -->
<div class="card-body">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Data Pelajaran</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item mx-1"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active mx-1">Data Pelajaran</li>
                </ol>

                <div class="card">
                    <div class="card-header">
                        <span class="h5 my-5"><i class="fa-solid fa-list"> Data Ujian</i></span>
                        <a href="nilai-ujian.php" class="btn btn-sm btn-primary float-end"><i class="fa-solid fa-plus"></i> Tambah Ujian</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <center>No Ujian</center>
                                    </th>
                                    <th scope="col">
                                        <center>NIS</center>
                                    </th>
                                    <th scope="col">
                                        <center>Nama Siswa</center>
                                    </th>
                                    <th scope="col">
                                        <center>Jurusan</center>
                                    </th>
                                    <th scope="col">
                                        <center>Nilai Terendah</center>
                                    </th>
                                    <th scope="col">
                                        <center>Nilai Tertinggi</center>
                                    </th>
                                    <th scope="col">
                                        <center>Nilai Rata-rata</center>
                                    </th>
                                    <th scope="col">
                                        <center>Hasil Ujian</center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php
                                // Koneksi ke database
                                $koneksi = new mysqli("localhost", "root", "", "db_sekolah");

                                // Cek koneksi
                                if ($koneksi->connect_error) {
                                    die("Connection failed: " . $koneksi->connect_error);
                                }

                                // Definisikan query untuk mengambil data ujian
                                $query = "
                                SELECT u.no_ujian, 
                                       u.nis, 
                                       s.nama, 
                                       u.jurusan, 
                                       u.nilai_terendah, 
                                       u.nilai_tertinggi, 
                                       u.nilai_rata2, 
                                       u.hasil_ujian 
                                FROM tbl_ujian u 
                                JOIN tbl_siswa s ON u.nis = s.nis
                                ";

                                // Eksekusi query
                                $result = $koneksi->query($query);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td><center>{$row['no_ujian']}</center></td>
                                                <td><center>{$row['nis']}</center></td>
                                                <td><center>{$row['nama']}</center></td>
                                                <td><center>{$row['jurusan']}</center></td>
                                                <td><center>{$row['nilai_terendah']}</center></td>
                                                <td><center>{$row['nilai_tertinggi']}</center></td>
                                                <td><center>{$row['nilai_rata2']}</center></td>
                                                <td><center>{$row['hasil_ujian']}</center></td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>Tidak ada data ujian.</td></tr>";
                                }

                                // Tutup koneksi
                                $koneksi->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <?php
        require_once "./tamplate/footer.php";
        ?>
    </div>
</div>  