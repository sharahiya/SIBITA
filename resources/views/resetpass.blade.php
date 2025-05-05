@extends('layouts.layoutmhs')
@section('content')

<div class="container mx-auto px-4 pt-4">
    <div class="bg-white p-6 shadow-md rounded-lg w-full max-w-md mx-auto mt-10 animate-fadeIn">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">Reset Password</h2>
        <p class="text-sm text-gray-600 mb-4">Ganti kata sandi Anda di bawah ini.</p>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('dashboard') }}" method="POST" class="space-y-4">
            @csrf
            <!-- Ganti dengan input hidden jika token diperlukan -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Lama</label>
                <input type="password" id="current_password" name="current_password" required class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <input type="password" id="new_password" name="new_password" required class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-out;
    }
</style>
@endsection
