@extends('layouts.layoutdosen')

@section('content')
<div class="container mx-auto px-4 pt-4">
    <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-6xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-800">Data Dosen Pembimbing</h1>
        </div>
        <h2 class="text-lg font-semibold text-gray-900 mb-2">
            {{ $dosen->nama }}
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1 text-sm text-gray-700">
            <p><span class="font-medium">NIP:</span> {{ $dosen->nip }}</p>
            <p><span class="font-medium">Jabatan:</span> {{ $dosen->jabatan }}</p>
            <p><span class="font-medium">Jurusan:</span> {{ $dosen->jurusan->nama_jurusan }}</p>
            <p><span class="font-medium">Fakultas:</span> {{ $dosen->fakultas->nama_fakultas }}</p>
            <p class="md:col-span-2"><span class="font-medium">Bidang:</span> {{ $dosen->bidang }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="bg-blue-500 rounded-full p-3 mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Mahasiswa Bimbingan</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $jumlahMahasiswa }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="bg-green-500 rounded-full p-3 mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Mahasiswa Wali</p>
                        <p class="text-2xl font-bold text-green-600">{{ $jumlahMahasiswaWali }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kuota Bimbingan -->
        <div class="mt-6">
            <label for="kuotaBimbingan" class="text-xs text-gray-600">Kuota Bimbingan:</label>
            <div class="flex items-center space-x-2 mt-1">
                <input type="number" id="kuotaBimbingan" value="{{ $dosen->kuota_bimbingan }}" min="1"
                    class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-24 focus:ring-blue-500 focus:border-blue-500" disabled>
            </div>
        </div>

        <!-- Input Link WhatsApp -->
        <div class="mt-6">
            <label for="whatsappGroup" class="text-xs text-gray-600">Link WhatsApp Grup:</label>
            <div class="flex items-center space-x-2 mt-1">
                <input type="text" id="whatsappGroup"
                    value="{{ $dosen->link_wa_group  ?? 'https://chat.whatsapp.com/xxxxx' }}"
                    class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-80 focus:ring-blue-500 focus:border-blue-500"
                    disabled>
                <button id="editWhatsapp" class="px-3 py-2 bg-blue-800 text-white text-xs rounded-lg hover:bg-blue-600 transition">
                    Edit
                </button>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="mt-8">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button id="tabBimbingan"
                            class="tab-button active border-b-2 border-blue-500 py-2 px-1 text-sm font-medium text-blue-600 whitespace-nowrap"
                            onclick="switchTab('bimbingan')">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <span>Mahasiswa Bimbingan ({{ $jumlahMahasiswa }})</span>
                        </div>
                    </button>
                    <button id="tabWali"
                            class="tab-button border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap"
                            onclick="switchTab('wali')">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Mahasiswa Wali ({{ $jumlahMahasiswaWali }})</span>
                        </div>
                    </button>
                </nav>
            </div>
        </div>

        <!-- Search Input -->
        <div class="mt-6 mb-4">
            <div class="flex items-center space-x-2">
                <input type="text"
                    id="searchInput"
                    placeholder="Cari mahasiswa berdasarkan nama, NPM, bidang, atau judul TA"
                    class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-64 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Tab Content: Mahasiswa Bimbingan -->
        <div id="contentBimbingan" class="tab-content">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Mahasiswa Bimbingan</h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-height: 400px; overflow-y: auto;">
                <table class="w-full text-xs text-left text-gray-500 border border-gray-300">
                    <thead class="text-[10px] text-white uppercase bg-blue-900 sticky top-0">
                        <tr>
                            <th class="px-4 py-2 border border-gray-300">No</th>
                            <th class="px-4 py-2 border border-gray-300">Nama</th>
                            <th class="px-4 py-2 border border-gray-300">NPM</th>
                            <th class="px-4 py-2 border border-gray-300">Bidang</th>
                            <th class="px-4 py-2 border border-gray-300">Judul Tugas Akhir</th>
                            <th class="px-4 py-2 border border-gray-300">Deskripsi</th>
                            <th class="px-4 py-2 border border-gray-300">Role</th>
                            <th class="px-4 py-2 border border-gray-300">Status</th>
                            <th class="px-4 py-2 border border-gray-300">Action</th>
                        </tr>
                    </thead>
                    <tbody id="mahasiswaTableBody">
                        @php $no = 1; @endphp
                        @foreach($ajuanBimbingan as $index => $ajuan)
                        <tr class="bg-white even:bg-gray-50 border-b hover:bg-blue-50 searchable-row">
                            <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">{{ $no++ }}</td>
                            <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">{{ $ajuan->mahasiswa->nama }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $ajuan->mahasiswa->npm }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $ajuan->bidang }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $ajuan->topik_ta }}</td>
                            <td class="px-4 py-2 border border-gray-300">
                                <a href="#" class="text-blue-600 hover:underline" onclick="openModal('{{ $ajuan->deskripsi_ta }}')">Lihat</a>
                            </td>
                            <td class="px-4 py-2 border border-gray-300">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                    {{ $ajuan->dosen_ke == "1" ? 'Dospem 1' : 'Dospem 2' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border border-gray-300">
                                @php
                                    $status = $ajuan->mahasiswa->seminar_status ?? 'Bimbingan';
                                    $statusColor = match($status) {
                                        'Bimbingan' => 'bg-gray-100 text-gray-800',
                                        'Sempro' => 'bg-yellow-100 text-yellow-800',
                                        'Semhas' => 'bg-orange-100 text-orange-800',
                                        'Sidang' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium {{ $statusColor }} rounded-full">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border border-gray-300">
                                @if($ajuan->mahasiswa->seminar_status == "Bimbingan")
                                <button class="text-red-600 hover:underline text-xs" onclick="confirmRemove(this)" data-id="{{ $ajuan->id_pengajuan }}">
                                    Remove
                                </button>
                                @else
                                <span class="text-[10px] text-gray-500 italic">Sudah seminar</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @if($ajuanBimbingan->isEmpty())
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    <p>Belum ada mahasiswa bimbingan</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Content: Mahasiswa Wali -->
        <div id="contentWali" class="tab-content hidden">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Daftar Mahasiswa Wali</h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="max-height: 400px; overflow-y: auto;">
                <table class="w-full text-xs text-left text-gray-500 border border-gray-300">
                    <thead class="text-[10px] text-white uppercase bg-green-900 sticky top-0">
                        <tr>
                            <th class="px-4 py-2 border border-gray-300">No</th>
                            <th class="px-4 py-2 border border-gray-300">Nama</th>
                            <th class="px-4 py-2 border border-gray-300">NPM</th>
                            <th class="px-4 py-2 border border-gray-300">Angkatan</th>
                            <th class="px-4 py-2 border border-gray-300">Status Bimbingan</th>
                            <th class="px-4 py-2 border border-gray-300">Status Seminar</th>
                        </tr>
                    </thead>
                    <tbody id="mahasiswaWaliTableBody">
                        @php $no = 1; @endphp
                        @foreach($mahasiswaWali as $mahasiswa)
                        <tr class="bg-white even:bg-gray-50 border-b hover:bg-green-50 searchable-row">
                            <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">{{ $no++ }}</td>
                            <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">{{ $mahasiswa->nama }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $mahasiswa->npm }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ $mahasiswa->angkatan }}</td>
                            <td class="px-4 py-2 border border-gray-300">
                                @if($mahasiswa->pengajuan->where('status', 'diterima')->isNotEmpty())
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                        Ada Pembimbing
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                        Belum Ada Pembimbing
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border border-gray-300">
                                @php
                                    $status = $mahasiswa->seminar_status ?? 'Bimbingan';
                                    $statusColor = match($status) {
                                        'Bimbingan' => 'bg-gray-100 text-gray-800',
                                        'Sempro' => 'bg-yellow-100 text-yellow-800',
                                        'Semhas' => 'bg-orange-100 text-orange-800',
                                        'Sidang' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium {{ $statusColor }} rounded-full">
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        @if($mahasiswaWali->isEmpty())
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <p>Belum ada mahasiswa wali</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal yang sudah ada sebelumnya tetap sama -->
<!-- Modal Deskripsi -->
<div id="modalDeskripsi" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <!-- Modal content sama seperti sebelumnya -->
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-2xl mx-4 transform scale-95 transition-transform duration-300" id="modalDeskripsiContent">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full p-3 mr-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Deskripsi Tugas Akhir</h2>
            </div>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="max-h-96 overflow-y-auto">
            <p id="modalText" class="text-gray-700 leading-relaxed whitespace-pre-line bg-gray-50 p-4 rounded-lg"></p>
        </div>

        <div class="mt-6 flex justify-end">
            <button onclick="closeModal()" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Modal lainnya tetap sama seperti sebelumnya -->
<!-- ... (Modal Remove, Modal WhatsApp, dll.) ... -->

<style>
    /* Tab Styles */
    .tab-button.active {
        color: #3b82f6;
        border-color: #3b82f6;
    }

    .tab-content {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .searchable-row {
        transition: all 0.2s ease;
    }

    .searchable-row:hover {
        transform: translateX(2px);
    }
</style>

<script>
    let currentTab = 'bimbingan';

    // Tab switching functionality
    function switchTab(tab) {
        currentTab = tab;

        // Update tab buttons
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
            btn.classList.add('border-transparent', 'text-gray-500');
        });

        document.getElementById(`tab${tab.charAt(0).toUpperCase() + tab.slice(1)}`).classList.add(
            'active', 'border-blue-500', 'text-blue-600'
        );
        document.getElementById(`tab${tab.charAt(0).toUpperCase() + tab.slice(1)}`).classList.remove(
            'border-transparent', 'text-gray-500'
        );

        // Update content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        document.getElementById(`content${tab.charAt(0).toUpperCase() + tab.slice(1)}`).classList.remove('hidden');

        // Clear and trigger search for current tab
        const searchInput = document.getElementById('searchInput');
        searchInput.value = '';
        searchStudents();
    }

    // Enhanced search functionality for both tabs
    function searchStudents() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();

        if (currentTab === 'bimbingan') {
            const rows = document.querySelectorAll('#mahasiswaTableBody .searchable-row');
            rows.forEach(row => {
                const nama = row.cells[1]?.textContent.toLowerCase() || '';
                const npm = row.cells[2]?.textContent.toLowerCase() || '';
                const bidang = row.cells[3]?.textContent.toLowerCase() || '';
                const topik = row.cells[4]?.textContent.toLowerCase() || '';

                if (nama.includes(searchValue) ||
                    npm.includes(searchValue) ||
                    bidang.includes(searchValue) ||
                    topik.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        } else if (currentTab === 'wali') {
            const rows = document.querySelectorAll('#mahasiswaWaliTableBody .searchable-row');
            rows.forEach(row => {
                const nama = row.cells[1]?.textContent.toLowerCase() || '';
                const npm = row.cells[2]?.textContent.toLowerCase() || '';
                const angkatan = row.cells[3]?.textContent.toLowerCase() || '';

                if (nama.includes(searchValue) ||
                    npm.includes(searchValue) ||
                    angkatan.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    }

    // Search event listener
    document.getElementById('searchInput').addEventListener('input', searchStudents);

    // Update placeholder text based on active tab
    function updateSearchPlaceholder() {
        const searchInput = document.getElementById('searchInput');
        if (currentTab === 'bimbingan') {
            searchInput.placeholder = 'Cari mahasiswa berdasarkan nama, NPM, bidang, atau judul TA';
        } else {
            searchInput.placeholder = 'Cari mahasiswa berdasarkan nama, NPM, atau angkatan';
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateSearchPlaceholder();
    });

    // Update search placeholder when tab changes
    document.getElementById('tabBimbingan').addEventListener('click', function() {
        setTimeout(updateSearchPlaceholder, 100);
    });

    document.getElementById('tabWali').addEventListener('click', function() {
        setTimeout(updateSearchPlaceholder, 100);
    });

    // Rest of the JavaScript functions remain the same...
    // (Modal functions, WhatsApp edit, etc.)
</script>

@endsection
