<?php include 'header.php'; ?>
<div class="w-full bg-white py-5"></div>

<div class="section py-10">
    <h3 class="text-center pre-title text-lg font-semibold text-gray-400 rounded">Struktur organisasi</h3>
    <h1 class="font-bold text-black text-4xl uppercase text-center py-3">
        <a href="index.php" class="hover:text-blue-800 transition-colors duration-200"><?= $d->nama ?></a>
    </h1>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
        <?php
        // Query untuk mengambil data struktur organisasi
        $struktur_organisasi = mysqli_query($conn, "SELECT * FROM struktur_organisasi ORDER BY id DESC");
        if (mysqli_num_rows($struktur_organisasi) > 0) {
            while ($so = mysqli_fetch_array($struktur_organisasi)) {
        ?>

                <div class="rounded-[12px] bg-white w-96 px-4 py-6 md:px-6 md:py-8" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 8px">
                    <a href="uploads/struktur_organisasi/<?= $so['foto'] ?>" target="_blank" class="block relative group">
                        <!-- Bagian untuk menampilkan foto struktur organisasi -->
                        <div class="h-96 rounded-lg relative bg-cover bg-center" style="background-image: url('uploads/struktur_organisasi/<?= $so['foto'] ?>');">
                            <div class="absolute inset-0 rounded-lg flex items-center justify-center bg-black opacity-0 group-hover:opacity-60 transition-opacity duration-300 ease-in-out"></div>
                            <!-- Gambar sekolah di tengah -->
                            <img src="assets/sekolah.png" class="absolute inset-10 m-auto h-1/3 w-1/3 object-cover opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out" style="top: 50%; left: 50%; transform: translate(-50%, -50%);" />
                        </div>
                        <div class="text-center">
                            <!-- Menampilkan nama dari struktur organisasi -->
                            <h4 class="mb-2 mt-3 text-base font-semibold text-[#222] md:text-lg"><?= $so['nama']; ?></h4>
                            <!-- Menampilkan deskripsi singkat -->
                            <p class="line-clamp-2 text-xs leading-6 text-[gray] md:text-sm"><?= $so['deskripsi']; ?></p>
                        </div>
                    </a>
                </div>

            <?php }
        } else { ?>
            <p class="text-center col-span-3 text-gray-500">Tidak ada data.</p>
        <?php } ?>
    </div>

    <div class="w-full bg-white py-20"></div>

    <div class="section py-10">
        <div class="container mx-auto">
            <h3 class="text-center pre-title text-lg font-semibold text-gray-400 rounded">Guru dan Pegawai</h3>
            <h1 class="font-bold text-black text-4xl uppercase text-center py-3">
                <a href="index.php" class="hover:text-blue-800 transition-colors duration-200"><?= $d->nama ?></a>
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <?php
                // Query untuk mengambil data staff dan mengurutkannya berdasarkan deskripsi
                $staff = mysqli_query($conn, "SELECT * FROM staff ORDER BY deskripsi ASC, id DESC");
                if (mysqli_num_rows($staff) > 0) {
                    while ($p = mysqli_fetch_array($staff)) {
                ?>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="rounded-[12px] bg-white w-96 px-4 py-6 md:px-6 md:py-8" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 8px">
                                <a href="uploads/staff/<?= $p['foto'] ?>" target="_blank" class="block relative group">
                                    <!-- Bagian untuk menampilkan foto -->
                                    <div class="h-96 rounded-lg relative bg-cover bg-center" style="background-image: url('uploads/staff/<?= $p['foto'] ?>');">
                                        <div class="absolute inset-0 rounded-lg flex items-center justify-center bg-black opacity-0 group-hover:opacity-60 transition-opacity duration-300 ease-in-out"></div>
                                        <!-- Gambar sekolah di tengah -->
                                        <img src="assets/sekolah.png" class="absolute inset-10 m-auto h-1/3 w-1/3 object-cover opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out" style="top: 50%; left: 50%; transform: translate(-50%, -50%);" />
                                    </div>
                                    <div class="text-center">
                                        <!-- Menampilkan nama dari staff -->
                                        <h4 class="mb-2 mt-3 text-base font-semibold text-[#222] md:text-lg"><?= $p['nama']; ?></h4>
                                        <!-- Menampilkan deskripsi singkat -->
                                        <p class="line-clamp-2 text-xs leading-6 text-[gray] md:text-sm"><?= $p['deskripsi']; ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <p class="text-center col-span-3 text-gray-500">Tidak ada data.</p>
                <?php } ?>
            </div>
        </div>
        <?php include 'footer.php'; ?>