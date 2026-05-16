<?php
include 'koneksi.php';
session_start();

if(!isset($_SESSION['login'])){

    header("Location:viewer/index.php");
    exit;

}

// ======================
// PAGINATION
// ======================

$batas = 20;

$halaman = isset($_GET['halaman'])
    ? (int)$_GET['halaman']
    : 1;

$halaman_awal = ($halaman - 1) * $batas;


// ======================
// QUERY DATA
// ======================

$data = mysqli_query($conn,
"SELECT transaksi.*, labels.nama_label, labels.warna
FROM transaksi
JOIN labels ON transaksi.label_id = labels.id
ORDER BY transaksi.tanggal DESC
LIMIT $halaman_awal, $batas");


// ======================
// TOTAL DATA
// ======================

$total_data = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM transaksi")
);

$total_halaman = ceil($total_data / $batas);


// ======================
// TOTAL KEUANGAN
// ======================

$masuk = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(nominal) as total
FROM transaksi
WHERE jenis='masuk'"));

$keluar = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(nominal) as total
FROM transaksi
WHERE jenis='keluar'"));

$total_masuk = $masuk['total'] ?? 0;
$total_keluar = $keluar['total'] ?? 0;

$saldo = $total_masuk - $total_keluar;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistem Kas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-4">

        <h2>KAS</h2>

        <div>
            <a href="logout.php"
            class="btn btn-danger">

                Logout

            </a>
            <a href="label.php" class="btn btn-success">
                Kelola Label
            </a>

            <a href="tambah.php" class="btn btn-primary">
                + Tambah Transaksi
            </a>

        </div>

    </div>

    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card p-3 shadow">

                <h5>Total Pemasukan</h5>

                <h3 class="text-success">
                    Rp <?= number_format($total_masuk) ?>
                </h3>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card p-3 shadow">

                <h5>Total Pengeluaran</h5>

                <h3 class="text-danger">
                    Rp <?= number_format($total_keluar) ?>
                </h3>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card p-3 shadow">

                <h5>Saldo Saat Ini</h5>

                <h3 class="text-primary">
                    Rp <?= number_format($saldo) ?>
                </h3>

            </div>

        </div>

    </div>

    <div class="card p-3 shadow">

        <h4 class="mb-3">
            Riwayat Transaksi
        </h4>

        <table class="table table-bordered table-hover">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Platform</th>
                    <th>Nominal</th>
                    <th>Label</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>

            </thead>

            <tbody>

            <?php
            $no = $halaman_awal + 1;

            while($row = mysqli_fetch_array($data)) {
            ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td>
                        <?= $row['tanggal'] ?>
                    </td>

                    <td>

                        <?php if($row['jenis'] == 'masuk') { ?>

                            <span class="badge bg-success">
                                Masuk
                            </span>

                        <?php } else { ?>

                            <span class="badge bg-danger">
                                Keluar
                            </span>

                        <?php } ?>

                    </td>

                    <td>
                        <?= $row['platform'] ?>
                    </td>

                    <td>
                        Rp <?= number_format($row['nominal']) ?>
                    </td>

                    <td>

                        <span class="badge"
                        style="background: <?= $row['warna'] ?>">

                            <?= $row['nama_label'] ?>

                        </span>

                    </td>

                    <td>
                        <?= $row['keterangan'] ?>
                    </td>

                    <td>

                        <a href="hapus.php?id=<?= $row['id'] ?>"
                        class="btn btn-danger btn-sm">

                            Hapus

                        </a>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>


        <!-- PAGINATION -->

        <nav>

            <ul class="pagination justify-content-center">

                <?php for($i = 1; $i <= $total_halaman; $i++) { ?>

                    <li class="page-item
                    <?= ($i == $halaman) ? 'active' : '' ?>">

                        <a class="page-link"
                        href="?halaman=<?= $i ?>">

                            <?= $i ?>

                        </a>

                    </li>

                <?php } ?>

            </ul>

        </nav>

    </div>

</div>

</body>
</html>