<?php

include 'koneksi.php';

$jenis = $_POST['jenis'];
$platform = $_POST['platform'];
$nominal = $_POST['nominal'];
$label_id = $_POST['label_id'];
$keterangan = $_POST['keterangan'];
$mode = $_POST['mode_tanggal'];

if($mode == 'manual') {

    $tanggal = $_POST['tanggal_manual'];

} else {

    $tanggal = date('Y-m-d H:i:s');
}

mysqli_query($conn,
"INSERT INTO transaksi
(jenis, platform, nominal, label_id, keterangan, tanggal)
VALUES
('$jenis','$platform','$nominal','$label_id','$keterangan','$tanggal')");

header("Location:index.php");

?>