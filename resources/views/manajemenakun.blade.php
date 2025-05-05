@extends('layouts.layoutadmin')
@section('content')

<div class="container mx-auto px-4 pt-4 max-w-5xl">
    <!-- Header -->
    <div class="bg-white p-6 shadow-md rounded-lg w-full mx-auto">
        <h1 class="text-base font-semibold text-gray-800">Manajemen Akun</h1>
        <p class="text-gray-600 text-sm">Kelola akun mahasiswa dan dosen melalui upload CSV</p>
    </div>

    <!-- Tabs -->
    <div class="mt-4">
        <ul class="flex border-b text-xs font-medium text-gray-600">
            <li class="mr-4 cursor-pointer py-2 px-3 hover:text-blue-600 border-b-2" id="tab-mahasiswa-btn">Mahasiswa</li>
            <li class="cursor-pointer py-2 px-3 hover:text-blue-600" id="tab-dosen-btn">Dosen</li>
        </ul>
    </div>

    <!-- Mahasiswa Section -->
    <div class="bg-white p-6 shadow-md rounded-lg">
    <h2 class="text-sm font-semibold text-gray-800 mb-3">Upload CSV Mahasiswa</h2>
    <div class="flex items-center space-x-2">
        <input type="file" id="csvMahasiswa" accept=".csv" class="text-xs p-2 border rounded-lg w-full md:w-auto">
        <button id="saveMahasiswa" class="text-white bg-blue-600 hover:bg-blue-700 text-xs px-4 py-2 rounded-lg">Save</button>
    </div>
    <p class="text-xs text-gray-500 mt-2">Format: nama,npm,email,angkatan,nip_dosenwali</p>
</div>


        <div class="bg-white p-6 shadow-md rounded-lg mt-4">
            <input type="text" id="searchMahasiswa" placeholder="Cari mahasiswa..." class="w-full md:w-64 p-2 text-xs border rounded-lg mb-3">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-gray-500">
                    <thead class="text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">NPM</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Angkatan</th>
                            <th class="px-4 py-2">NIP Dosen Wali</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="mahasiswaTable"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Dosen Section -->
    <div id="tab-dosen" class="mt-4 hidden">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-sm font-semibold text-gray-800 mb-3">Upload CSV Dosen</h2>
            <input type="file" id="csvDosen" accept=".csv" class="text-xs p-2 border rounded-lg w-full md:w-auto">
            <p class="text-xs text-gray-500 mt-2">Format: nama,nip,email,jabatan</p>
            <button id="saveDosenBtn" class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg text-xs">Save</button> <!-- Button Save -->
        </div>

        <div class="bg-white p-6 shadow-md rounded-lg mt-4">
            <input type="text" id="searchDosen" placeholder="Cari dosen..." class="w-full md:w-64 p-2 text-xs border rounded-lg mb-3">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-gray-500">
                    <thead class="text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">NIP</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Jabatan</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dosenTable"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    const tabMahasiswaBtn = document.getElementById('tab-mahasiswa-btn');
    const tabDosenBtn = document.getElementById('tab-dosen-btn');
    const tabMahasiswa = document.getElementById('tab-mahasiswa');
    const tabDosen = document.getElementById('tab-dosen');

    // Tab switch
    tabMahasiswaBtn.addEventListener('click', () => {
        tabMahasiswa.classList.remove('hidden');
        tabDosen.classList.add('hidden');
        tabMahasiswaBtn.classList.add('border-blue-500', 'text-blue-600');
        tabDosenBtn.classList.remove('border-blue-500', 'text-blue-600');
    });

    tabDosenBtn.addEventListener('click', () => {
        tabDosen.classList.remove('hidden');
        tabMahasiswa.classList.add('hidden');
        tabDosenBtn.classList.add('border-blue-500', 'text-blue-600');
        tabMahasiswaBtn.classList.remove('border-blue-500', 'text-blue-600');
    });

    // CSV upload for Mahasiswa
    document.getElementById('csvMahasiswa').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (event) {
            const rows = event.target.result.trim().split('\n').map(row => row.split(','));
            const mahasiswaData = rows.slice(1).map(row => ({
                nama: row[0],
                npm: row[1],
                email: row[2],
                angkatan: row[3],
                nip_dosenwali: row[4]
            }));

            renderMahasiswaTable(mahasiswaData);
        };
        reader.readAsText(file);
    });

    function renderMahasiswaTable(data) {
        const keyword = document.getElementById('searchMahasiswa').value.toLowerCase();
        const table = document.getElementById('mahasiswaTable');
        table.innerHTML = '';
        data.forEach(m => {
            if (Object.values(m).some(v => v.toLowerCase().includes(keyword))) {
                table.innerHTML += `
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-4 py-2">${m.nama}</td>
                        <td class="px-4 py-2">${m.npm}</td>
                        <td class="px-4 py-2">${m.email}</td>
                        <td class="px-4 py-2">${m.angkatan}</td>
                        <td class="px-4 py-2">${m.nip_dosenwali}</td>
                        <td class="px-4 py-2">
                            <button class="text-yellow-500 hover:text-yellow-600 text-xs">Edit</button>
                            <button class="text-red-500 hover:text-red-600 text-xs">Hapus</button>
                        </td>
                    </tr>
                `;
            }
        });
    }

    document.getElementById('searchMahasiswa').addEventListener('keyup', function () {
        document.getElementById('csvMahasiswa').dispatchEvent(new Event('change'));
    });

    // CSV upload for Dosen
    document.getElementById('csvDosen').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (event) {
            const rows = event.target.result.trim().split('\n').map(row => row.split(','));
            const dosenData = rows.slice(1).map(row => ({
                nama: row[0],
                nip: row[1],
                email: row[2],
                jabatan: row[3]
            }));

            renderDosenTable(dosenData);
        };
        reader.readAsText(file);
    });

    function renderDosenTable(data) {
        const keyword = document.getElementById('searchDosen').value.toLowerCase();
        const table = document.getElementById('dosenTable');
        table.innerHTML = '';
        data.forEach(d => {
            if (Object.values(d).some(v => v.toLowerCase().includes(keyword))) {
                table.innerHTML += `
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-4 py-2">${d.nama}</td>
                        <td class="px-4 py-2">${d.nip}</td>
                        <td class="px-4 py-2">${d.email}</td>
                        <td class="px-4 py-2">${d.jabatan}</td>
                        <td class="px-4 py-2">
                            <button class="text-yellow-500 hover:text-yellow-600 text-xs">Edit</button>
                            <button class="text-red-500 hover:text-red-600 text-xs">Hapus</button>
                        </td>
                    </tr>
                `;
            }
        });
    }

    document.getElementById('searchDosen').addEventListener('keyup', function () {
        document.getElementById('csvDosen').dispatchEvent(new Event('change'));
    });

    // Save button functionality for Mahasiswa (You can adapt this to save the data to a backend or elsewhere)
    document.getElementById('saveMahasiswaBtn').addEventListener('click', function () {
        alert('Data Mahasiswa telah disimpan');
    });

    // Save button functionality for Dosen (You can adapt this to save the data to a backend or elsewhere)
    document.getElementById('saveDosenBtn').addEventListener('click', function () {
        alert('Data Dosen telah disimpan');
    });
</script>

@endsection
