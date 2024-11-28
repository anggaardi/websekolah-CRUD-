<?php
require_once "koneksi.php";

if (isset($_POST['simpan'])) {
    $noUjian = $_POST['noUjian'];
    $tglUjian = $_POST['tgl_ujian'];
    $nis = $_POST['nis'];
    $jurusan = $_POST['jurusan'];
    $totalNilai = $_POST['sum'];
    $nilaiTerendah = $_POST['min'];
    $nilaiTertinggi = $_POST['max'];
    $rataRata = $_POST['avg'];
    $status = $_POST['status'];

    // Query untuk menyimpan data ke tabel `tbl_nilai_ujian`
    $query = "INSERT INTO tbl_nilai_ujian (no_ujian, tgl_ujian, nis, jurusan, total_nilai, nilai_terendah, nilai_tertinggi, rata_rata, status)
              VALUES ('$noUjian', '$tglUjian', '$nis', '$jurusan', '$totalNilai', '$nilaiTerendah', '$nilaiTertinggi', '$rataRata', '$status')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: nilai_ujian.php?msg=LULUS&nis=$nis");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }

    // Tutup koneksi
    mysqli_close($koneksi);
}
