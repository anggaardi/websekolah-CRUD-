    <?php
    require_once "koneksi.php";
    require_once "tamplate/header.php";
    require_once "tamplate/navbar.php";
    require_once "tamplate/sidebar.php";

    if (isset($_GET['msg']) && isset($_GET['nis'])) {
        $msg = $_GET['msg'];
        $nis =  $_GET['nis'];
    } else {
        $msg = "";
        $nis = "";
    }
    $alert = '';
    if ($msg == 'LULUS ') {
        $alert = '<div class=""alert alert-success alert-dismissible fade show role="alert"><i class="fa-solid fa-circle-check"></i>SELAMAT SISWA dengan nis: ' . $nis . ' BERHASIL LULUS UJIAN
        <button type="button" class="btn-close" data-bs-dismis="alert" aria-label="Close"></button>
        </div>';
    }
    if ($msg == 'GAGAL ') {
        $alert = '<div class=""alert alert-danger alert-dismissible fade show role="alert"><i class="fa-solid fa-circle-xmark"></i>  SISWA dengan nis: ' . $nis . ' GAGAL UJIAN
        <button type="button" class="btn-close" data-bs-dismis="alert" aria-label="Close"></button>
        </div>';
    }
    // Koneksi ke database
    $koneksi = new mysqli("localhost", "root", "", "db_sekolah");

    // Cek koneksi
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    // Query untuk mendapatkan nomor ujian terakhir
    $querynoUjian = mysqli_query($koneksi, "SELECT max(no_ujian) as maxno FROM tbl_ujian");
    if (!$querynoUjian) {
        die("Query Error: " . mysqli_error($koneksi));
    }

    $data = mysqli_fetch_array($querynoUjian);
    $maxno = $data['maxno'] ?? 'UTS-000'; // Menggunakan 'UTS-000' jika tidak ada data

    $noUrut = (int) substr($maxno, 4, 3);
    $noUrut++;
    $maxno = "UTS-" . sprintf("%03s", $noUrut);
    ?>

    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nilai</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    </head>

    <body>

        <!-- content -->
        <div class="card-body">
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-7">
                                <h1 class="mt-4">Nilai Ujian</h1>
                                <ol class="breadcrumb mb-4">
                                    <li class="breadcrumb-item mx-1"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item mx-1"><a href="ujian.php">Ujian</a></li>
                                    <li class="breadcrumb-item active mx-1">Nilai Ujian</li>
                                </ol>
                            </div>
                            <div class="col-5">
                                <div class="card mt-3 border-0">
                                    <h5>Syarat Kelulusan</h5>
                                    <ul class="float-end ps-3">
                                        <li><small>Nilai minimal tiap pelajaran tidak boleh di bawah 50</small></li>
                                        <li><small>Nilai rata-rata mata pelajaran tidak boleh di bawah 60</small></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <form id="proses-ujian.php" method="POST">
                                    <div class="card">
                                        <div class="card-header">Data Peserta Ujian</div>
                                        <div class="card-body">
                                            <div class="input-group mb-2">
                                                <span class="input-group-text">No Ujian</span>
                                                <input type="text" name="noUjian" value="<?= $maxno ?>" class="form-control" readonly>
                                            </div>
                                            <div class="input-group mb-2">
                                                <span class="input-group-text"><i class="fa-solid fa-calendar fa-sm"></i></span>
                                                <input type="date" name="tgl_ujian" class="form-control" id="tgl_ujian" required>
                                            </div>
                                            <div class="input-group mb-2">
                                                <span class="input-group-text">Siswa</span>
                                                <select name="nis" id="nis" class="form-select" onchange="fetchJurusan()">
                                                    <option value="">--Pilih Siswa--</option>
                                                    <?php
                                                    $querysiswa = mysqli_query($koneksi, "SELECT * FROM tbl_siswa");
                                                    while ($data = mysqli_fetch_array($querysiswa)) {
                                                        echo "<option value='{$data['nis']}'>{$data['nis']} - {$data['nama']}</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="input-group mb-2">
                                                <span class="input-group-text">Jurusan</span>
                                                <input type="text" name="jurusan" id="jurusan" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body border mx- mt-2 rounded">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text col-2 ps-2 fw-bold">Sum</span>
                                            <input type="text" name="sum" class="form-control" placeholder="Total Nilai" id="total_nilai" required readonly>
                                        </div>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text col-2 ps-2 fw-bold">Min</span>
                                            <input type="text" name="min" class="form-control" placeholder="Nilai terendah" id="nilai_terendah" required readonly>
                                        </div>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text col-2 ps-2 fw-bold">Max</span>
                                            <input type="text" name="max" class="form-control" placeholder="Nilai Tertinggi" id="nilai_tertinggi" required readonly>
                                        </div>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text col-2 ps-2 fw-bold">Avg</span>
                                            <input type="text" name="avg" class="form-control" placeholder="Nilai Rata-rata" id="rata2" required readonly>
                                        </div>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text col-2 ps-2 fw-bold">Status</span>
                                            <input type="text" name="status" class="form-control" id="status" required readonly>
                                        </div>

                                    </div>

                            </div>

                            <div class="col-8">
                                <div class="card">
                                    <div class="card-header">
                                        <button type="submit" name="simpan" class="btn btn-primary float-end">Simpan</button>
                                        <span class="h5 my-2"><i class="fa-solid fa-list"></i> Input Nilai Ujian</span>
                                        <button type="reset" name="reset" class="btn btn-danger float-end mx-1" onclick="resetFields()"><i class="fa-solid fa-xmark"></i> Reset</button>
                                    </div>
                                    </form> <!-- Form ditutup di sini -->

                                    <div class="card-body">
                                        <div class="table-responsive table-hover table-bordered">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-center">No</th>
                                                        <th scope="col" class="text-center">Mata Pelajaran</th>
                                                        <th scope="col" class="text-center">Jurusan</th>
                                                        <th scope="col" class="text-center" style="width: 20%;">Nilai Ujian</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="kejuruan">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <?php
            require_once "tamplate/footer.php";
            ?>
        </div>

        <script>
            function fetchJurusan() {
                var nis = document.getElementById("nis").value;
                if (nis) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "get_jurusan.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var jurusan = xhr.responseText;
                            document.getElementById("jurusan").value = jurusan;
                            fetchPelajaran(jurusan);
                        }
                    };
                    xhr.send("nis=" + nis);
                } else {
                    document.getElementById("jurusan").value = "";
                    document.getElementById("kejuruan").innerHTML = "";
                }
            }

            function fetchPelajaran(jurusan) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "get_pelajaran.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var pelajaranData = JSON.parse(xhr.responseText);
                        var tableBody = document.getElementById("kejuruan");
                        tableBody.innerHTML = ""; // Clear previous data
                        var total = 0,
                            min = 100,
                            max = 0;
                        pelajaranData.forEach(function(pelajaran, index) {
                            tableBody.innerHTML += `
                                <tr>
                                    <td class="text-center">${index + 1}</td>
                                    <td class="text-center">${pelajaran.pelajaran}</td>
                                    <td class="text-center">${jurusan}</td>
                                    <td class="text-center">
                                        <input type="number" class="form-control" name="nilai[]" id="nilai_${index}" placeholder="Nilai" oninput="calculateResults()" min="0" max="100">
                                    </td>
                                </tr>`;
                        });
                    }
                };
                xhr.send("jurusan=" + jurusan);
            }

            function calculateResults() {
                var total = 0,
                    min = 100,
                    max = 0,
                    count = 0;
                var inputs = document.querySelectorAll('input[name="nilai[]"]');
                inputs.forEach(function(input) {
                    var value = parseInt(input.value) || 0;
                    total += value;
                    if (value < min) min = value;
                    if (value > max) max = value;
                    if (value > 0) count++;
                });
                var avg = count > 0 ? (total / count).toFixed(2) : 0;

                document.getElementById("total_nilai").value = total;
                document.getElementById("nilai_terendah").value = (min === 100) ? '' : min; // Display empty if still 100
                document.getElementById("nilai_tertinggi").value = max || '';
                document.getElementById("rata2").value = avg;

                // Status kelulusan
                var status = (avg >= 60) ? 'Lulus' : 'Tidak Lulus';
                document.getElementById("status").value = status;
            }
        </script>




        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>