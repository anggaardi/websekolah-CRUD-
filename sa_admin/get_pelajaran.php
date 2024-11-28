<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "db_sekolah");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_POST['jurusan'])) {
    $jurusan = $_POST['jurusan'];

    // Menggunakan prepared statement
    $stmt = $koneksi->prepare("SELECT * FROM tbl_pelajaran WHERE jurusan = ? OR jurusan = 'Umum'");
    $stmt->bind_param("s", $jurusan); // Mengikat parameter
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Menutup statement
    $stmt->close();

    // Mengembalikan data dalam format JSON
    echo json_encode($data);
} else {
    // Jika 'jurusan' tidak diset, kembalikan array kosong
    echo json_encode([]);
}

// Menutup koneksi
$koneksi->close();
