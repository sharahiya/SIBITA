@extends('layouts.layoutadmin')

@section('content')
<div class="container mx-auto px-4 pt-4 max-w-5xl">
    
    <!-- Header -->
    <div class="bg-white p-6 shadow-md rounded-lg w-full mx-auto">
        <h1 class="text-base font-semibold text-gray-800">Edit Akun</h1>
        <p class="text-gray-600 text-sm">Ubah informasi akun mahasiswa atau dosen</p>
    </div>

    <!-- Form Edit Akun -->
    <div class="bg-white p-6 shadow-md rounded-lg mt-4 mx-auto">
        <h2 class="text-sm font-semibold text-gray-800 mb-3">Edit Data Akun</h2>
        <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4" id="formEditAkun">
            @csrf
            <input type="text" name="nama" value="Fauzan Ramadhan" placeholder="Nama Lengkap" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500">
            <input type="text" name="id" value="2108107010021" placeholder="NPM / NIDN" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500" id="field-id">
            <input type="email" name="email" value="fauzan@email.com" placeholder="Email" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500">
            
            <select name="jenis_akun" id="jenis_akun" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="mahasiswa" selected>Mahasiswa</option>
                <option value="dosen">Dosen</option>
            </select>

            <!-- Field Mahasiswa -->
            <input type="text" name="angkatan" value="2021" placeholder="Angkatan" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 mahasiswa-field">
            <input type="text" name="nip_dosenwali" value="198706152022031001" placeholder="NIP Dosen Wali" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 mahasiswa-field">

            <!-- Field Dosen -->
            <input type="text" name="jabatan" value="Kaprodi" placeholder="Jabatan" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 dosen-field hidden">

            <button type="submit" class="col-span-1 md:col-span-3 bg-blue-500 text-white p-2 text-xs rounded-lg hover:bg-blue-600 transition mt-4">Update Akun</button>
        </form>

        <!-- Tombol Kembali -->
        <div class="mt-4 text-left">
            <a href="{{ route('manajemenakun') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-full shadow hover:bg-gray-200 transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>
    </div>
</div>

<!-- Script Toggle Form -->
<script>
    function toggleFormFields() {
        const jenisAkun = document.getElementById('jenis_akun').value;
        const mhsFields = document.querySelectorAll('.mahasiswa-field');
        const dosenFields = document.querySelectorAll('.dosen-field');

        if (jenisAkun === 'mahasiswa') {
            mhsFields.forEach(field => field.classList.remove('hidden'));
            dosenFields.forEach(field => field.classList.add('hidden'));
            document.getElementById('field-id').placeholder = "NPM";
        } else {
            mhsFields.forEach(field => field.classList.add('hidden'));
            dosenFields.forEach(field => field.classList.remove('hidden'));
            document.getElementById('field-id').placeholder = "NIDN";
        }
    }

    document.getElementById('jenis_akun').addEventListener('change', toggleFormFields);
    document.addEventListener('DOMContentLoaded', toggleFormFields);
</script>
@endsection
