<?php

function shakemap($dateString, $timeString)
{
    $konversi_bulan = [
        "Jan" => "01",
        "Feb" => "02",
        "Mar" => "03",
        "Apr" => "04",
        "Mei" => "05",
        "Jun" => "06",
        "Jul" => "07",
        "Agu" => "08",
        "Sep" => "09",
        "Okt" => "10",
        "Nov" => "11",
        "Des" => "12"
    ];

    $timeString = str_replace(" WIB", "", $timeString);

    $split = explode(" ", $dateString);
    $tahun = $split[2];
    $bulan = $konversi_bulan[$split[1]];
    $tanggal = sprintf("%02d", $split[0]);

    $formattedDate = "$tahun$bulan$tanggal$timeString";

    return date("YmdHis", strtotime($formattedDate)) . ".mmi.jpg";
}


$api_url = "https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json";

// Mengambil data dari API
$response = file_get_contents($api_url);

if ($response !== false) {
    // Parsing data JSON
    $data = json_decode($response, true)['Infogempa']['gempa'];
} else {
    header('gempaDirasakan.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>DEMAN</title>
    <script src="assets/js/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
    <header class="fixed-top top-0 start-0 w-100 pb-3 pt-2" style="background-color: #59D8E3; z-index: 1000; border-radius: 0 0 50% 50%;">
        <h3 class="text-center text-white" style="font-size: 25px;">Data Gempa</h3>
    </header>
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="fw-bold">15 Gempa Dirasakan</h3>
            </div>
            <div class="col-12 overflow-auto" style="height: 83vh; font-size: 15px;">

                <?php foreach ($data as $k => $v) : ?>
                    <?php
                    $api = [
                        "Tanggal" => $v['Tanggal'],
                        "Jam" => $v['Jam'],
                        "DateTime" => $v['DateTime'],
                        "Coordinates" => $v['Coordinates'],
                        "Lintang" => $v['Lintang'],
                        "Bujur" => $v['Bujur'],
                        "Magnitude" => $v['Magnitude'],
                        "Kedalaman" => $v['Kedalaman'],
                        "Wilayah" => $v['Wilayah'],
                        "Potensi" => @$v['Potensi'],
                        "Dirasakan" => @$v['Dirasakan'],
                        "Shakemap" => shakemap($v['Tanggal'], $v['Jam'])
                    ];
                    ?>
                    <?php $wilayah = explode(' di ', $v['Wilayah']); ?>
                    <form onclick="$(this).submit()" action="detailGempa.php" method="POST" class="row mt-2 item_gempa">
                        <textarea class="d-none" name="data"><?= json_encode($api); ?></textarea>
                        <div class="col-2 text-center d-flex align-items-center">
                            <img width="30" height="30" src="assets/images/icon_gempa.gif" alt="Icon Gempa">
                        </div>
                        <div class="col-6">
                            <p class="m-0 p-0 fw-bold"><?= end($wilayah) ?></p>
                            <p class="m-0 p-0 text-warning" style="font-size: small;"><?= $v['Tanggal'] ?> <?= $v['Jam'] ?></p>
                        </div>
                        <div class="col-4 text-center d-flex align-items-center">
                            <p class="text-danger"><?= $v['Magnitude'] ?> Magnitude</p>
                        </div>
                    </form>
                    <hr>
                <?php endforeach; ?>

            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>