<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary">
        <!-- Navbar Brand -->
        <h3 class="text-white h5 ps-5 font-weight-bold">
            <a href="index.php" class="text-decoration-none text-white"><?= $d->nama ?></a>
        </h3>

        <!-- Sidebar Toggle -->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar -->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> <?= $_SESSION['uname'] ?> (<?= $_SESSION['ulevel'] ?>)
                </a>
                <ul class="dropdown-menu dropdown-menu-end bg-dark" aria-labelledby="navbarDropdown">
                    <?php if ($_SESSION['ulevel'] == 'admin') { ?>
                        <li class="dropdown-header text-white">Start Menu</li>
                        <li><a class="dropdown-item text-white" href="ubah-password.php">Ubah Password</a></li>
                        <li><a class="dropdown-item text-white" href="logout.php">Keluar</a></li>
                        <li class="dropdown-divider"></li>
                        <li class="dropdown-header text-white">End Menu</li>
                    <?php } else { ?>
                        <li><a class="dropdown-item text-white" href="ubah-password.php">Ubah Password</a></li>
                        <li><a class="dropdown-item text-white" href="logout.php">Keluar</a></li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>