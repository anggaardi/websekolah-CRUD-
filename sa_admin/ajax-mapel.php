<?php

require_once "koneksi.php";
$jurusan = $_GET['jurusan'];

$no = 1;
$querypelajaran = mysqli_query($koneksi, "SELECT * FROM  tbl_pelajaran WHERE jurusan = 'umum' or jurusan = '$jurusan'");
while ($data = mysqli_fetch_array($querypelajaran)) { ?>
<tr>
    <td>
        <td align="center"><?= $no++ ?></td>
<td><input type="text" name="mapel[]" value="<?=$data ['pelajaran']?>" class="border-0 bg-transparent col-12" readonly></td>
<td><input type="text" name="jurusan[]" value="<?=$data ['jurusan']?>" class="border-0 bg-transparent col-12" readonly></td>
<td><input type="number" name="nilai[]" value="0" min="0" max="100" step="5" class="form-control nilai text-center"></td>


    </td>
</tr>

<?php
}
?>

?>