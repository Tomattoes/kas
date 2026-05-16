<?php
include 'koneksi.php';

// TOTAL PEMASUKAN
$masuk = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(nominal) as total
FROM transaksi
WHERE jenis='masuk'"));

// TOTAL PENGELUARAN
$keluar = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT SUM(nominal) as total
FROM transaksi
WHERE jenis='keluar'"));

$total_masuk = $masuk['total'] ?? 0;
$total_keluar = $keluar['total'] ?? 0;

$saldo = $total_masuk - $total_keluar;

// AKUMULASI LABEL
$label = mysqli_query($conn,
"SELECT 
    labels.nama_label,
    labels.warna,

    SUM(
        CASE
            WHEN transaksi.jenis='masuk'
            THEN transaksi.nominal
            ELSE 0
        END
    ) as total_masuk,

    SUM(
        CASE
            WHEN transaksi.jenis='keluar'
            THEN transaksi.nominal
            ELSE 0
        END
    ) as total_keluar

FROM transaksi

JOIN labels 
ON transaksi.label_id = labels.id

GROUP BY transaksi.label_id

ORDER BY labels.nama_label ASC
");

// 3 TRANSAKSI TERBARU
$transaksi = mysqli_query($conn,
"SELECT transaksi.*, labels.nama_label, labels.warna
FROM transaksi
JOIN labels ON transaksi.label_id = labels.id
ORDER BY transaksi.tanggal DESC, transaksi.id DESC
LIMIT 3");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Dana</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard Dana</h2>
        <a href="riwayat.php" class="btn btn-primary">
            Lihat Semua Riwayat
        </a>
    </div>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow p-3">
                <h5>Total Pemasukan</h5>
                <h3 class="text-success">
                    Rp <?= number_format($total_masuk) ?>
                </h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow p-3">
                <h5>Total Pengeluaran</h5>
                <h3 class="text-danger">
                    Rp <?= number_format($total_keluar) ?>
                </h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow p-3">
                <h5>Saldo Saat Ini</h5>
                <h3 class="text-primary">
                    Rp <?= number_format($saldo) ?>
                </h3>
            </div>
        </div>
    </div>
    <div class="card shadow p-3 mb-4">

    <h4 class="mb-3">
        Akumulasi Berdasarkan Label
    </h4>

    <table class="table table-bordered table-hover">

        <thead>

            <tr>
                <th>Label</th>
                <th>Total Masuk</th>
                <th>Total Keluar</th>
                <th>Saldo</th>
            </tr>

        </thead>

        <tbody>

        <?php while($l = mysqli_fetch_array($label)) { 

            $saldo_label =
                $l['total_masuk'] -
                $l['total_keluar'];

        ?>

            <tr>

                <td>

                    <span class="badge"
                    style="background: <?= $l['warna'] ?>">

                        <?= $l['nama_label'] ?>

                    </span>

                </td>

                <td class="text-success">

                    Rp <?= number_format($l['total_masuk']) ?>

                </td>

                <td class="text-danger">

                    Rp <?= number_format($l['total_keluar']) ?>

                </td>

                <td class="
                    <?= ($saldo_label >= 0)
                        ? 'text-primary'
                        : 'text-danger'
                    ?>
                ">

                    <strong>
                        Rp <?= number_format($saldo_label) ?>
                    </strong>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>
    <div class="card shadow p-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4>
            3 Transaksi Terbaru
        </h4>

        <a href="riwayat.php"
        class="btn btn-primary btn-sm">

            Lihat Semua

        </a>

    </div>


    <?php while($row = mysqli_fetch_array($transaksi)) { ?>

        <div class="border rounded p-3 mb-3 bg-light">

            <div class="row align-items-center">

                <!-- TANGGAL -->

                <div class="col-md-2">

                    <small class="text-muted">
                        Tanggal
                    </small>

                    <div>
                        <strong>
                            <?= $row['tanggal'] ?>
                        </strong>
                    </div>

                </div>


                <!-- JENIS -->

                <div class="col-md-2">

                    <small class="text-muted">
                        Jenis
                    </small>

                    <div>

                        <?php if($row['jenis'] == 'masuk') { ?>

                            <span class="badge bg-success">
                                Masuk
                            </span>

                        <?php } else { ?>

                            <span class="badge bg-danger">
                                Keluar
                            </span>

                        <?php } ?>

                    </div>

                </div>


                <!-- NOMINAL -->

                <div class="col-md-3">

                    <small class="text-muted">
                        Nominal
                    </small>

                    <div class="
                    <?= ($row['jenis'] == 'masuk')
                        ? 'text-success'
                        : 'text-danger'
                    ?>">

                        <strong>
                            Rp <?= number_format($row['nominal']) ?>
                        </strong>

                    </div>

                </div>


                <!-- LABEL -->

                <div class="col-md-3">

                    <small class="text-muted">
                        Label
                    </small>

                    <div>

                        <span class="badge"
                        style="background: <?= $row['warna'] ?>">

                            <?= $row['nama_label'] ?>

                        </span>

                    </div>

                </div>


                <!-- BUTTON -->

                <div class="col-md-2 text-end">

                    <a href="detail.php?id=<?= $row['id'] ?>"
                    class="btn btn-outline-primary btn-sm">

                        Detail

                    </a>

                </div>

            </div>

        </div>

    <?php } ?>

</div>
</div>
</body>
</html>