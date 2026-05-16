<?php
include 'koneksi.php';

// Ambil ID transaksi
$id = $_GET['id'];

// Ambil data transaksi + label
$data = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT transaksi.*, labels.nama_label, labels.warna
FROM transaksi
JOIN labels ON transaksi.label_id = labels.id
WHERE transaksi.id='$id'"));

?>

<!DOCTYPE html>
<html>
<head>

    <title>Detail Transaksi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h3>
                Detail Transaksi
            </h3>

            <a href="riwayat.php"
            class="btn btn-secondary">

                Kembali

            </a>

        </div>


        <table class="table table-bordered">

            <tr>
                <th width="30%">
                    Tanggal
                </th>

                <td>
                    <?= $data['tanggal'] ?>
                </td>
            </tr>


            <tr>

                <th>
                    Jenis
                </th>

                <td>

                    <?php if($data['jenis'] == 'masuk') { ?>

                        <span class="badge bg-success">
                            Pemasukan
                        </span>

                    <?php } else { ?>

                        <span class="badge bg-danger">
                            Pengeluaran
                        </span>

                    <?php } ?>

                </td>

            </tr>


            <tr>

                <th>
                    Platform
                </th>

                <td>
                    <?= $data['platform'] ?>
                </td>

            </tr>


            <tr>

                <th>
                    Nominal
                </th>

                <td class="
                <?= ($data['jenis'] == 'masuk')
                    ? 'text-success'
                    : 'text-danger'
                ?>">

                    <strong>
                        Rp <?= number_format($data['nominal']) ?>
                    </strong>

                </td>

            </tr>


            <tr>

                <th>
                    Label
                </th>

                <td>

                    <span class="badge"
                    style="background: <?= $data['warna'] ?>">

                        <?= $data['nama_label'] ?>

                    </span>

                </td>

            </tr>


            <tr>

                <th>
                    Keterangan
                </th>

                <td>

                    <?=
                    !empty($data['keterangan'])
                    ? $data['keterangan']
                    : '-'
                    ?>

                </td>

            </tr>

        </table>


        <div class="mt-3">

            <a href="riwayat.php"
            class="btn btn-primary">

                ← Kembali ke Riwayat

            </a>

        </div>

    </div>

</div>

</body>
</html>