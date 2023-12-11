<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        #map {
            height: 500px;
        }
    </style>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script>
        // const map = L.map('map').setView([-7.425811139495525, 109.33744355626365], 16);


        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

        var Stadia_Dark = L.tileLayer(
            'https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.{ext}', {
                minZoom: 0,
                maxZoom: 20,
                attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                ext: 'png'
            });
        var Jawg_Terrain = L.tileLayer(
            'https://{s}.tile.jawg.io/jawg-terrain/{z}/{x}/{y}{r}.png?access-token={accessToken}', {
                attribution: '<a href="http://jawg.io" title="Tiles Courtesy of Jawg Maps" target="_blank">&copy; <b>Jawg</b>Maps</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                minZoom: 0,
                maxZoom: 22,
                subdomains: 'abcd',
                accessToken: '<your accessToken>'
            });
        var map = L.map('map', {
            center: [-7.425811139495525, 109.33744355626365],
            zoom: 16,
            layers: [osm]
        });

        var baseMaps = {
            'Open Street Map': osm,
            'Stadia Dark': Stadia_Dark,
            'Jawg_Terrain': Jawg_Terrain
        }
        // @if(isset($point))
        @foreach ($data as $item)
            var marker = L.marker([{{ $item->coordinates }}], {
                draggable: true
            }).addTo(map);
            marker.bindPopup("<b>{{ $item->name}}</b> <hr>Description : <br> {{ $item->description}} <br> <img src='{{ asset('upload/spots/' . $item->images) }}' alt='Tempat' width=500>");
        @endforeach
        // @endif
        L.control.layers(baseMaps).addTo(map);

        function onMapClick(e) {
            var coords = document.querySelector("[name=coordinate]")
            var lat = e.latlng.lat
            var lng = e.latlng.lng

            if (!marker) {
                marker = L.marker(e.latlng).addTo(map)
            } else {
                marker.setLatLng(e.latlng)
            }

            coords.value = lat + ", " + lng
        }
        map.on('click', onMapClick)

        marker.on('dragend', function() {
            var coordinate = marker.getLatlng
        })
    </script>
</body>

</html>
