@extends('layouts.CentrePoint')

{{-- @section('header') --}}
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Geographics Information System') }}
        </h2>
    </x-slot> --}}
{{-- @endsection --}}
@section('content')

    <div class="py-5">
        <div class="py-2 max-w-7xl mx-auto mb-3 sm:px-6 lg:px-8">
            <a href="{{ route('spot.index') }}" class="bg-red-500 hover:bg-red-600 px-4 py-2 font-semibold rounded">
                Back
            </a>
        </div>
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
                    Detail Data
                    <hr class="my-3">
                    <div>
                        <img class="mx-auto rounded" src='{{ asset('upload/spots/' . $spot->images) }}' alt='Spot Image' width='500px'>
                    </div>
                    <div class="mx-5">
                        Nama <hr>
                        <div class="my-3">
                            {{ $spot->name }}
                        </div>
                    </div>
                    <div class="mx-5">
                        Deskripsi <hr>
                        <div class="my-3">
                        {{ $spot->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
