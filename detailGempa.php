<?php

if (isset($_POST['data'])) {
    $data = json_decode($_POST['data'], true);
    $api = $_POST['data'];
} else {
    echo "Gagal terhubung";
    die;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>DEMAN</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
</head>

<body>
    <header class="fixed-top top-0 start-0 w-100 pb-3 pt-2" style="background-color: #59D8E3; z-index: 1000; border-radius: 0 0 50% 50%;">
        <h3 class="text-center text-white" style="font-size: 25px;">Data Gempa</h3>
    </header>
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-12 d-none d-md-block">
                <?php if ($data['Potensi']) : ?>
                    <h3 class="fw-normal">Gempa 5+ Magnitude</h3>
                <?php else : ?>
                    <h3 class="fw-normal">Gempa Dirasakan</h3>
                <?php endif; ?>
            </div>
            <div class="col-12 overflow-auto" style="height: 83vh; font-size: 15px;">

                <div class="row">
                    <a href="https://data.bmkg.go.id/DataMKG/TEWS/<?= $data['Shakemap']; ?>" class="col-md-6 order-2 order-md-1">
                        <img class="img-fluid" src="https://data.bmkg.go.id/DataMKG/TEWS/<?= $data['Shakemap']; ?>" alt="">
                    </a>

                    <div class="col-md-6 order-1 order-md-2">
                        <div class="d-flex justify-content-between">
                            <h4 class="table mt-3 d-none d-md-block">Detail Gempa</h4>
                            <?php if ($data['Potensi']) : ?>
                                <h4 class="fw-bold d-md-none d-block">Gempa 5+ Magnitude</h4>
                            <?php else : ?>
                                <h4 class="fw-bold d-md-none d-block">Gempa Dirasakan</h4>
                            <?php endif; ?>
                            <form action="tampilPeta.php" method="POST">
                                <textarea class="d-none" name="data"><?= $api ?></textarea>
                                <button class="btn btn-info text-light btn-xs mt-3 me-3" style="font-size: 12px;"><i class="fa fa-map"></i> Peta</button>
                            </form>
                        </div>
                        <table>
                            <tbody>
                                <tr>
                                    <th>Tanggal</th>
                                    <td><?= $data['Tanggal']; ?></td>
                                </tr>
                                <tr>
                                    <th>Jam</th>
                                    <td><?= $data['Jam']; ?></td>
                                </tr>
                                <tr>
                                    <th>Koordinat</th>
                                    <td><?= $data['Coordinates']; ?></td>
                                </tr>
                                <tr>
                                    <th>Lintang</th>
                                    <td><?= $data['Lintang']; ?></td>
                                </tr>
                                <tr>
                                    <th>Bujur</th>
                                    <td><?= $data['Bujur']; ?></td>
                                </tr>
                                <tr>
                                    <th>Magnitude</th>
                                    <td><?= $data['Magnitude']; ?></td>
                                </tr>
                                <tr>
                                    <th>Kedalaman</th>
                                    <td><?= $data['Kedalaman']; ?></td>
                                </tr>
                                <tr>
                                    <th>Wilayah</th>
                                    <td><?= $data['Wilayah']; ?></td>
                                </tr>
                                <?php if ($data['Potensi']) : ?>
                                    <tr>
                                        <th>Potensi</th>
                                        <td><?= $data['Potensi']; ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($data['Dirasakan']) : ?>
                                    <tr>
                                        <th>Dirasakan</th>
                                        <td><?= $data['Dirasakan']; ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/fontawesome/js/all.min.js"></script>
</body>

</html>