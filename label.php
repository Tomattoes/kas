<?php
include 'koneksi.php';
session_start();

if(!isset($_SESSION['login'])){

    header("Location:viewer/index.php");
    exit;

}

$data = mysqli_query($conn, "SELECT * FROM labels");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Label</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Kelola Label</h2>

        <a href="index.php" class="btn btn-secondary">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div class="card p-4 shadow mb-4">

        <h3>Tambah Label</h3>

        <form action="simpan_label.php" method="POST">

            <div class="mb-3">
                <label>Nama Label</label>
                <input type="text" name="nama_label" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Warna Label</label>
                <input type="color" name="warna" class="form-control form-control-color">
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan Label
            </button>

        </form>

    </div>

    <div class="card p-4 shadow">

        <h4>Daftar Label</h4>

        <?php while($row = mysqli_fetch_array($data)) { ?>

            <span class="badge me-2 p-2"
            style="background: <?= $row['warna'] ?>">
                <?= $row['nama_label'] ?>
            </span>

        <?php } ?>

    </div>

</div>

</body>
</html>