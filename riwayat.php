<?php
include 'koneksi.php';

$batas = 20;

$halaman = isset($_GET['halaman'])
    ? (int)$_GET['halaman']
    : 1;

$awal = ($halaman - 1) * $batas;

$data = mysqli_query($conn,
"SELECT transaksi.*, labels.nama_label, labels.warna
FROM transaksi
JOIN labels ON transaksi.label_id = labels.id
ORDER BY transaksi.tanggal DESC, transaksi.id DESC
LIMIT $awal, $batas");

$total_data = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM transaksi")
);

$total_halaman = ceil($total_data / $batas);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between mb-4">

        <h2>Riwayat Transaksi</h2>

        <a href="index.php" class="btn btn-secondary">
            Kembali
        </a>

    </div>

    <div class="card shadow p-3">

        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Platform</th>
                    <th>Nominal</th>
                    <th>Label</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php
            $no = $awal + 1;
            while($row = mysqli_fetch_array($data)) {
            ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= $row['tanggal'] ?></td>

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

                        <a href="detail.php?id=<?= $row['id'] ?>"
                        class="btn btn-info btn-sm text-white">

                            Detail

                        </a>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>


        <nav>

            <ul class="pagination justify-content-center">

                <?php for($i = 1; $i <= $total_halaman; $i++) { ?>

                    <li class="page-item <?= ($i == $halaman) ? 'active' : '' ?>">

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