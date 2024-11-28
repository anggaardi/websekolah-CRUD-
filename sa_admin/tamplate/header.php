<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    include 'koneksi.php';
    if (!isset($_SESSION['status_login'])) {
        echo "<script>window.location = '../login.php?msg=Harap Login Terlebih Dahulu!'</script>";
    }
    date_default_timezone_set("Asia/Jakarta");

    $identitas = mysqli_query($koneksi, "SELECT * FROM pengaturan ORDER BY id DESC LIMIT 1");
    $d = mysqli_fetch_object($identitas);
    ?>

    <link rel="icon" href="../uploads/identitas/<?= $d->favicon ?>">
    <title>Panel Admin - <?= $d->nama ?></title>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/notyf@3.6.0/notyf.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/notyf@3.6.0/notyf.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.tiny.cloud/1/6kvrps9mr93fvjl80xzf7br92qlrgpsekt08nl86i3c7cscu/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#keterangan'
            });

            function toggleDropdown(id) {
                const dropdown = document.getElementById(id);
                dropdown.classList.toggle('hidden');
            }

            // Menutup dropdown jika mengklik di luar
            window.onclick = function(event) {
                if (!event.target.matches('.nav-menu a')) {
                    const dropdowns = document.querySelectorAll('.dropdown');
                    dropdowns.forEach(dropdown => {
                        if (!dropdown.classList.contains('hidden')) {
                            dropdown.classList.add('hidden');
                        }
                    });
                }
            }
        </script>
    </head>