@extends('layouts.layoutdosen')
@section('content')
<style>
    .table-container {
        max-height: 400px;
        overflow-y: auto;
    }
    .word-wrap {
        white-space: normal;
        word-break: break-word;
        max-width: 250px;
    }
    /* agar tabel header dan cell nowrap */
    .fixed-cell {
        white-space: nowrap;
    }
</style>

<div class="container mx-auto px-4 pt-4">
    <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-6xl mx-auto">

        <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-800">Request Mahasiswa Bimbingan</h1>
        </div>

        <!-- Pembungkus tabel dengan scroll horizontal -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg table-container">
            <table class="min-w-[900px] w-full text-xs text-left text-gray-500 border border-gray-300">
                <thead class="text-[10px] text-white uppercase bg-blue-900">
                    <tr>
                        <th class="px-3 py-2 border border-gray-300 fixed-cell">No</th>
                        <th class="px-3 py-2 border border-gray-300 fixed-cell">Nama</th>
                        <th class="px-3 py-2 border border-gray-300 fixed-cell">NPM</th>
                        <th class="px-3 py-2 border border-gray-300 fixed-cell">Bidang</th>
                        <th class="px-3 py-2 border border-gray-300 word-wrap w-[250px]">Judul Tugas Akhir</th>
                        <th class="px-3 py-2 border border-gray-300 fixed-cell">Deskripsi</th>
                        <th class="px-3 py-2 border border-gray-300 fixed-cell">Jenis Ajuan</th>
                        <th class="px-3 py-2 border border-gray-300 fixed-cell">Role</th>
                        <th class="px-3 py-2 border border-gray-300 fixed-cell text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <script>
                        let requests = "";
                        let jenisAjuanList = ["Bimbingan", "Sempro", "Semhas", "Sidang"];
                        for (let i = 1; i <= 12; i++) {
                            let jenisAjuan = jenisAjuanList[i % 4];
                            requests += `
                                <tr class='bg-white even:bg-gray-50 border-b hover:bg-blue-50'>
                                    <td class='px-3 py-2 border border-gray-300 font-medium text-gray-900 fixed-cell'>${i}</td>
                                    <td class='px-3 py-2 border border-gray-300 font-medium text-gray-900 fixed-cell'>Mahasiswa ${i}</td>
                                    <td class='px-3 py-2 border border-gray-300 fixed-cell'>21081070100${i}</td>
                                    <td class='px-3 py-2 border border-gray-300 fixed-cell'>AI</td>
                                    <td class='px-3 py-2 border border-gray-300 word-wrap'>Sistem Cerdas dengan Analisis Data Besar untuk Pengambilan Keputusan Optimal dalam Lingkungan Bisnis ${i}</td>
                                    <td class='px-3 py-2 border border-gray-300 fixed-cell'>
                                        <a href='#' class='text-blue-600 hover:underline' onclick='openModal("Deskripsi Tugas Akhir ${i}")'>Lihat</a>
                                    </td>
                                    <td class='px-3 py-2 border border-gray-300 fixed-cell'>${jenisAjuan}</td>
                                    <td class='px-3 py-2 border border-gray-300 fixed-cell'>Dospem 1</td>
                                    <td class='px-3 py-2 border border-gray-300 flex gap-2 justify-center fixed-cell'>
                                        <button class='text-white bg-green-500 px-3 py-1 rounded hover:bg-green-600 transition hover:scale-105' onclick='acceptRequest(${i})'>Terima</button>
                                        <button class='text-white bg-red-500 px-3 py-1 rounded hover:bg-red-600 transition hover:scale-105' onclick='rejectRequest(${i})'>Tolak</button>
                                    </td>
                                </tr>`;
                        }
                        document.write(requests);
                    </script>
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
    function acceptRequest(id) {
        if (confirm('Apakah Anda yakin ingin menerima request mahasiswa ' + id + '?')) {
            alert('Request mahasiswa ' + id + ' diterima.');
        } else {
            alert('Request tidak diterima.');
        }
    }

    function rejectRequest(id) {
        if (confirm('Apakah Anda yakin ingin menolak request mahasiswa ' + id + '?')) {
            alert('Request mahasiswa ' + id + ' ditolak.');
        } else {
            alert('Request tidak ditolak.');
        }
    }

    function openModal(deskripsi) {
        document.getElementById('modalText').innerText = deskripsi;
        document.getElementById('modalDeskripsi').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalDeskripsi').classList.add('hidden');
    }
</script>

@endsection
