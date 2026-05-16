<?php

include 'koneksi.php';
if(!isset($_SESSION['login'])){

    header("Location:viewer/index.php");
    exit;

}

$nama = $_POST['nama_label'];
$warna = $_POST['warna'];

mysqli_query($conn,
"INSERT INTO labels(nama_label, warna)
VALUES('$nama','$warna')");

header("Location:label.php");

?>