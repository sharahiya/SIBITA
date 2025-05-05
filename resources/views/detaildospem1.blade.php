@extends('layouts.layoutmhs')
@section('content')
<div class="container mx-auto px-4 pt-4">
    <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-6xl mx-auto">
<!-- Tombol Kembali -->
<div class="mb-6">
    <a href="{{ route('pengajuan2') }}" 
       class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-full shadow hover:bg-gray-200 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali
    </a>
</div>


        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-800">Detail Dosen Pembimbing 1</h1>
        </div>

        <h2 class="text-lg font-semibold text-gray-900 mb-2">
            Prof. Dr. Taufik Fuadi Abidin, S.Si, M.Tech
        </h2>
        <p class="text-gray-700 text-sm">Bidang: Data Mining</p>
        <p class="text-gray-700 text-sm">Jumlah Mahasiswa Bimbingan: 10</p>

        <!-- Link WhatsApp Read-Only -->
        <div class="mt-4">
            <label for="whatsappGroup" class="text-xs text-gray-600">Link WhatsApp Grup:</label>
            <input type="text" id="whatsappGroup" 
                value="https://chat.whatsapp.com/xxxxx" 
                class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-80 bg-gray-100" 
                disabled>
        </div>

        <!-- Daftar Mahasiswa -->
        <h2 class="text-lg font-semibold text-gray-800 mt-6">Daftar Mahasiswa Bimbingan</h2>

        <div class="mt-4">
            <label for="searchInput" class="text-xs text-gray-600">Cari Mahasiswa:</label>
            <input type="text" id="searchInput" 
                class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-80 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Cari berdasarkan Nama atau NPM...">
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4" style="max-height: 300px; overflow-y: auto;">
            <table class="w-full text-xs text-left text-gray-500 border border-gray-300">
                <thead class="text-[10px] text-white uppercase bg-blue-900">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">No</th>
                        <th class="px-4 py-2 border border-gray-300">Nama</th>
                        <th class="px-4 py-2 border border-gray-300">NPM</th>
                        <th class="px-4 py-2 border border-gray-300">Bidang</th>
                        <th class="px-4 py-2 border border-gray-300">Judul Tugas Akhir</th>
                        <th class="px-4 py-2 border border-gray-300">Deskripsi</th>
                        <th class="px-4 py-2 border border-gray-300">Role</th>
                        <th class="px-4 py-2 border border-gray-300">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop data mahasiswa -->
                    <tr class="bg-white even:bg-gray-50 border-b hover:bg-blue-50">
                        <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">1</td>
                        <td class="px-4 py-2 border border-gray-300">Sharahiya</td>
                        <td class="px-4 py-2 border border-gray-300">2108107010082</td>
                        <td class="px-4 py-2 border border-gray-300">RPL</td>
                        <td class="px-4 py-2 border border-gray-300">Rancang Bangun Sistem Rekomendasi...</td>
                        <td class="px-4 py-2 border border-gray-300">
                            <a href="#" class="text-blue-600 hover:underline" onclick="openModal('Deskripsi tentang sistem rekomendasi berbasis AI')">Lihat</a>
                        </td>
                        <td class="px-4 py-2 border border-gray-300">Dospem1</td>
                        <td class="px-4 py-2 border border-gray-300">Sempro</td>
                    </tr>
                    <!-- Tambahkan data lain seperti biasa -->
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Modal Deskripsi -->
<div id="modalDeskripsi" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <p id="modalText" class="text-gray-800"></p>
        <div class="mt-4 flex justify-end">
            <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>

<script>
    function openModal(deskripsi) {
        document.getElementById('modalText').innerText = deskripsi;
        document.getElementById('modalDeskripsi').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalDeskripsi').classList.add('hidden');
    }
</script>
@endsection
