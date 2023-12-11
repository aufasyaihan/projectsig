@extends('layouts.CentrePoint')
@section('header')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Geographics Information System') }}
        </h2>
    </x-slot>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 text-xl dark:text-gray-100">
                    <div class="grid grid-cols-2">
                        <div class="p-2">
                            Update Spot - {{ $spot->name }}
                        </div>
                        <div class="col-end-6 bg-red-500 p-2 rounded-lg hover:bg-red-700">
                            <a href="{{ route('spot.index') }}">Back</a>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="container m-auto flex">
                        <div class="p-4 text-gray-900 text-xl dark:text-gray-100 w-1/2">
                            Map
                            <hr class="my-3">
                            <div class="rounded-lg" id="map"></div>
                        </div>
                        <div class="w-1/2 p-4 mt-8">
                            <form action="{{ route('spot.update', $spot->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-6">
                                    <label for="koordinat"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Koordinat</label>
                                    <input type="text" id="koordinat" name="coordinate"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required value="{{ $spot->coordinates }}">
                                </div>
                                <div class="mb-6">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Spot</label>
                                    <input type="text" id="name" name="name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required value="{{ $spot->name }}">
                                </div>
                                <div class="mb-6">
                                    <label for="deskripsi"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                                    <textarea type="text" id="description" name="description"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>{{ $spot->description }}</textarea>
                                </div>
                                <div class="mb-6">
                                    <label for="images"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar</label>
                                    <div class="flex">
                                        <img class="mx-3 rounded" src='{{ asset('upload/spots/' . $spot->images) }}' alt='Spot Image' width='100px'>
                                        <input type="file" id="images" name="images"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <input type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            </form>
                        </div>

                    </div>
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
            center: [{{ $spot->coordinates }}],
            zoom: 16,
            layers: [osm]
        });

        var baseMaps = {
            'Open Street Map': osm,
            'Stadia Dark': Stadia_Dark,
            'Jawg_Terrain': Jawg_Terrain
        }
        var marker = L.marker([{{ $spot->coordinates }}], {
            draggable: true
        }).addTo(map);
        // marker.bindPopup("<center><b>Kontrakan</b><br>IF 21</center>").openPopup();
        L.control.layers(baseMaps).addTo(map);

        function onMapClick(e) {
            var coords = document.querySelector("[name=coordinate]")
            var latitude = document.querySelector("[name=latitude]")
            var longtitude = document.querySelector("[name=longtitude]")
            var lat = e.latlng.lat
            var lng = e.latlng.lng

            if (!marker) {
                marker = L.marker(e.latlng).addTo(map)
            } else {
                marker.setLatLng(e.latlng)
            }

            coords.value = lat + ", " + lng
            latitude.value = lat
            longtitude.value = lng
        }
        map.on('click', onMapClick)

        marker.on('dragend', function() {
            var coordinate = marker.getLatlng
        })
    </script>
@endsection
