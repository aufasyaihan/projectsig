@extends('admin.layouts.CentrePoint')

{{-- @section('header') --}}
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Geographics Information System') }}
        </h2>
    </x-slot> --}}
{{-- @endsection --}}

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
                    Map
                    <hr class="my-3">
                    <div id="map"></div>
                </div>
            </div>
            <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 text-xl dark:text-gray-100">
                    <div class="grid grid-cols-4">
                        <div class="p-2">
                            Spot
                        </div>
                        <div class="col-end-6 bg-blue-500 p-2 rounded-lg hover:bg-blue-700">
                            <a href="{{ route('spot.create') }}">Create Spot</a>
                        </div>
                    </div>
                    <hr class="my-3">
                    <div class="container m-auto">
                        <table class="w-full table-auto text-center border-collapse border" id="dataCenterPoint">
                            <thead class="dark:bg-slate-700 border">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Spot</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data))
                                <?php $i = $data->firstItem(); ?>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <div class="container flex p-2 w-3/4 mx-auto">
                                                <div class="m-auto p-2">
                                                    <a class="fa-solid fa-pen text-white bg-orange-600 p-2 rounded-lg"
                                                        href="{{ url('spot/' . $item->id . '/edit') }}"></a>
                                                </div>
                                                <div class="mx-auto p-2">
                                                    <form class="m-auto"
                                                        onsubmit="return confirm('Yakin akan menghapus data?')"
                                                        action="{{ url('spot/' . $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="m-auto fa-solid fa-trash bg-red-600 p-2 text-white rounded-lg"
                                                            type="submit" name="submit"></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {!! $data->withQueryString()->links() !!}
                            @endif
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
            center: [-7.425811139495525, 109.33744355626365],
            zoom: 16,
            layers: [osm]
        });

        var baseMaps = {
            'Open Street Map': osm,
            'Stadia Dark': Stadia_Dark,
            'Jawg_Terrain': Jawg_Terrain
        }
        @if(isset($point))
        @foreach ($point as $item)
            var marker = L.marker([{{ $item->coordinates }}], {
                draggable: true
            }).addTo(map);
            marker.bindPopup("<b>{{ $item->name}}</b> <hr>Description : <br> {{ $item->description}} <br> <img src='{{ asset('upload/spots/' . $item->images) }}' alt='Tempat' width=500>");
        @endforeach
        @endif
        // marker.bindPopup("<center><b>Kontrakan</b><br>IF 21</center>").openPopup();
        L.control.layers(baseMaps).addTo(map);
    </script>
@endsection
