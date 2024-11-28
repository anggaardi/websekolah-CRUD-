
<?php

function get_translation($key, $language)
{
  // Buat koneksi ke database
  $conn = mysqli_connect('localhost', 'root', '', 'db_sekolah') or die('Gagal terhubung ke database');

  // Query untuk mendapatkan terjemahan
  $stmt = $conn->prepare("SELECT translation FROM translations WHERE translation_key = ? AND language = ?");
  $stmt->bind_param("ss", $key, $language);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
    return $row['translation'];
  } else {
    return $key; // Jika tidak ada terjemahan, kembalikan key-nya
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $language = $_POST['language'] ?? 'id'; // Bahasa default
  $key = 'welcome_message'; // Key yang ingin diambil terjemahannya

  $translation = get_translation($key, $language);

  echo json_encode(['translation' => $translation]);
}
