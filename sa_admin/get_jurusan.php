<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_sekolah");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_POST['nis'])) {
    $nis = $_POST['nis'];

    // Menggunakan prepared statement
    $stmt = $koneksi->prepare("SELECT jurusan FROM tbl_siswa WHERE nis = ?");
    $stmt->bind_param("s", $nis); // Mengikat parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo $data['jurusan'];
    } else {
        echo '';
    }

    // Menutup statement
    $stmt->close();
}

// Menutup koneksi
$koneksi->close();
