	<?php include 'header.php'; ?>


	<?php
    session_start(); // Memulai session

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

    // Ambil bahasa dari query parameter, jika tidak ada, gunakan 'id' sebagai default
    $language = isset($_GET['language']) ? $_GET['language'] : 'id';
    ?>

	<!DOCTYPE html>
	<html lang="id">

	<head>
	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title>Multi Language Page</title>
	    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
	    <script>
	        function changeLanguage(lang) {
	            // Mengubah URL dengan parameter query
	            window.location.href = "?language=" + lang;
	        }
	    </script>
	</head>

	<body class="">
	    <div class="container mx-auto p-4">
	        <h1 class="text-3xl font-bold mb-4"><?php echo get_translation('welcome_message', $language); ?></h1>
	        <p class="mb-2"><?php echo get_translation('goodbye_message', $language); ?></p>
	        <p class="mb-2"><?php echo get_translation('aku ada disini', $language); ?></p>


	        <div class="w-full bg-white p-6 rounded shadow">
	            <h2 class="text-2xl font-semibold mb-4"><?php echo get_translation('Why Should SMK Negeri 1 Sukawati?', $language); ?></h2>
	            <!-- Konten lainnya di sini -->
	        </div>
	    </div>
	</body>

	</html>