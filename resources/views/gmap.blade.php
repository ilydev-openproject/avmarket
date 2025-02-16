<!DOCTYPE html>
<html>

<head>
    <title>Pengukur Luas Sawah</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-draw/dist/leaflet.draw.css" />
    <style>
        #map {
            height: 600px;
        }

        #results {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div id="map"></div>
    <div id="results">
        <p>Luas: <span id="area">0</span> hektar</p>
        <p>Perkiraan hasil padi: <span id="yield">0</span> ton</p>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-draw/dist/leaflet.draw.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-6.962855, 110.827889], 15);

        // Tambahkan layer peta satelit
        L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 40,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);

        // Layer untuk menyimpan poligon yang digambar
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        // Inisialisasi kontrol gambar
        var drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems
            },
            draw: {
                polygon: {
                    allowIntersection: false, // Tidak memperbolehkan poligon bersinggungan
                    showArea: true, // Menampilkan luas area
                    shapeOptions: {
                        color: '#3388ff' // Warna garis poligon
                    }
                },
                rectangle: false, // Nonaktifkan gambar persegi panjang
                circle: false, // Nonaktifkan gambar lingkaran
                marker: false // Nonaktifkan gambar marker
            }
        });
        map.addControl(drawControl);

        // Event saat poligon selesai digambar
        map.on(L.Draw.Event.CREATED, function(event) {
            var layer = event.layer;
            drawnItems.addLayer(layer);
            calculateArea(layer);
        });

        // Fungsi untuk menghitung luas poligon
        function calculateArea(layer) {
            var latlngs = layer.getLatLngs()[0]; // Ambil koordinat poligon

            // Pastikan titik terakhir sama dengan titik pertama
            if (latlngs.length > 0 && !latlngs[0].equals(latlngs[latlngs.length - 1])) {
                latlngs.push(latlngs[0]); // Tambahkan titik pertama ke akhir array
            }

            // Hitung luas dalam meter persegi
            var area = L.GeometryUtil.geodesicArea(latlngs);

            // Konversi ke hektar (1 hektar = 10.000 meter persegi)
            var areaInHectares = (area / 10000).toFixed(2);

            // Tampilkan luas di hasil
            document.getElementById('area').innerText = areaInHectares;

            // Hitung perkiraan hasil padi
            estimateRiceYield(areaInHectares);
        }

        // Fungsi untuk menghitung perkiraan hasil padi
        function estimateRiceYield(areaInHectares) {
            var yieldPerHectare = 5; // Hasil padi per hektar (dalam ton)
            var totalYield = areaInHectares * yieldPerHectare;
            document.getElementById('yield').innerText = totalYield.toFixed(2);
        }
    </script>
</body>

</html>