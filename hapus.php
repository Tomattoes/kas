<?php

include 'koneksi.php';
if(!isset($_SESSION['login'])){

    header("Location:viewer/index.php");
    exit;

}

$id = $_GET['id'];

mysqli_query($conn,
"DELETE FROM transaksi WHERE id='$id'");

header("Location:index.php");

?>