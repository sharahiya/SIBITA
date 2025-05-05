@extends('layouts.layoutadmin')
@section('content')

<div class="container mx-auto px-4 pt-4 max-w-5xl">
    <!-- Header -->
    <div class="bg-white p-6 shadow-md rounded-lg w-full mx-auto">
        <h1 class="text-base font-semibold text-gray-800">Tentukan Penguji dan Ruangan Seminar</h1>
        <p class="text-sm text-gray-600">Tentukan penguji 1, penguji 2, untuk mahasiswa</p>
    </div>

    <!-- Form Penetapan Penguji dan Ruangan -->
    <div class="bg-white p-6 shadow-md rounded-lg mt-4 mx-auto">
        <h2 class="text-sm font-semibold text-gray-800 mb-3">Tentukan Penguji dan Ruangan</h2>

        <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Informasi Mahasiswa -->
            <div class="col-span-1 md:col-span-3">
                <p class="text-sm font-semibold text-gray-800">Nama Mahasiswa:</p>
                <input type="text" value="Fauzan Ramadhan" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 w-full max-w-md" disabled> <!-- Nama Mahasiswa -->

                <p class="text-sm font-semibold text-gray-800 mt-2">NPM Mahasiswa:</p>
                <input type="text" value="2108107010021" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 w-full max-w-md" disabled> <!-- NPM Mahasiswa -->
            </div>

            <!-- Bidang Minat dan Judul TA -->
            <div class="col-span-1 md:col-span-3">
                <p class="text-sm font-semibold text-gray-800">Bidang Minat:</p>
                <input type="text" value="Kecerdasan Buatan" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 w-full max-w-md" disabled> <!-- Bidang Minat -->

                <p class="text-sm font-semibold text-gray-800 mt-2">Judul TA:</p>
                <div class="flex items-center space-x-2">
                    <input type="text" id="judulTAField" value="Pengembangan AI untuk Cerdas Buatan" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 w-full max-w-md" disabled> <!-- Judul TA -->
                    <button type="button" onclick="openModal()" class="text-white bg-blue-500 hover:bg-blue-600 p-2 text-xs rounded-lg">Edit</button>
                </div>
            </div>

            <!-- Dospem -->
            <div class="col-span-1 md:col-span-3">
                <p class="text-sm font-semibold text-gray-800">Dosen Pembimbing 1:</p>
                <input type="text" value="Dosen A" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 w-full max-w-md" disabled> <!-- Dospem 1 -->

                <p class="text-sm font-semibold text-gray-800 mt-2">Dosen Pembimbing 2:</p>
                <input type="text" value="Dosen B" class="p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 w-full max-w-md" disabled> <!-- Dospem 2 -->
            </div>

          <!-- Pilihan Penguji 1 -->
<div class="col-span-1 md:col-span-3">
    <h3 class="text-sm font-semibold text-gray-800 mb-2 mt-4">Pilih Penguji 1</h3>
    <div class="relative">
        <input id="searchPenguji1" type="text" placeholder="Cari Penguji 1..." class="w-full p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 mb-2">
        <div id="penguji1List" class="overflow-y-auto max-h-48 bg-white border rounded-lg shadow-lg z-10">
            <table class="w-full text-xs text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Nama Dosen</th>
                        <th class="px-4 py-2">NIP</th>
                        <th class="px-4 py-2">Jabatan</th>
                        <th class="px-4 py-2">Jumlah Perwalian</th>
                        <th class="px-4 py-2">Jumlah Bimbingan</th>
                        <th class="px-4 py-2">Jumlah Penguji</th>
                    </tr>
                </thead>
                <tbody id="penguji1Table">
                <tr class="p-2 cursor-pointer" onclick="selectPenguji('searchPenguji1', 'Prof. Budi Hermawan')">
                        <td class="px-4 py-2">Prof. Budi Hermawan</td>
                        <td class="px-4 py-2">19850101 201202 1</td>
                        <td class="px-4 py-2">Profesor</td>
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Perwalian -->
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Bimbingan -->
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Penguji-->
                    </tr>
                    <tr class="p-2 cursor-pointer" onclick="selectPenguji('searchPenguji1', 'Prof. Mira Heryanyi')">
                        <td class="px-4 py-2">Mira Heryanyi</td>
                        <td class="px-4 py-2">19841210 201302 3</td>
                        <td class="px-4 py-2">Dosen Lektor</td>
                        <td class="px-4 py-2">1</td> <!-- Jumlah Mahasiswa Perwalian -->
                        <td class="px-4 py-2">1</td> <!-- Jumlah Mahasiswa Bimbingan -->
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Penguji-->
                    </tr>
                    <tr class="p-2 cursor-pointer" onclick="selectPenguji('searchPenguji1', 'Dr. Luthfi Hidayat')">
                        <td class="px-4 py-2">Dr. Luthfi Hidayat</td>
                        <td class="px-4 py-2">19890711 201403 2</td>
                        <td class="px-4 py-2">Dosen Muda</td>
                        <td class="px-4 py-2">1</td> <!-- Jumlah Mahasiswa Perwalian -->
                        <td class="px-4 py-2">1</td> <!-- Jumlah Mahasiswa Bimbingan -->
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Penguji-->
                    </tr>
                    <tr class="p-2 cursor-pointer" onclick="selectPenguji('searchPenguji1', 'Dr. Indra Santoso')">
                        <td class="px-4 py-2">Dr. Indra Santoso</td>
                        <td class="px-4 py-2">19780505 200712 4</td>
                        <td class="px-4 py-2">Asisten Profesor</td>
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Perwalian -->
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Bimbingan -->
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Penguji-->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pilihan Penguji 2 -->
<div class="col-span-1 md:col-span-3">
    <h3 class="text-sm font-semibold text-gray-800 mb-2 mt-4">Pilih Penguji 2</h3>
    <div class="relative">
        <input id="searchPenguji2" type="text" placeholder="Cari Penguji 2..." class="w-full p-2 text-xs border rounded-lg focus:ring-2 focus:ring-blue-500 mb-2">
        <div id="penguji2List" class="overflow-y-auto max-h-48 bg-white border rounded-lg shadow-lg z-10">
            <table class="w-full text-xs text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Nama Dosen</th>
                        <th class="px-4 py-2">NIP</th>
                        <th class="px-4 py-2">Jabatan</th>
                        <th class="px-4 py-2">Jumlah Perwalian</th>
                        <th class="px-4 py-2">Jumlah Bimbingan</th>
                        <th class="px-4 py-2">Jumlah Penguji</th>
                    </tr>
                </thead>
                <tbody id="penguji2Table">
                <tr class="p-2 cursor-pointer" onclick="selectPenguji('searchPenguji2', 'Prof. Budi Hermawan')">
                        <td class="px-4 py-2">Prof. Budi Hermawan</td>
                        <td class="px-4 py-2">19850101 201202 1</td>
                        <td class="px-4 py-2">Profesor</td>
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Perwalian -->
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Bimbingan -->
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Penguji-->
                    </tr>
                    <tr class="p-2 cursor-pointer" onclick="selectPenguji('searchPenguji2', 'Prof. Mira Heryanyi')">
                        <td class="px-4 py-2">Mira Heryanyi</td>
                        <td class="px-4 py-2">19841210 201302 3</td>
                        <td class="px-4 py-2">Dosen Lektor</td>
                        <td class="px-4 py-2">1</td> <!-- Jumlah Mahasiswa Perwalian -->
                        <td class="px-4 py-2">1</td> <!-- Jumlah Mahasiswa Bimbingan -->
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Penguji-->
                    </tr>
                    <tr class="p-2 cursor-pointer" onclick="selectPenguji('searchPenguji2', 'Dr. Luthfi Hidayat')">
                        <td class="px-4 py-2">Dr. Luthfi Hidayat</td>
                        <td class="px-4 py-2">19890711 201403 2</td>
                        <td class="px-4 py-2">Dosen Muda</td>
                        <td class="px-4 py-2">1</td> <!-- Jumlah Mahasiswa Perwalian -->
                        <td class="px-4 py-2">1</td> <!-- Jumlah Mahasiswa Bimbingan -->
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Penguji-->
                    </tr>
                    <tr class="p-2 cursor-pointer" onclick="selectPenguji('searchPenguji2', 'Dr. Indra Santoso')">
                        <td class="px-4 py-2">Dr. Indra Santoso</td>
                        <td class="px-4 py-2">19780505 200712 4</td>
                        <td class="px-4 py-2">Asisten Profesor</td>
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Perwalian -->
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Bimbingan -->
                        <td class="px-4 py-2">2</td> <!-- Jumlah Mahasiswa Penguji-->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


           

            <!-- Button -->
            <button class="col-span-1 md:col-span-3 bg-blue-500 text-white p-2 text-xs rounded-lg hover:bg-blue-600 transition">Tetapkan Penguji</button>
        </form>
    </div>

    <!-- Modal Edit Judul TA -->
    <div id="editModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg w-96">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Edit Judul TA</h3>
            <input type="text" id="editJudulTA" class="p-2 text-xs border rounded-lg w-full" value="Pengembangan AI untuk Cerdas Buatan">
            <div class="mt-4 flex justify-end">
                <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-700 p-2 text-xs rounded-lg mr-2">Batal</button>
                <button type="button" onclick="saveJudulTA()" class="bg-blue-500 text-white p-2 text-xs rounded-lg">Simpan</button>
            </div>
        </div>
    </div>

    <!-- Script untuk memilih dosen penguji -->
<script>
 function selectPenguji(inputId, dosenName) {
    document.getElementById(inputId).value = dosenName;

    if (inputId === 'searchPenguji1') {
        document.getElementById('hiddenPenguji1').value = dosenName;
    } else if (inputId === 'searchPenguji2') {
        document.getElementById('hiddenPenguji2').value = dosenName;
    }
}

</script>

    <!-- Script Pencarian untuk Penguji -->
    <script>
        document.getElementById('searchPenguji1').addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            const items = document.querySelectorAll('#penguji1Table tr');
            items.forEach(item => {
                item.style.display = item.innerText.toLowerCase().includes(keyword) ? '' : 'none';
            });
        });

        document.getElementById('searchPenguji2').addEventListener('input', function () {
    const keyword = this.value.toLowerCase();
    const items = document.querySelectorAll('#penguji2Table tr');
    items.forEach(item => {
        item.style.display = item.innerText.toLowerCase().includes(keyword) ? '' : 'none';
    });
});


        // Modal open & close
        function openModal() {
    document.getElementById('editModal').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
}
function saveJudulTA() {
    const newJudul = document.getElementById('editJudulTA').value;
    document.getElementById('judulTAField').value = newJudul;
    closeModal();
}

    </script>

@endsection
