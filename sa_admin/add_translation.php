<?php

require_once "tamplate/header.php";
require_once "tamplate/navbar.php";
require_once "tamplate/sidebar.php";
?>
<?php
// Buat koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'db_sekolah') or die('Gagal terhubung ke database');

// Periksa apakah formulir telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir
    $translation_key = $_POST['translation_key'];
    $language = $_POST['language'];
    $translation = $_POST['translation'];

    // Query untuk menyimpan data ke database
    $stmt = $koneksi->prepare("INSERT INTO translations (translation_key, language, translation) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $translation_key, $language, $translation);

    // Eksekusi dan periksa hasilnyya
    if ($stmt->execute()) {
        echo "<div class='text-green-600'>Data berhasil ditambahkan!</div>";
    } else {
        echo "<div class='text-red-600'>Error: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Terjemahan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div id="layoutSidenav_content">
        <div class="container mx-auto p-6">
            <h1 class="text-2xl font-bold mb-4">Form Tambah Terjemahan</h1>
            <form method="POST" action="" class="bg-white p-6 rounded-lg shadow-md">
                <div class="mb-4">
                    <label for="translation_key" class="block text-sm font-medium text-gray-700">Bahasa yang ingin di terjemahkan:</label>
                    <input type="text" id="translation_key" name="translation_key" required
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="language" class="block text-sm font-medium text-gray-700">translate ke bahasa apa:</label>
                    <input type="text" id="language" name="language" required placeholder="id/en"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="translation" class="block text-sm font-medium text-gray-700">Hasil penerjemahan:</label>
                    <textarea id="translation" name="translation" required
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600">
                    Tambah Terjemahan
                </button>
            </form>
        </div>
    </div>
</body>

</html>