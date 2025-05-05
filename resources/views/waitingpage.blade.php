@extends('layouts.layoutmhs')
@section('content')

    <style>
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="bg-white p-6 rounded-lg shadow-lg text-center max-w-2xl mx-auto">
        <h1 class="text-2xl font-semibold text-gray-700">Pengajuan Anda Sedang Diproses</h1>
        <p class="text-gray-600 mt-4">Harap menunggu, dosen akan segera meninjau pengajuan bimbingan Anda.</p>
        <div class="mt-6 flex justify-center">
            <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l4-4-4-4v4a8 8 0 00-8 8z"></path>
            </svg>
        </div>
        <a href="/" class="mt-6 inline-block px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Kembali ke Dashboard</a>
    </div>

@endsection
