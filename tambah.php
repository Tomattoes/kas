<?php
include 'koneksi.php';
session_start();

if(!isset($_SESSION['login'])){

    header("Location:viewer/index.php");
    exit;

}

$label = mysqli_query($conn, "SELECT * FROM labels");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="card p-4 shadow">

        <h3 class="mb-4">Tambah Transaksi</h3>

        <form action="simpan.php" method="POST">

            <div class="mb-3">
                <label>Jenis Transaksi</label>
                <select name="jenis" class="form-control">
                    <option value="masuk">Uang Masuk</option>
                    <option value="keluar">Uang Keluar</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Platform</label>
                <select name="platform" class="form-control">
                    <option value="BRIMO">Brimo</option>
                    <option value="SHORTPRO">ShortPro</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Nominal</label>
                <input type="number" name="nominal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Label</label>
                <select name="label_id" class="form-control">

                    <?php while($l = mysqli_fetch_array($label)) { ?>

                    <option value="<?= $l['id'] ?>">
                        <?= $l['nama_label'] ?>
                    </option>

                    <?php } ?>

                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal Input</label>

                <select name="mode_tanggal" class="form-control">
                    <option value="otomatis">Otomatis</option>
                    <option value="manual">Manual</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal Manual</label>
                <input type="datetime-local"
                name="tanggal_manual"
                class="form-control">
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

            <a href="index.php" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

</body>
</html>