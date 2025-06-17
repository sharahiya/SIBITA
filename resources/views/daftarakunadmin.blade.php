@extends('layouts.layoutadmin')

@section('content')

<div class="container mx-auto px-4 pt-4 max-w-5xl">
    <!-- Header -->
    <div class="bg-white p-6 shadow-md rounded-lg w-full mx-auto">
        <h1 class="text-base font-semibold text-gray-800">Daftar Mahasiswa & Dosen</h1>
        <p class="text-gray-600 text-sm">Lihat daftar mahasiswa dan dosen yang terdaftar di sistem</p>
    </div>

    <!-- Mahasiswa Section -->
    <div class="mt-4">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-sm font-semibold text-gray-800 mb-3">Daftar Mahasiswa ({{ $mahasiswas->count() }})</h2>

            <!-- Filters -->
            <div class="flex flex-col md:flex-row gap-3 mb-4">
                <input type="text" id="searchMahasiswa" placeholder="Cari mahasiswa..." class="p-2 text-xs border rounded-lg flex-1">

                <select id="filterAngkatan" class="p-2 text-xs border rounded-lg">
                    <option value="">Semua Angkatan</option>
                    <!-- Options will be populated by JavaScript -->
                </select>

                <button id="resetFilterMahasiswa" class="bg-gray-500 text-white px-3 py-2 text-xs rounded-lg hover:bg-gray-600 transition-colors">
                    Reset Filter
                </button>
            </div>

            <div class="overflow-x-auto max-h-56 overflow-y-scroll">
                <table class="w-full text-xs text-left text-gray-500">
                    <thead class="text-gray-700 uppercase bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">NPM</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Angkatan</th>
                            <th class="px-4 py-2">Dosen Wali</th>
                        </tr>
                    </thead>
                    <tbody id="mahasiswaTableBody">
                        @forelse ($mahasiswas as $index => $mahasiswa)
                        <tr class="bg-white border-b hover:bg-gray-50" data-angkatan="{{ $mahasiswa->angkatan }}">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $mahasiswa->nama }}</td>
                            <td class="px-4 py-2">{{ $mahasiswa->npm }}</td>
                            <td class="px-4 py-2">{{ $mahasiswa->email }}</td>
                            <td class="px-4 py-2">{{ $mahasiswa->angkatan }}</td>
                            <td class="px-4 py-2">{{ $mahasiswa->dosenWali->nama ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data mahasiswa
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- No results message -->
                <div id="noResultsMahasiswa" class="hidden text-center py-8 text-gray-500">
                    <p>Tidak ada mahasiswa yang sesuai dengan filter</p>
                </div>
            </div>

            <!-- Results counter -->
            <div class="mt-2 text-xs text-gray-600">
                Menampilkan <span id="countMahasiswa">{{ $mahasiswas->count() }}</span> dari {{ $mahasiswas->count() }} mahasiswa
            </div>
        </div>
    </div>

    <!-- Dosen Section -->
    <div class="mt-4">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-sm font-semibold text-gray-800 mb-3">Daftar Dosen ({{ $dosens->count() }})</h2>

            <!-- Filters for Dosen -->
            <div class="flex flex-col md:flex-row gap-3 mb-4">
                <input type="text" id="searchDosen" placeholder="Cari dosen..." class="p-2 text-xs border rounded-lg flex-1">

                <select id="filterBidang" class="p-2 text-xs border rounded-lg">
                    <option value="">Semua Bidang</option>
                    <!-- Options will be populated by JavaScript -->
                </select>

                <button id="resetFilterDosen" class="bg-gray-500 text-white px-3 py-2 text-xs rounded-lg hover:bg-gray-600 transition-colors">
                    Reset Filter
                </button>
            </div>

            <div class="overflow-x-auto max-h-56 overflow-y-scroll">
                <table class="w-full text-xs text-left text-gray-500">
                    <thead class="text-gray-700 uppercase bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">NIP</th>
                            <th class="px-4 py-2">Bidang</th>
                            <th class="px-4 py-2">Kuota Bimbingan</th>
                            <th class="px-4 py-2">Mahasiswa Wali</th>
                        </tr>
                    </thead>
                    <tbody id="dosenTableBody">
                        @forelse ($dosens as $index => $dosen)
                        <tr class="bg-white border-b hover:bg-gray-50" data-bidang="{{ $dosen->bidang }}">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $dosen->nama }}</td>
                            <td class="px-4 py-2">{{ $dosen->nip }}</td>
                            <td class="px-4 py-2">{{ $dosen->bidang ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <div class="flex items-center justify-center">
                                    <div
                                        class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-xs font-medium transition-colors duration-200 "
                                        >
                                        {{ $dosen->jumlahMahasiswaBimbingan() }} / {{ $dosen->kuota_bimbingan ?? 0 }}
                                    </div>
                                    <button
                                        class="ml-2 text-blue-500 hover:text-blue-600 p-1 transition-colors duration-200 edit-kuota-btn"
                                        title="Edit kuota"
                                        data-dosen-id="{{ $dosen->id_dosen }}"
                                        data-dosen-nama="{{ $dosen->nama }}"
                                        data-kuota-current="{{ $dosen->kuota_bimbingan ?? 0 }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                            <td class="px-4 py-2 flex justify-center">{{ $dosen->jumlahMahasiswaPerwalian() }}</td>
                            <td>
                                <button
                                        class="bg-blue-100 hover:bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-xs font-medium transition-colors duration-200 view-detail-btn"
                                        title="Lihat detail bimbingan"
                                        data-dosen-id="{{ $dosen->id_dosen }}">Detail</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Belum ada data dosen
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- No results message for dosen -->
                <div id="noResultsDosen" class="hidden text-center py-8 text-gray-500">
                    <p>Tidak ada dosen yang sesuai dengan filter</p>
                </div>
            </div>

            <!-- Results counter for dosen -->
            <div class="mt-2 text-xs text-gray-600">
                Menampilkan <span id="countDosen">{{ $dosens->count() }}</span> dari {{ $dosens->count() }} dosen
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Dosen -->
<div id="dosenDetailModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full p-3 mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Detail Dosen</h2>
            </div>
            <button id="closeDosenDetailModal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Loading State -->
        <div id="dosenDetailLoading" class="text-center py-8">
            <div class="inline-flex items-center">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mr-3"></div>
                <span class="text-gray-600">Memuat data...</span>
            </div>
        </div>

        <!-- Content -->
        <div id="dosenDetailContent" class="hidden">
            <!-- Informasi Dosen -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Dosen</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Nama:</span>
                        <p class="font-medium" id="detailNamaDosen">-</p>
                    </div>
                    <div>
                        <span class="text-gray-600">NIP:</span>
                        <p class="font-medium" id="detailNipDosen">-</p>
                    </div>
                    <div>
                        <span class="text-gray-600">Bidang:</span>
                        <p class="font-medium" id="detailBidangDosen">-</p>
                    </div>
                    <div>
                        <span class="text-gray-600">Kuota Bimbingan:</span>
                        <p class="font-medium" id="detailKuotaDosen">-</p>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg text-center">
                    <h4 class="text-sm font-medium text-blue-800">Mahasiswa Bimbingan Aktif</h4>
                    <p class="text-2xl font-bold text-blue-600" id="jumlahBimbinganAktif">0</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg text-center">
                    <h4 class="text-sm font-medium text-green-800">Mahasiswa Wali</h4>
                    <p class="text-2xl font-bold text-green-600" id="jumlahMahasiswaWali">0</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg text-center">
                    <h4 class="text-sm font-medium text-purple-800">Menjadi Penguji</h4>
                    <p class="text-2xl font-bold text-purple-600" id="jumlahPenguji">0</p>
                </div>
            </div>

            <!-- Tabs -->
            <div class="flex border-b mb-4">
                <button class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600" id="tabBimbingan">
                    Mahasiswa Bimbingan
                </button>
                <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800" id="tabWali">
                    Mahasiswa Wali
                </button>
            </div>

            <!-- Tab Content: Mahasiswa Bimbingan -->
            <div id="contentBimbingan" class="tab-content">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Mahasiswa Bimbingan</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-600">Menampilkan:</span>
                        <span class="text-xs font-medium text-blue-600" id="bimbinganResultCount">0</span>
                        <span class="text-xs text-gray-600">mahasiswa</span>
                    </div>
                </div>

                <!-- Filter for Mahasiswa Bimbingan -->
                <div class="flex flex-col md:flex-row gap-3 mb-4">
                    <input type="text" id="searchBimbingan" placeholder="Cari mahasiswa bimbingan..." class="p-2 text-xs border rounded-lg flex-1">

                    <select id="filterAngkatanBimbingan" class="p-2 text-xs border rounded-lg">
                        <option value="">Semua Angkatan</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>

                    <select id="filterDospenKe" class="p-2 text-xs border rounded-lg">
                        <option value="">Semua Dospem</option>
                        <option value="1">Dospem 1</option>
                        <option value="2">Dospem 2</option>
                    </select>

                    <select id="filterStatusBimbingan" class="p-2 text-xs border rounded-lg">
                        <option value="">Semua Status</option>
                        <option value="Bimbingan">Bimbingan</option>
                        <option value="Sempro">Sempro</option>
                        <option value="Semhas">Semhas</option>
                        <option value="Sidang">Sidang</option>
                    </select>

                    <button id="resetFilterBimbingan" class="bg-gray-500 text-white px-3 py-2 text-xs rounded-lg hover:bg-gray-600 transition-colors">
                        Reset Filter
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left text-gray-500">
                        <thead class="text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="px-3 py-2">No</th>
                                <th class="px-3 py-2">Nama</th>
                                <th class="px-3 py-2">NPM</th>
                                <th class="px-3 py-2">Angkatan</th>
                                <th class="px-3 py-2">Role</th>
                                <th class="px-3 py-2">Status</th>
                                <th class="px-3 py-2">Bidang</th>
                                <th class="px-3 py-2">Topik TA</th>
                            </tr>
                        </thead>
                        <tbody id="tableBimbinganBody">
                            <!-- Data will be inserted here -->
                        </tbody>
                    </table>

                    <!-- No results message for bimbingan -->
                    <div id="noResultsBimbingan" class="hidden text-center py-8 text-gray-500">
                        <p>Tidak ada mahasiswa bimbingan yang sesuai dengan filter</p>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Mahasiswa Wali -->
            <div id="contentWali" class="tab-content hidden">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Mahasiswa Wali</h3>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-600">Menampilkan:</span>
                        <span class="text-xs font-medium text-green-600" id="waliResultCount">0</span>
                        <span class="text-xs text-gray-600">mahasiswa</span>
                    </div>
                </div>

                <!-- Filter for Mahasiswa Wali -->
                <div class="flex flex-col md:flex-row gap-3 mb-4">
                    <input type="text" id="searchWali" placeholder="Cari mahasiswa wali..." class="p-2 text-xs border rounded-lg flex-1">

                    <select id="filterAngkatanWali" class="p-2 text-xs border rounded-lg">
                        <option value="">Semua Angkatan</option>
                        <!-- Options will be populated by JavaScript -->
                    </select>

                    <select id="filterStatusWali" class="p-2 text-xs border rounded-lg">
                        <option value="">Semua Status</option>
                        <option value="Bimbingan">Bimbingan</option>
                        <option value="Sempro">Sempro</option>
                        <option value="Semhas">Semhas</option>
                        <option value="Sidang">Sidang</option>
                    </select>

                    <button id="resetFilterWali" class="bg-gray-500 text-white px-3 py-2 text-xs rounded-lg hover:bg-gray-600 transition-colors">
                        Reset Filter
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left text-gray-500">
                        <thead class="text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="px-3 py-2">No</th>
                                <th class="px-3 py-2">Nama</th>
                                <th class="px-3 py-2">NPM</th>
                                <th class="px-3 py-2">Angkatan</th>
                                <th class="px-3 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody id="tableWaliBody">
                            <!-- Data will be inserted here -->
                        </tbody>
                    </table>

                    <!-- No results message for wali -->
                    <div id="noResultsWali" class="hidden text-center py-8 text-gray-500">
                        <p>Tidak ada mahasiswa wali yang sesuai dengan filter</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Kuota -->
<div id="editKuotaModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full p-3 mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Edit Kuota Bimbingan</h2>
            </div>
            <button id="closeEditKuotaModal" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="mb-4">
            <p class="text-gray-600 text-sm">Ubah kuota bimbingan untuk:</p>
            <p class="font-medium text-gray-800" id="dosenNameDisplay"></p>
        </div>

        <form id="editKuotaForm">
            @csrf
            <input type="hidden" id="dosenId" name="dosen_id">

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kuota Bimbingan</label>
                <input
                    type="number"
                    id="kuotaBimbingan"
                    name="kuota_bimbingan"
                    min="0"
                    max="50"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan kuota bimbingan">
                <p class="text-xs text-gray-500 mt-1">Kuota maksimal: 50 mahasiswa</p>
            </div>

            <!-- Error Messages -->
            <div id="kuotaErrorMessages" class="hidden mb-4 p-3 bg-red-100 border border-red-300 rounded-md">
                <ul class="text-sm text-red-600 list-disc list-inside"></ul>
            </div>

            <!-- Success Messages -->
            <div id="kuotaSuccessMessage" class="hidden mb-4 p-3 bg-green-100 border border-green-300 rounded-md">
                <p class="text-sm text-green-600"></p>
            </div>

            <!-- Loading -->
            <div id="kuotaLoading" class="hidden mb-4 text-center">
                <div class="inline-flex items-center">
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600 mr-2"></div>
                    <span class="text-sm text-gray-600">Menyimpan kuota...</span>
                </div>
            </div>

            <div class="flex space-x-3">
                <button type="button" id="cancelEditKuota" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // Global variables to store data for modal filtering
    let originalBimbinganData = [];
    let originalWaliData = [];

    // === Populate Filter Options ===
    function populateFilterOptions() {
        // Populate Angkatan filter for Mahasiswa
        const angkatanSet = new Set();
        const mahasiswaRows = document.querySelectorAll('#mahasiswaTableBody tr[data-angkatan]');
        mahasiswaRows.forEach(row => {
            const angkatan = row.getAttribute('data-angkatan');
            if (angkatan && angkatan !== 'null') {
                angkatanSet.add(angkatan);
            }
        });

        const filterAngkatan = document.getElementById('filterAngkatan');
        const sortedAngkatan = Array.from(angkatanSet).sort();
        sortedAngkatan.forEach(angkatan => {
            const option = document.createElement('option');
            option.value = angkatan;
            option.textContent = angkatan;
            filterAngkatan.appendChild(option);
        });

        // Populate Bidang filter for Dosen
        const bidangSet = new Set();
        const dosenRows = document.querySelectorAll('#dosenTableBody tr[data-bidang]');
        dosenRows.forEach(row => {
            const bidang = row.getAttribute('data-bidang');
            if (bidang && bidang !== 'null' && bidang !== '-') {
                bidangSet.add(bidang);
            }
        });

        const filterBidang = document.getElementById('filterBidang');
        const sortedBidang = Array.from(bidangSet).sort();
        sortedBidang.forEach(bidang => {
            const option = document.createElement('option');
            option.value = bidang;
            option.textContent = bidang;
            filterBidang.appendChild(option);
        });
    }

    // Populate modal filter options
    function populateModalFilterOptions(bimbinganData, waliData) {
        // Populate Angkatan filter for Bimbingan
        const angkatanBimbinganSet = new Set();
        bimbinganData.forEach(mahasiswa => {
            if (mahasiswa.angkatan) {
                angkatanBimbinganSet.add(mahasiswa.angkatan);
            }
        });

        const filterAngkatanBimbingan = document.getElementById('filterAngkatanBimbingan');
        filterAngkatanBimbingan.innerHTML = '<option value="">Semua Angkatan</option>';
        const sortedAngkatanBimbingan = Array.from(angkatanBimbinganSet).sort();
        sortedAngkatanBimbingan.forEach(angkatan => {
            const option = document.createElement('option');
            option.value = angkatan;
            option.textContent = angkatan;
            filterAngkatanBimbingan.appendChild(option);
        });

        // Populate Angkatan filter for Wali
        const angkatanWaliSet = new Set();
        waliData.forEach(mahasiswa => {
            if (mahasiswa.angkatan) {
                angkatanWaliSet.add(mahasiswa.angkatan);
            }
        });

        const filterAngkatanWali = document.getElementById('filterAngkatanWali');
        filterAngkatanWali.innerHTML = '<option value="">Semua Angkatan</option>';
        const sortedAngkatanWali = Array.from(angkatanWaliSet).sort();
        sortedAngkatanWali.forEach(angkatan => {
            const option = document.createElement('option');
            option.value = angkatan;
            option.textContent = angkatan;
            filterAngkatanWali.appendChild(option);
        });
    }

    // Call the function to populate options
    populateFilterOptions();

    // === Filter Functions ===
    function filterMahasiswa() {
        const searchTerm = document.getElementById('searchMahasiswa').value.toLowerCase();
        const selectedAngkatan = document.getElementById('filterAngkatan').value;
        const rows = document.querySelectorAll('#mahasiswaTableBody tr');
        let visibleCount = 0;
        let totalDataRows = 0;

        rows.forEach(row => {
            // Skip empty state row
            if (row.cells.length < 6) return;

            totalDataRows++;

            const nama = row.cells[1].textContent.toLowerCase();
            const npm = row.cells[2].textContent.toLowerCase();
            const email = row.cells[3].textContent.toLowerCase();
            const angkatan = row.getAttribute('data-angkatan');

            const matchesSearch = nama.includes(searchTerm) || npm.includes(searchTerm) || email.includes(searchTerm);
            const matchesAngkatan = !selectedAngkatan || angkatan === selectedAngkatan;

            if (matchesSearch && matchesAngkatan) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update counter and show/hide no results message
        document.getElementById('countMahasiswa').textContent = visibleCount;
        const noResultsDiv = document.getElementById('noResultsMahasiswa');
        if (visibleCount === 0 && totalDataRows > 0) {
            noResultsDiv.classList.remove('hidden');
        } else {
            noResultsDiv.classList.add('hidden');
        }
    }

    function filterDosen() {
        const searchTerm = document.getElementById('searchDosen').value.toLowerCase();
        const selectedBidang = document.getElementById('filterBidang').value;
        const rows = document.querySelectorAll('#dosenTableBody tr');
        let visibleCount = 0;
        let totalDataRows = 0;

        rows.forEach(row => {
            // Skip empty state row
            if (row.cells.length < 6) return;

            totalDataRows++;

            const nama = row.cells[1].textContent.toLowerCase();
            const nip = row.cells[2].textContent.toLowerCase();
            const bidangText = row.cells[3].textContent.toLowerCase();
            const bidang = row.getAttribute('data-bidang') || '';

            const matchesSearch = nama.includes(searchTerm) || nip.includes(searchTerm) || bidangText.includes(searchTerm);
            const matchesBidang = !selectedBidang || bidang === selectedBidang;

            if (matchesSearch && matchesBidang) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update counter and show/hide no results message
        document.getElementById('countDosen').textContent = visibleCount;
        const noResultsDiv = document.getElementById('noResultsDosen');
        if (visibleCount === 0 && totalDataRows > 0) {
            noResultsDiv.classList.remove('hidden');
        } else {
            noResultsDiv.classList.add('hidden');
        }
    }

    // === Modal Filter Functions ===
    function filterBimbingan() {
        const searchTerm = document.getElementById('searchBimbingan').value.toLowerCase();
        const selectedAngkatan = document.getElementById('filterAngkatanBimbingan').value;
        const selectedDospen = document.getElementById('filterDospenKe').value;
        const selectedStatus = document.getElementById('filterStatusBimbingan').value;

        const filteredData = originalBimbinganData.filter(mahasiswa => {
            const matchesSearch = mahasiswa.nama.toLowerCase().includes(searchTerm) ||
                                mahasiswa.npm.toLowerCase().includes(searchTerm) ||
                                (mahasiswa.topik_ta && mahasiswa.topik_ta.toLowerCase().includes(searchTerm));
            const matchesAngkatan = !selectedAngkatan || mahasiswa.angkatan === selectedAngkatan;
            const matchesDospen = !selectedDospen || mahasiswa.dosen_ke.toString() === selectedDospen;
            const matchesStatus = !selectedStatus || mahasiswa.seminar_status === selectedStatus;

            return matchesSearch && matchesAngkatan && matchesDospen && matchesStatus;
        });

        renderBimbinganTable(filteredData);
        document.getElementById('bimbinganResultCount').textContent = filteredData.length;

        // Show/hide no results message
        const noResultsDiv = document.getElementById('noResultsBimbingan');
        if (filteredData.length === 0 && originalBimbinganData.length > 0) {
            noResultsDiv.classList.remove('hidden');
        } else {
            noResultsDiv.classList.add('hidden');
        }
    }

    function filterWali() {
        const searchTerm = document.getElementById('searchWali').value.toLowerCase();
        const selectedAngkatan = document.getElementById('filterAngkatanWali').value;
        const selectedStatus = document.getElementById('filterStatusWali').value;

        const filteredData = originalWaliData.filter(mahasiswa => {
            const matchesSearch = mahasiswa.nama.toLowerCase().includes(searchTerm) ||
                                mahasiswa.npm.toLowerCase().includes(searchTerm);
            const matchesAngkatan = !selectedAngkatan || mahasiswa.angkatan === selectedAngkatan;
            const matchesStatus = !selectedStatus || mahasiswa.seminar_status === selectedStatus;

            return matchesSearch && matchesAngkatan && matchesStatus;
        });

        renderWaliTable(filteredData);
        document.getElementById('waliResultCount').textContent = filteredData.length;

        // Show/hide no results message
        const noResultsDiv = document.getElementById('noResultsWali');
        if (filteredData.length === 0 && originalWaliData.length > 0) {
            noResultsDiv.classList.remove('hidden');
        } else {
            noResultsDiv.classList.add('hidden');
        }
    }

    // === Render Table Functions ===
    function renderBimbinganTable(data) {
        const tableBimbinganBody = document.getElementById('tableBimbinganBody');
        tableBimbinganBody.innerHTML = '';

        if (data.length > 0) {
            data.forEach((mahasiswa, index) => {
                // Truncate long titles for display
                const topikTA = mahasiswa.topik_ta || '';
                const truncatedTopik = topikTA.length > 50 ? topikTA.substring(0, 47) + '...' : topikTA;

                const row = `
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-3 py-2">${index + 1}</td>
                        <td class="px-3 py-2">${mahasiswa.nama}</td>
                        <td class="px-3 py-2">${mahasiswa.npm}</td>
                        <td class="px-3 py-2">${mahasiswa.angkatan}</td>
                        <td class="px-3 py-2">Dospem ${mahasiswa.dosen_ke}</td>
                        <td class="px-3 py-2">${mahasiswa.status}</td>
                        <td class="px-3 py-2">${mahasiswa.bidang}</td>
                        <td class="px-3 py-2 relative">
                            <div class="topik-ta-container max-w-xs">
                                <span class="topik-ta-text cursor-help"
                                      data-full-text="${topikTA.replace(/"/g, '&quot;')}"
                                      title="${topikTA.replace(/"/g, '&quot;')}">${truncatedTopik}</span>
                                ${topikTA.length > 50 ? '<button class="ml-1 text-blue-500 hover:text-blue-700 text-xs expand-btn" onclick="toggleFullText(this)">Lihat</button>' : ''}
                            </div>
                        </td>
                    </tr>
                `;
                tableBimbinganBody.insertAdjacentHTML('beforeend', row);
            });
        }
    }

    function renderWaliTable(data) {
        const tableWaliBody = document.getElementById('tableWaliBody');
        tableWaliBody.innerHTML = '';

        if (data.length > 0) {
            data.forEach((mahasiswa, index) => {
                const row = `
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-3 py-2">${index + 1}</td>
                        <td class="px-3 py-2">${mahasiswa.nama}</td>
                        <td class="px-3 py-2">${mahasiswa.npm}</td>
                        <td class="px-3 py-2">${mahasiswa.angkatan}</td>
                        <td class="px-3 py-2">${mahasiswa.status}</td>
                    </tr>
                `;
                tableWaliBody.insertAdjacentHTML('beforeend', row);
            });
        }
    }

    // === Filter Event Listeners ===
    document.getElementById('searchMahasiswa').addEventListener('keyup', filterMahasiswa);
    document.getElementById('filterAngkatan').addEventListener('change', filterMahasiswa);

    document.getElementById('searchDosen').addEventListener('keyup', filterDosen);
    document.getElementById('filterBidang').addEventListener('change', filterDosen);

    // Modal filter event listeners
    document.getElementById('searchBimbingan').addEventListener('keyup', filterBimbingan);
    document.getElementById('filterAngkatanBimbingan').addEventListener('change', filterBimbingan);
    document.getElementById('filterDospenKe').addEventListener('change', filterBimbingan);
    document.getElementById('filterStatusBimbingan').addEventListener('change', filterBimbingan);

    document.getElementById('searchWali').addEventListener('keyup', filterWali);
    document.getElementById('filterAngkatanWali').addEventListener('change', filterWali);
    document.getElementById('filterStatusWali').addEventListener('change', filterWali);

    // Reset filter buttons
    document.getElementById('resetFilterMahasiswa').addEventListener('click', function() {
        document.getElementById('searchMahasiswa').value = '';
        document.getElementById('filterAngkatan').value = '';
        filterMahasiswa();
    });

    document.getElementById('resetFilterDosen').addEventListener('click', function() {
        document.getElementById('searchDosen').value = '';
        document.getElementById('filterBidang').value = '';
        filterDosen();
    });

    document.getElementById('resetFilterBimbingan').addEventListener('click', function() {
        document.getElementById('searchBimbingan').value = '';
        document.getElementById('filterAngkatanBimbingan').value = '';
        document.getElementById('filterDospenKe').value = '';
        document.getElementById('filterStatusBimbingan').value = '';
        filterBimbingan();
    });

    document.getElementById('resetFilterWali').addEventListener('click', function() {
        document.getElementById('searchWali').value = '';
        document.getElementById('filterAngkatanWali').value = '';
        document.getElementById('filterStatusWali').value = '';
        filterWali();
    });

    // === Detail Dosen Modal ===
    const dosenDetailModal = document.getElementById('dosenDetailModal');
    const viewDetailBtns = document.querySelectorAll('.view-detail-btn');
    const closeDosenDetailModal = document.getElementById('closeDosenDetailModal');
    const dosenDetailLoading = document.getElementById('dosenDetailLoading');
    const dosenDetailContent = document.getElementById('dosenDetailContent');

    // Tab functionality
    const tabBimbingan = document.getElementById('tabBimbingan');
    const tabWali = document.getElementById('tabWali');
    const contentBimbingan = document.getElementById('contentBimbingan');
    const contentWali = document.getElementById('contentWali');

    function showTab(tabName) {
        // Reset all tabs
        [tabBimbingan, tabWali].forEach(tab => {
            tab.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
            tab.classList.add('text-gray-600', 'hover:text-gray-800');
        });

        // Hide all content
        [contentBimbingan, contentWali].forEach(content => {
            content.classList.add('hidden');
        });

        // Show selected tab
        if (tabName === 'bimbingan') {
            tabBimbingan.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
            tabBimbingan.classList.remove('text-gray-600', 'hover:text-gray-800');
            contentBimbingan.classList.remove('hidden');
        } else if (tabName === 'wali') {
            tabWali.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
            tabWali.classList.remove('text-gray-600', 'hover:text-gray-800');
            contentWali.classList.remove('hidden');
        }
    }

    tabBimbingan.addEventListener('click', () => showTab('bimbingan'));
    tabWali.addEventListener('click', () => showTab('wali'));

    // Open detail modal
    viewDetailBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const dosenId = this.getAttribute('data-dosen-id');
            openDosenDetailModal(dosenId);
        });
    });

    function openDosenDetailModal(dosenId) {
        dosenDetailModal.classList.remove('hidden');
        dosenDetailLoading.classList.remove('hidden');
        dosenDetailContent.classList.add('hidden');

        // Reset to first tab
        showTab('bimbingan');

        // Reset filters
        document.getElementById('searchBimbingan').value = '';
        document.getElementById('filterAngkatanBimbingan').value = '';
        document.getElementById('filterDospenKe').value = '';
        document.getElementById('filterStatusBimbingan').value = '';
        document.getElementById('searchWali').value = '';
        document.getElementById('filterAngkatanWali').value = '';
        document.getElementById('filterStatusWali').value = '';

        // Fetch data
        fetch(`/admin/dosen/${dosenId}/detail`)
            .then(response => response.json())
            .then(data => {
                dosenDetailLoading.classList.add('hidden');

                if (data.success) {
                    populateDosenDetail(data.data);
                    dosenDetailContent.classList.remove('hidden');
                } else {
                    alert('Terjadi kesalahan saat memuat data');
                    dosenDetailModal.classList.add('hidden');
                }
            })
            .catch(error => {
                dosenDetailLoading.classList.add('hidden');
                console.error('Error:', error);
                alert('Terjadi kesalahan sistem');
                dosenDetailModal.classList.add('hidden');
            });
    }

    function populateDosenDetail(data) {
        // Store original data for filtering
        originalBimbinganData = data.mahasiswa_bimbingan;
        originalWaliData = data.mahasiswa_wali;

        // Populate dosen info
        document.getElementById('detailNamaDosen').textContent = data.dosen.nama;
        document.getElementById('detailNipDosen').textContent = data.dosen.nip;
        document.getElementById('detailBidangDosen').textContent = data.dosen.bidang || '-';
        document.getElementById('detailKuotaDosen').textContent = data.dosen.kuota_bimbingan;

        // Populate statistics
        document.getElementById('jumlahBimbinganAktif').textContent = data.dosen.jumlah_bimbingan_aktif;
        document.getElementById('jumlahMahasiswaWali').textContent = data.dosen.jumlah_mahasiswa_wali;
        document.getElementById('jumlahPenguji').textContent = data.dosen.jumlah_penguji;

        // Populate filter options in modal
        populateModalFilterOptions(data.mahasiswa_bimbingan, data.mahasiswa_wali);

        // Render initial tables
        renderBimbinganTable(data.mahasiswa_bimbingan);
        renderWaliTable(data.mahasiswa_wali);

        // Update result counters
        document.getElementById('bimbinganResultCount').textContent = data.mahasiswa_bimbingan.length;
        document.getElementById('waliResultCount').textContent = data.mahasiswa_wali.length;

        // Show/hide empty state messages
        const noResultsBimbingan = document.getElementById('noResultsBimbingan');
        const noResultsWali = document.getElementById('noResultsWali');

        if (data.mahasiswa_bimbingan.length === 0) {
            const tableBimbinganBody = document.getElementById('tableBimbinganBody');
            tableBimbinganBody.innerHTML = `
                <tr>
                    <td colspan="8" class="px-3 py-8 text-center text-gray-500">
                        Belum ada mahasiswa bimbingan
                    </td>
                </tr>
            `;
        }

        if (data.mahasiswa_wali.length === 0) {
            const tableWaliBody = document.getElementById('tableWaliBody');
            tableWaliBody.innerHTML = `
                <tr>
                    <td colspan="4" class="px-3 py-8 text-center text-gray-500">
                        Belum ada mahasiswa wali
                    </td>
                </tr>
            `;
        }

        noResultsBimbingan.classList.add('hidden');
        noResultsWali.classList.add('hidden');
    }

    // Close detail modal
    closeDosenDetailModal.addEventListener('click', function() {
        dosenDetailModal.classList.add('hidden');
    });

    // Close modal when clicking outside
    dosenDetailModal.addEventListener('click', function(e) {
        if (e.target === dosenDetailModal) {
            dosenDetailModal.classList.add('hidden');
        }
    });

    // === Edit Kuota Modal ===
    const editKuotaModal = document.getElementById('editKuotaModal');
    const editKuotaBtns = document.querySelectorAll('.edit-kuota-btn');
    const closeEditKuotaModal = document.getElementById('closeEditKuotaModal');
    const cancelEditKuota = document.getElementById('cancelEditKuota');
    const editKuotaForm = document.getElementById('editKuotaForm');
    const kuotaErrorDiv = document.getElementById('kuotaErrorMessages');
    const kuotaSuccessDiv = document.getElementById('kuotaSuccessMessage');
    const kuotaLoading = document.getElementById('kuotaLoading');

    // Edit Kuota Modal Functions
    function openEditKuotaModal(dosenId, dosenNama, currentKuota) {
        document.getElementById('dosenId').value = dosenId;
        document.getElementById('dosenNameDisplay').textContent = dosenNama;
        document.getElementById('kuotaBimbingan').value = currentKuota;

        editKuotaModal.classList.remove('hidden');

        // Reset form
        kuotaErrorDiv.classList.add('hidden');
        kuotaSuccessDiv.classList.add('hidden');
    }

    function closeEditKuotaModalFunc() {
        editKuotaModal.classList.add('hidden');
    }

    function showKuotaErrors(message) {
        const errorList = kuotaErrorDiv.querySelector('ul');
        errorList.innerHTML = `<li>${message}</li>`;
        kuotaErrorDiv.classList.remove('hidden');
        kuotaSuccessDiv.classList.add('hidden');
    }

    function showKuotaSuccess(message) {
        const successP = kuotaSuccessDiv.querySelector('p');
        successP.textContent = message;
        kuotaSuccessDiv.classList.remove('hidden');
        kuotaErrorDiv.classList.add('hidden');
    }

    // Open edit kuota modal
    editKuotaBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const dosenId = this.getAttribute('data-dosen-id');
            const dosenNama = this.getAttribute('data-dosen-nama');
            const currentKuota = this.getAttribute('data-kuota-current');

            openEditKuotaModal(dosenId, dosenNama, currentKuota);
        });
    });

    // Close edit kuota modal
    closeEditKuotaModal.addEventListener('click', closeEditKuotaModalFunc);
    cancelEditKuota.addEventListener('click', closeEditKuotaModalFunc);

    // Close modal when clicking outside
    editKuotaModal.addEventListener('click', function(e) {
        if (e.target === editKuotaModal) {
            closeEditKuotaModalFunc();
        }
    });

    // Handle edit kuota form submission
    editKuotaForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Hide previous messages
        kuotaErrorDiv.classList.add('hidden');
        kuotaSuccessDiv.classList.add('hidden');
        kuotaLoading.classList.remove('hidden');

        const formData = new FormData(editKuotaForm);
        const dosenId = document.getElementById('dosenId').value;

        fetch(`{{ route('admin.update-kuota') }}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            kuotaLoading.classList.add('hidden');

            if (data.success) {
                showKuotaSuccess('Kuota bimbingan berhasil diperbarui!');

                // Update button text in table
                const viewDetailBtn = document.querySelector(`[data-dosen-id="${dosenId}"].view-detail-btn`);
                if (viewDetailBtn) {
                    const currentText = viewDetailBtn.textContent;
                    const parts = currentText.split(' / ');
                    if (parts.length === 2) {
                        viewDetailBtn.textContent = `${parts[0]} / ${formData.get('kuota_bimbingan')}`;
                    }
                }

                // Update data attribute di button
                const editBtn = document.querySelector(`[data-dosen-id="${dosenId}"].edit-kuota-btn`);
                if (editBtn) {
                    editBtn.setAttribute('data-kuota-current', formData.get('kuota_bimbingan'));
                }

                // Close modal after 2 seconds
                setTimeout(() => {
                    closeEditKuotaModalFunc();
                }, 2000);
            } else {
                showKuotaErrors(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            kuotaLoading.classList.add('hidden');
            console.error('Error:', error);
            showKuotaErrors('Terjadi kesalahan sistem');
        });
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (!editKuotaModal.classList.contains('hidden')) {
                closeEditKuotaModalFunc();
            }
            if (!dosenDetailModal.classList.contains('hidden')) {
                dosenDetailModal.classList.add('hidden');
            }
        }
    });
});

// Add CSS styles for better tooltip and text handling
const style = document.createElement('style');
style.textContent = `
    .topik-ta-container {
        position: relative;
    }

    .topik-ta-text {
        word-wrap: break-word;
        line-height: 1.4;
    }

    .topik-ta-text:hover {
        color: #1e40af;
    }

    /* Custom tooltip */
    .topik-ta-text[title]:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 0;
        z-index: 1000;
        background: #1f2937;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        line-height: 1.4;
        max-width: 300px;
        white-space: normal;
        word-wrap: break-word;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.2s ease-in-out;
    }

    .topik-ta-text[title]:hover::before {
        content: '';
        position: absolute;
        bottom: calc(100% - 6px);
        left: 12px;
        border: 6px solid transparent;
        border-top-color: #1f2937;
        z-index: 1001;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Modal styles for full text */
    .topik-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.75);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }

    .topik-modal-content {
        background: white;
        border-radius: 8px;
        padding: 24px;
        max-width: 500px;
        width: 100%;
        max-height: 80vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        transform: scale(0.95);
        transition: transform 0.2s ease-out;
    }

    .topik-modal.show .topik-modal-content {
        transform: scale(1);
    }

    .expand-btn {
        transition: all 0.2s ease;
    }

    .expand-btn:hover {
        background: #eff6ff;
        border-radius: 3px;
        padding: 1px 4px;
    }
`;
document.head.appendChild(style);

// Global function to toggle full text display
function toggleFullText(button) {
    const container = button.closest('.topik-ta-container');
    const textSpan = container.querySelector('.topik-ta-text');
    const fullText = textSpan.getAttribute('data-full-text');

    // Create modal
    const modal = document.createElement('div');
    modal.className = 'topik-modal';
    modal.innerHTML = `
        <div class="topik-modal-content">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Topik Tugas Akhir</h3>
                <button class="close-modal text-gray-400 hover:text-gray-600 text-xl font-bold" onclick="closeTopikModal(this)">&times;</button>
            </div>
            <div class="text-sm text-gray-700 leading-relaxed">
                ${fullText || 'Tidak ada topik yang tersedia'}
            </div>
            <div class="mt-6 flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition-colors" onclick="closeTopikModal(this)">
                    Tutup
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    // Show with animation
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);

    // Close on background click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeTopikModal(modal.querySelector('.close-modal'));
        }
    });

    // Close on ESC key
    const escHandler = function(e) {
        if (e.key === 'Escape') {
            closeTopikModal(modal.querySelector('.close-modal'));
            document.removeEventListener('keydown', escHandler);
        }
    };
    document.addEventListener('keydown', escHandler);
}

// Global function to close topik modal
function closeTopikModal(button) {
    const modal = button.closest('.topik-modal');
    modal.classList.remove('show');
    setTimeout(() => {
        if (modal && modal.parentNode) {
            modal.parentNode.removeChild(modal);
        }
    }, 200);
}

// Enhanced table rendering with copy functionality
function renderBimbinganTableEnhanced(data) {
    const tableBimbinganBody = document.getElementById('tableBimbinganBody');
    tableBimbinganBody.innerHTML = '';

    if (data.length > 0) {
        data.forEach((mahasiswa, index) => {
            const topikTA = mahasiswa.topik_ta || '';
            const truncatedTopik = topikTA.length > 50 ? topikTA.substring(0, 47) + '...' : topikTA;
            const statusBadge = getStatusBadge(mahasiswa.seminar_status);

            const row = `
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-3 py-2">${index + 1}</td>
                    <td class="px-3 py-2">${mahasiswa.nama}</td>
                    <td class="px-3 py-2">${mahasiswa.npm}</td>
                    <td class="px-3 py-2">${mahasiswa.angkatan}</td>
                    <td class="px-3 py-2">Dospem ${mahasiswa.dosen_ke}</td>
                    <td class="px-3 py-2">${statusBadge}</td>
                    <td class="px-3 py-2">${mahasiswa.bidang}</td>
                    <td class="px-3 py-2 relative">
                        <div class="topik-ta-container max-w-xs">
                            <span class="topik-ta-text cursor-help"
                                  data-full-text="${topikTA.replace(/"/g, '&quot;')}"
                                  title="${topikTA.replace(/"/g, '&quot;')}">${truncatedTopik}</span>
                            ${topikTA.length > 50 ? `
                                <div class="inline-flex ml-1">
                                    <button class="text-blue-500 hover:text-blue-700 text-xs expand-btn mr-1" onclick="toggleFullText(this)" title="Lihat detail">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-green-500 hover:text-green-700 text-xs copy-btn" onclick="copyToClipboard('${topikTA.replace(/'/g, "\\'")}', this)" title="Salin ke clipboard">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            ` : ''}
                        </div>
                    </td>
                </tr>
            `;
            tableBimbinganBody.insertAdjacentHTML('beforeend', row);
        });
    }
}

// Copy to clipboard function
function copyToClipboard(text, button) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(() => {
            showCopySuccess(button);
        }).catch(() => {
            fallbackCopyTextToClipboard(text, button);
        });
    } else {
        fallbackCopyTextToClipboard(text, button);
    }
}

function fallbackCopyTextToClipboard(text, button) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
    textArea.style.opacity = "0";

    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
        document.execCommand('copy');
        showCopySuccess(button);
    } catch (err) {
        console.error('Fallback: Could not copy text: ', err);
    }

    document.body.removeChild(textArea);
}

function showCopySuccess(button) {
    const originalHTML = button.innerHTML;
    button.innerHTML = `
        <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
    `;
    button.title = 'Tersalin!';

    setTimeout(() => {
        button.innerHTML = originalHTML;
        button.title = 'Salin ke clipboard';
    }, 2000);
}

// Update the main renderBimbinganTable function to use the enhanced version
document.addEventListener('DOMContentLoaded', function() {
    // Replace the existing renderBimbinganTable function
    window.renderBimbinganTable = renderBimbinganTableEnhanced;

    // ...rest of existing code...
});

// Add this function to get status badge HTML
function getStatusBadge(status) {
    const statusConfig = {
        'Bimbingan': { class: 'bg-gray-100 text-gray-800', icon: '📚' },
        'Sempro': { class: 'bg-blue-100 text-blue-800', icon: '📝' },
        'Semhas': { class: 'bg-orange-100 text-orange-800', icon: '📊' },
        'Sidang': { class: 'bg-green-100 text-green-800', icon: '🎓' }
    };

    const config = statusConfig[status] || statusConfig['Bimbingan'];
    return `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${config.class}">
                ${config.icon} ${status}
            </span>`;
}

// Update the filterBimbingan function
function filterBimbingan() {
    const searchTerm = document.getElementById('searchBimbingan').value.toLowerCase();
    const selectedAngkatan = document.getElementById('filterAngkatanBimbingan').value;
    const selectedDospen = document.getElementById('filterDospenKe').value;
    const selectedStatus = document.getElementById('filterStatusBimbingan').value;

    const filteredData = originalBimbinganData.filter(mahasiswa => {
        const matchesSearch = mahasiswa.nama.toLowerCase().includes(searchTerm) ||
                            mahasiswa.npm.toLowerCase().includes(searchTerm) ||
                            (mahasiswa.topik_ta && mahasiswa.topik_ta.toLowerCase().includes(searchTerm));
        const matchesAngkatan = !selectedAngkatan || mahasiswa.angkatan === selectedAngkatan;
        const matchesDospen = !selectedDospen || mahasiswa.dosen_ke.toString() === selectedDospen;
        const matchesStatus = !selectedStatus || mahasiswa.seminar_status === selectedStatus;

        return matchesSearch && matchesAngkatan && matchesDospen && matchesStatus;
    });

    renderBimbinganTable(filteredData);
    document.getElementById('bimbinganResultCount').textContent = filteredData.length;

    // Show/hide no results message
    const noResultsDiv = document.getElementById('noResultsBimbingan');
    if (filteredData.length === 0 && originalBimbinganData.length > 0) {
        noResultsDiv.classList.remove('hidden');
    } else {
        noResultsDiv.classList.add('hidden');
    }
}

// Update the filterWali function
function filterWali() {
    const searchTerm = document.getElementById('searchWali').value.toLowerCase();
    const selectedAngkatan = document.getElementById('filterAngkatanWali').value;
    const selectedStatus = document.getElementById('filterStatusWali').value;

    const filteredData = originalWaliData.filter(mahasiswa => {
        const matchesSearch = mahasiswa.nama.toLowerCase().includes(searchTerm) ||
                            mahasiswa.npm.toLowerCase().includes(searchTerm);
        const matchesAngkatan = !selectedAngkatan || mahasiswa.angkatan === selectedAngkatan;
        const matchesStatus = !selectedStatus || mahasiswa.seminar_status === selectedStatus;

        return matchesSearch && matchesAngkatan && matchesStatus;
    });

    renderWaliTable(filteredData);
    document.getElementById('waliResultCount').textContent = filteredData.length;

    // Show/hide no results message
    const noResultsDiv = document.getElementById('noResultsWali');
    if (filteredData.length === 0 && originalWaliData.length > 0) {
        noResultsDiv.classList.remove('hidden');
    } else {
        noResultsDiv.classList.add('hidden');
    }
}

// Update the renderBimbinganTableEnhanced function
function renderBimbinganTableEnhanced(data) {
    const tableBimbinganBody = document.getElementById('tableBimbinganBody');
    tableBimbinganBody.innerHTML = '';

    if (data.length > 0) {
        data.forEach((mahasiswa, index) => {
            const topikTA = mahasiswa.topik_ta || '';
            const truncatedTopik = topikTA.length > 50 ? topikTA.substring(0, 47) + '...' : topikTA;
            const statusBadge = getStatusBadge(mahasiswa.seminar_status);

            const row = `
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-3 py-2">${index + 1}</td>
                    <td class="px-3 py-2">${mahasiswa.nama}</td>
                    <td class="px-3 py-2">${mahasiswa.npm}</td>
                    <td class="px-3 py-2">${mahasiswa.angkatan}</td>
                    <td class="px-3 py-2">Dospem ${mahasiswa.dosen_ke}</td>
                    <td class="px-3 py-2">${statusBadge}</td>
                    <td class="px-3 py-2">${mahasiswa.bidang}</td>
                    <td class="px-3 py-2 relative">
                        <div class="topik-ta-container max-w-xs">
                            <span class="topik-ta-text cursor-help"
                                  data-full-text="${topikTA.replace(/"/g, '&quot;')}"
                                  title="${topikTA.replace(/"/g, '&quot;')}">${truncatedTopik}</span>
                            ${topikTA.length > 50 ? `
                                <div class="inline-flex ml-1">
                                    <button class="text-blue-500 hover:text-blue-700 text-xs expand-btn mr-1" onclick="toggleFullText(this)" title="Lihat detail">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-green-500 hover:text-green-700 text-xs copy-btn" onclick="copyToClipboard('${topikTA.replace(/'/g, "\\'")}', this)" title="Salin ke clipboard">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            ` : ''}
                        </div>
                    </td>
                </tr>
            `;
            tableBimbinganBody.insertAdjacentHTML('beforeend', row);
        });
    }
}

// Update the renderWaliTable function
function renderWaliTable(data) {
    const tableWaliBody = document.getElementById('tableWaliBody');
    tableWaliBody.innerHTML = '';

    if (data.length > 0) {
        data.forEach((mahasiswa, index) => {
            const statusBadge = getStatusBadge(mahasiswa.seminar_status);

            const row = `
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-3 py-2">${index + 1}</td>
                    <td class="px-3 py-2">${mahasiswa.nama}</td>
                    <td class="px-3 py-2">${mahasiswa.npm}</td>
                    <td class="px-3 py-2">${mahasiswa.angkatan}</td>
                    <td class="px-3 py-2">${statusBadge}</td>
                </tr>
            `;
            tableWaliBody.insertAdjacentHTML('beforeend', row);
        });
    }
}

// Add event listeners for the new status filters
document.getElementById('filterStatusBimbingan').addEventListener('change', filterBimbingan);
document.getElementById('filterStatusWali').addEventListener('change', filterWali);

// Update the reset filter functions
document.getElementById('resetFilterBimbingan').addEventListener('click', function() {
    document.getElementById('searchBimbingan').value = '';
    document.getElementById('filterAngkatanBimbingan').value = '';
    document.getElementById('filterDospenKe').value = '';
    document.getElementById('filterStatusBimbingan').value = '';
    filterBimbingan();
});

document.getElementById('resetFilterWali').addEventListener('click', function() {
    document.getElementById('searchWali').value = '';
    document.getElementById('filterAngkatanWali').value = '';
    document.getElementById('filterStatusWali').value = '';
    filterWali();
});

// Rest of your existing JavaScript code...
</script>

@endsection
