<?php
require_once "koneksi.php";

// Hapus pengguna
if (isset($_GET['idpengguna'])) {
	$delete = mysqli_query($koneksi, "DELETE FROM pengguna WHERE id = '" . mysqli_real_escape_string($koneksi, $_GET['idpengguna']) . "'");
	echo "<script>window.location = 'pengguna.php'</script>";
}

// Hapus jurusan
elseif (isset($_GET['idjurusan'])) {
	$jurusan = mysqli_query($koneksi, "SELECT gambar FROM jurusan WHERE id = '" . mysqli_real_escape_string($koneksi, $_GET['idjurusan']) . "'");
	if (mysqli_num_rows($jurusan) > 0) {
		$p = mysqli_fetch_object($jurusan);
		if (file_exists("../uploads/jurusan/" . $p->gambar)) {
			unlink("../uploads/jurusan/" . $p->gambar);
		}
	}
	$delete = mysqli_query($koneksi, "DELETE FROM jurusan WHERE id = '" . mysqli_real_escape_string($koneksi, $_GET['idjurusan']) . "'");
	echo "<script>window.location = 'jurusan.php'</script>";
}

// Hapus galeri
elseif (isset($_GET['idgaleri'])) {
	$galeri = mysqli_query($koneksi, "SELECT foto FROM galeri WHERE id = '" . mysqli_real_escape_string($koneksi, $_GET['idgaleri']) . "'");
	if (mysqli_num_rows($galeri) > 0) {
		$p = mysqli_fetch_object($galeri);
		if (file_exists("../uploads/galeri/" . $p->foto)) {
			unlink("../uploads/galeri/" . $p->foto);
		}
	}
	$delete = mysqli_query($koneksi, "DELETE FROM galeri WHERE id = '" . mysqli_real_escape_string($koneksi, $_GET['idgaleri']) . "'");
	echo "<script>window.location = 'galeri.php'</script>";
}

// Hapus staff
elseif (isset($_GET['idstaff'])) {
	$staff = mysqli_query($koneksi, "SELECT foto FROM staff WHERE id = '" . mysqli_real_escape_string($koneksi, $_GET['idstaff']) . "'");
	if (mysqli_num_rows($staff) > 0) {
		$p = mysqli_fetch_object($staff);
		if (file_exists("../uploads/staff/" . $p->foto)) {
			unlink("../uploads/staff/" . $p->foto);
		}
	}
	$delete = mysqli_query($koneksi, "DELETE FROM staff WHERE id = '" . mysqli_real_escape_string($koneksi, $_GET['idstaff']) . "'");
	echo "<script>window.location = 'staff.php'</script>";
}

// Hapus fasilitas
elseif (isset($_GET['idfasilitas'])) {
	$fasilitas = mysqli_query($koneksi, "SELECT foto FROM fasilitas WHERE id = '" . mysqli_real_escape_string($koneksi, $_GET['idfasilitas']) . "'");
	if (mysqli_num_rows($fasilitas) > 0) {
		$p = mysqli_fetch_object($fasilitas);
		if (file_exists("../uploads/fasilitas/" . $p->foto)) {
			unlink("../uploads/fasilitas/" . $p->foto);
		}
	}
	$delete = mysqli_query($koneksi, "DELETE FROM fasilitas WHERE id = '" . mysqli_real_escape_string($koneksi, $_GET['idfasilitas']) . "'");
	echo "<script>window.location = 'fasilitas.php'</script>";
}

// Hapus informasi
elseif (isset($_GET['idinformasi'])) {
	$informasi = mysqli_query($koneksi, "SELECT gambar FROM informasi WHERE id = '" . mysqli_real_escape_string($koneksi, $_GET['idinformasi']) . "'");
	if (mysqli_num_rows($informasi) > 0) {
		$p = mysqli_fetch_object($informasi);
		if (file_exists("../uploads/informasi/" . $p->gambar)) {
			unlink("../uploads/informasi/" . $p->gambar);
		}
	}
	$delete = mysqli_query($koneksi, "DELETE FROM informasi WHERE id = '" . mysqli_real_escape_string($koneksi, $_GET['idinformasi']) . "'");
	echo "<script>window.location = 'informasi.php'</script>";
}

// Hapus struktur organisasi
elseif (isset($_GET['idstruktur'])) {
	$id = $_GET['idstruktur'];
	// Mengambil data foto yang terkait dengan ID yang akan dihapus
	$query = "SELECT foto FROM struktur_organisasi WHERE id = $id";
	$result = mysqli_query($koneksi, $query);

	if (mysqli_num_rows($result) > 0) {
		// Mengambil data foto
		$data = mysqli_fetch_assoc($result);
		$foto = $data['foto'];

		// Menghapus foto dari server jika file ada
		if (!empty($foto) && file_exists("../uploads/struktur_organisasi/$foto")) {
			unlink("../uploads/struktur_organisasi/$foto");
		}

		// Menghapus data struktur_organisasi dari database
		$deleteQuery = "DELETE FROM struktur_organisasi WHERE id = $id";
		if (mysqli_query($koneksi, $deleteQuery)) {
			header("Location: struktur.php?status=success");
			exit;
		} else {
			echo "Error: " . mysqli_error($koneksi);
		}
	} else {
		echo "Data tidak ditemukan.";
	}
}

// Hapus guru
elseif (isset($_GET['nip'])) {
	$nip = mysqli_real_escape_string($koneksi, $_GET['nip']);
	$checkGuru = mysqli_query($koneksi, "SELECT * FROM tbl_guru WHERE nip = '$nip'");

	if (mysqli_num_rows($checkGuru) > 0) {
		$delete = mysqli_query($koneksi, "DELETE FROM tbl_guru WHERE nip = '$nip'");
		if ($delete) {
			header("Location: guru.php?success=Data guru berhasil dihapus.");
		} else {
			header("Location: guru.php?error=Gagal menghapus data guru.");
		}
	} else {
		header("Location: guru.php?error=Data guru tidak ditemukan.");
	}
}

// Hapus pelajaran
elseif (isset($_GET['idpelajaran'])) {
	$idPelajaran = mysqli_real_escape_string($koneksi, $_GET['idpelajaran']);
	$pelajaran = mysqli_query($koneksi, "SELECT * FROM tbl_pelajaran WHERE id = '$idPelajaran'");

	if (mysqli_num_rows($pelajaran) > 0) {
		$delete = mysqli_query($koneksi, "DELETE FROM tbl_pelajaran WHERE id = '$idPelajaran'");
		if ($delete) {
			echo "<script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data pelajaran berhasil dihapus.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = 'pelajaran.php';
                    }
                });
            </script>";
		} else {
			echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal menghapus data pelajaran.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = 'pelajaran.php';
                    }
                });
            </script>";
		}
	} else {
		echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Data pelajaran tidak ditemukan.',
                icon: 'warning',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'pelajaran.php';
                }
            });
        </script>";
	}
}

// Hapus kegiatan
elseif (isset($_GET['idkegiatan'])) {
	$id = mysqli_real_escape_string($koneksi, $_GET['idkegiatan']);
	$kegiatan = mysqli_query($koneksi, "SELECT nama,gambar1, gambar2, gambar3, gambar4, gambar5, gambar6 FROM kegiatan_jurusan WHERE id = '$id'");

	if (mysqli_num_rows($kegiatan) > 0) {
		$p = mysqli_fetch_assoc($kegiatan);
		for ($i = 1; $i <= 6; $i++) {
			$gambar = $p['gambar' . $i];
			if ($gambar && file_exists("../uploads/kegiatan/" . $gambar)) {
				unlink("../uploads/kegiatan/" . $gambar);
			}
		}

		$delete = mysqli_query($koneksi, "DELETE FROM kegiatan_jurusan WHERE id = '$id'");
		if ($delete) {
			echo "<script>
                alert('Data berhasil dihapus.');
                window.location = 'kegiatan-belajar.php';
            </script>";
		} else {
			echo "<script>alert('Gagal menghapus data.');</script>";
		}
	} else {
		echo "<script>alert('Data kegiatan tidak ditemukan.');</script>";
	}
}
