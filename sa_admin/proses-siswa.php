<?php
require_once "koneksi.php";

if (isset($_POST['simpan'])) {
  // Ambil data dari form
  $nis = htmlspecialchars($_POST['nis']); // Mengambil NIS dari input
  $nama = htmlspecialchars($_POST['nama']);
  $kelas = $_POST['kelas'];
  $jurusan = $_POST['jurusan'];
  $alamat = htmlspecialchars($_POST['alamat']);

  // Query untuk menyimpan data
  $query = "INSERT INTO tbl_siswa (nis, nama, alamat, kelas, jurusan) VALUES ('$nis', '$nama', '$alamat', '$kelas', '$jurusan')";

  if (mysqli_query($koneksi, $query)) {
    echo "<script>
                const notyf = new Notyf();
                notyf.success('Data Siswa berhasil disimpan!');
                setTimeout(function() {
                    window.location.href = 'add-siswa.php';
                }, 3000); // Redirect after 3 seconds
              </script>";
  } else {
    echo "<script>
                const notyf = new Notyf();
                notyf.error('Data Siswa gagal disimpan: " . mysqli_error($koneksi) . "');
              </script>";
  }
}
?>
<link href="https://cdn.jsdelivr.net/npm/notyf@3.6.0/notyf.min.css" rel="stylesheet">
<!-- Link to Notyf JS -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3.6.0/notyf.min.js"></script>