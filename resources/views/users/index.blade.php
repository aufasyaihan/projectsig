@extends('layouts.CentrePoint')

{{-- @section('header') --}}
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Geographics Information System') }}
        </h2>
    </x-slot> --}}
{{-- @endsection --}}
<style>
    .leaflet-popup-content a.popup-link {
        text-decoration: none !important;
        color: white !important;
        background-color: #3490dc !important; 
        padding: 8px 16px; 
        border-radius: 4px; 
        display: inline-block;
    }
    .leaflet-popup-content img.popup-image {
        width: 5000px; 
        max-width: 100%; 
        height: auto; 
        display: block;
        margin: 0 auto;
    }
</style>
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-500 w-full text-gray-100 p-4 m-4 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-600 w-full text-gray-100 rounded">
                    {{ session('error') }}
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 text-xl dark:text-gray-100">
                    Map Ikan
                    <hr class="my-3">
                    <div id="map"></div>
                </div>
            </div>
        </div>
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
            zoom: 13,
            layers: [osm]
        });

        var baseMaps = {
            'Open Street Map': osm,
            'Stadia Dark': Stadia_Dark,
            'Jawg_Terrain': Jawg_Terrain
        }
        @if(isset($data))
        @foreach ($data as $item)
            var marker = L.marker([{{ $item->coordinates }}], {
                draggable: true
            }).addTo(map);
            marker.bindPopup(
                "<b>{{ $item->name}}</b> <hr> <br> <img class='popup-image' src='{{ asset('upload/spots/' . $item->images) }}' alt='Tempat' width=500> <br>" + 
                "<a href='{{ route('spot.show', $item->id) }}' class='popup-link'> Show Details </a>"
            );
        @endforeach
        @endif
        // marker.bindPopup("<center><b>Kontrakan</b><br>IF 21</center>").openPopup();
        L.control.layers(baseMaps).addTo(map);
    </script>
@endsection
