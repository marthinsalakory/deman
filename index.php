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

        fetch('https://data.bmkg.go.id/DataMKG/TEWS/autogempa.json')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {

                // Buat ikon untuk marker
                const customIcon = L.icon({
                    iconUrl: 'assets/images/icon_gempa.gif', // Ganti 'icon_gempa.gif' dengan nama file gambar ikon yang sesuai
                    iconSize: [60, 60], // Sesuaikan ukuran ikon jika diperlukan
                    iconAnchor: [30, 30], // Sesuaikan titik ancor ikon jika diperlukan
                });
                // Buat marker dengan koordinat dari respons JSON
                const marker = L.marker(data.Infogempa.gempa.Coordinates.split(','), {
                    icon: customIcon
                }).addTo(map);

                marker.bindPopup(`<b>Informasi Gempa</b><br>
                Tanggal: ${data.Infogempa.gempa.Tanggal}<br>
                Jam: ${data.Infogempa.gempa.Jam}<br>
                Magnitude: ${data.Infogempa.gempa.Magnitude}<br>
                Kedalaman: ${data.Infogempa.gempa.Kedalaman}<br>
                Wilayah: ${data.Infogempa.gempa.Wilayah}<br>
                Dirasakan: ${data.Infogempa.gempa.Dirasakan}<br>
                Potensi: ${data.Infogempa.gempa.Potensi}
            `);

                // Fokus secara otomatis ke marker
                map.flyTo(data.Infogempa.gempa.Coordinates.split(','), 10); // 10 adalah level zoom yang diinginkan, sesuaikan jika perlu
            })
            .catch(error => {
                console.error('There was a problem fetching the data:', error);
            });


        // function onLocationFound(e) {
        //     const radius = e.accuracy / 2;

        //     const locationMarker = L.marker(e.latlng).addTo(map)
        //         .bindPopup(`You are within ${radius} meters from this point`).openPopup();

        //     const locationCircle = L.circle(e.latlng, radius).addTo(map);
        // }

        // function onLocationError(e) {
        //     alert(e.message);
        // }

        // map.on('locationfound', onLocationFound);
        // map.on('locationerror', onLocationError);

        // map.locate({setView: true, maxZoom: 16});
    </script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>