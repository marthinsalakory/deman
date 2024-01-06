<?php
if (isset($_POST['data'])) {
    $data = json_decode($_POST['data'], true);
    $koordinat = explode(',', $data['Coordinates']);
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
    <link rel="stylesheet" href="assets/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="assets/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .leaflet-container {
            height: 400px;
            width: 600px;
            max-width: 100%;
            max-height: 100%;
        }

        header {
            background-color: #59D8E3;
            z-index: 1000;
            /* Pastikan header di atas peta */
            border-radius: 0 0 50% 50%;
        }

        header h3 {
            text-align: center;
            color: #ffffff;
            font-size: 25px;
        }
    </style>

    <style>
        body {
            padding: 0;
            margin: 0;
        }

        #map {
            height: 100%;
            width: 100vw;
        }
    </style>
</head>

<body>
    <header class="fixed-top top-0 start-0 w-100 pb-3 pt-2">
        <h3>Evakuasi Gempa</h3>
    </header>

    <div id='map'></div>

    <script>
        const map = L.map('map', {
            attributionControl: false, // Menyembunyikan atribusi
            zoomControl: false
        }).setView([-3.6956, 128.1833], 4); // Koordinat Ambon: [-3.6956, 128.1833]

        const tiles = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 19,
            id: 'mapbox/satellite-v9', // Jenis peta satelit
            accessToken: 'pk.eyJ1IjoiYWxmcmVpbnNjbyIsImEiOiJjbGppaDdhZ3MwMDZ0M2ZubzBkcDM2ZXZiIn0.7yoOQVxUSrjBuDqRXNXu7w' // Ganti dengan kunci API Mapbox Anda
        }).addTo(map);

        // Buat ikon untuk marker
        const customIcon = L.icon({
            iconUrl: 'assets/images/icon_gempa.gif', // Ganti 'icon_gempa.gif' dengan nama file gambar ikon yang sesuai
            iconSize: [60, 60], // Sesuaikan ukuran ikon jika diperlukan
            iconAnchor: [30, 30], // Sesuaikan titik ancor ikon jika diperlukan
        });
        // Buat marker dengan koordinat dari respons JSON
        const marker = L.marker([<?= @$koordinat[0] ?>, <?= @$koordinat[1] ?>], {
            icon: customIcon
        }).addTo(map);

        marker.bindPopup(`<b>Informasi Gempa</b><br>
            Tanggal: <?= @$data['Tanggal'] ?><br>
            Jam: <?= @$data['Jam'] ?><br>
            Coordinates: <?= @$data['Coordinates'] ?><br>
            Lintang: <?= @$data['Lintang'] ?><br>
            Bujur: <?= @$data['Bujur'] ?><br>
            Magnitude: <?= @$data['Magnitude'] ?><br>
            Kedalaman: <?= @$data['Kedalaman'] ?><br>
            Wilayah: <?= @$data['Wilayah'] ?><br>
            <?php if ($data['Potensi']) : ?>
                Potensi: <?= @$data['Potensi'] ?><br>
            <?php endif; ?>
            <?php if ($data['Dirasakan']) : ?>
                Dirasakan: <?= @$data['Dirasakan'] ?><br>
            <?php endif; ?>
        `);

        // Fokus secara otomatis ke marker
        map.flyTo([<?= @$koordinat[0] ?>, <?= @$koordinat[1] ?>], 10);
    </script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>