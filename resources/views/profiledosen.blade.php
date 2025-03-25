<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-blue-100 font-poppins min-h-screen flex flex-col">

    <!-- Navbar -->
    @include('components/navbardosen')

    <div class="container mx-auto px-4 pt-4">
        <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-6xl mx-auto mt-16">

            <div class="text-center mb-8">
                <h1 class="text-2xl font-semibold text-gray-800">Data Dosen Pembimbing</h1>
            </div>

            <h2 class="text-lg font-semibold text-gray-900 mb-2">
                Prof. Dr. Taufik Fuadi Abidin, S.Si, M.Tech
            </h2>
            <p class="text-gray-700 text-sm">Bidang: Data Mining</p>
            <p class="text-gray-700 text-sm">Jumlah Bimbingan: <span id="jumlahMahasiswa">10</span></p>

            <!-- Input Link WhatsApp -->
            <div class="mt-4">
                <label for="whatsappGroup" class="text-xs text-gray-600">Link WhatsApp Grup:</label>
                <div class="flex items-center space-x-2 mt-1">
                    <input type="text" id="whatsappGroup" 
                        value="{{ auth()->user()->whatsapp_link ?? 'https://chat.whatsapp.com/xxxxx' }}"
                        class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-80 focus:ring-blue-500 focus:border-blue-500"
                        disabled>
                    <button id="editWhatsapp" class="px-3 py-2 bg-blue-800 text-white text-xs rounded-lg hover:bg-yellow-600 transition">
                        ✏️ Edit
                    </button>
                    <button id="saveWhatsapp" class="px-3 py-2 bg-green-500 text-white text-xs rounded-lg hover:bg-green-600 transition hidden">
                        ✅ Simpan
                    </button>
                </div>
            </div>

             

            <!-- Daftar Mahasiswa -->
            <h2 class="text-lg font-semibold text-gray-800 mt-6">Daftar Mahasiswa Bimbingan</h2>

            <!-- Input Pencarian -->
            <div class="mt-4">
                <label for="searchInput" class="text-xs text-gray-600">Cari Mahasiswa:</label>
                <input type="text" id="searchInput" 
                    class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-80 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Cari berdasarkan Nama atau NPM...">
            </div>

           <!-- Wrapper dengan scroll jika lebih dari 5 mahasiswa -->
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
                <th class="px-4 py-2 border border-gray-300">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Baris Mahasiswa -->
            <tr class="bg-white even:bg-gray-50 border-b hover:bg-blue-50">
                <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">1</td>
                <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">Sharahiya</td>
                <td class="px-4 py-2 border border-gray-300">2108107010082</td>
                <td class="px-4 py-2 border border-gray-300">RPL</td>
                <td class="px-4 py-2 border border-gray-300">Rancang Bangun Sistem Rekomendasi Berbasis website menggunakan framework laravel</td>
                <td class="px-4 py-2 border border-gray-300">
                    <a href="#" class="text-blue-600 hover:underline" onclick="openModal('Deskripsi tentang sistem rekomendasi berbasis AI')">Lihat</a>
                </td>
                <td class="px-4 py-2 border border-gray-300">Dospem1</td>
                <td class="px-4 py-2 border border-gray-300">Sempro</td>
                <td class="px-4 py-2 border border-gray-300">
                    <button class="text-red-600 hover:underline" onclick="confirmRemove(this)">Remove</button>
                </td>
            </tr>
            <tr class="bg-white even:bg-gray-50 border-b hover:bg-blue-50">
            <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">2</td>
                <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">Sharahiya</td>
                <td class="px-4 py-2 border border-gray-300">2108107010082</td>
                <td class="px-4 py-2 border border-gray-300">RPL</td>
                <td class="px-4 py-2 border border-gray-300">Rancang Bangun Sistem Rekomendasi Berbasis website menggunakan framework laravel</td>
                <td class="px-4 py-2 border border-gray-300">
                    <a href="#" class="text-blue-600 hover:underline" onclick="openModal('Deskripsi tentang sistem rekomendasi berbasis AI')">Lihat</a>
                </td>
                <td class="px-4 py-2 border border-gray-300">Dospem1</td>
                <td class="px-4 py-2 border border-gray-300">Sempro</td>
                <td class="px-4 py-2 border border-gray-300">
                    <button class="text-red-600 hover:underline" onclick="confirmRemove(this)">Remove</button>
                </td>
            </tr>
            <tr class="bg-white even:bg-gray-50 border-b hover:bg-blue-50">
            <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">3</td>
                <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">Sharahiya</td>
                <td class="px-4 py-2 border border-gray-300">2108107010082</td>
                <td class="px-4 py-2 border border-gray-300">RPL</td>
                <td class="px-4 py-2 border border-gray-300">Rancang Bangun Sistem Rekomendasi Berbasis website menggunakan framework laravel</td>
                <td class="px-4 py-2 border border-gray-300">
                    <a href="#" class="text-blue-600 hover:underline" onclick="openModal('Deskripsi tentang sistem rekomendasi berbasis AI')">Lihat</a>
                </td>
                <td class="px-4 py-2 border border-gray-300">Dospem1</td>
                <td class="px-4 py-2 border border-gray-300">Sempro</td>
                <td class="px-4 py-2 border border-gray-300">
                    <button class="text-red-600 hover:underline" onclick="confirmRemove(this)">Remove</button>
                </td>
            </tr>
            <tr class="bg-white even:bg-gray-50 border-b hover:bg-blue-50">
            <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">4</td>
                <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">Sharahiya</td>
                <td class="px-4 py-2 border border-gray-300">2108107010082</td>
                <td class="px-4 py-2 border border-gray-300">RPL</td>
                <td class="px-4 py-2 border border-gray-300">Rancang Bangun Sistem Rekomendasi Berbasis website menggunakan framework laravel</td>
                <td class="px-4 py-2 border border-gray-300">
                    <a href="#" class="text-blue-600 hover:underline" onclick="openModal('Deskripsi tentang sistem rekomendasi berbasis AI')">Lihat</a>
                </td>
                <td class="px-4 py-2 border border-gray-300">Dospem1</td>
                <td class="px-4 py-2 border border-gray-300">Sempro</td>
                <td class="px-4 py-2 border border-gray-300">
                    <button class="text-red-600 hover:underline" onclick="confirmRemove(this)">Remove</button>
                </td>
            </tr>
            <tr class="bg-white even:bg-gray-50 border-b hover:bg-blue-50">
            <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">5</td>
                <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">Sharahiya</td>
                <td class="px-4 py-2 border border-gray-300">2108107010082</td>
                <td class="px-4 py-2 border border-gray-300">RPL</td>
                <td class="px-4 py-2 border border-gray-300">Rancang Bangun Sistem Rekomendasi Berbasis website menggunakan framework laravel</td>
                <td class="px-4 py-2 border border-gray-300">
                    <a href="#" class="text-blue-600 hover:underline" onclick="openModal('Deskripsi tentang sistem rekomendasi berbasis AI')">Lihat</a>
                </td>
                <td class="px-4 py-2 border border-gray-300">Dospem1</td>
                <td class="px-4 py-2 border border-gray-300">Sempro</td>
                <td class="px-4 py-2 border border-gray-300">
                    <button class="text-red-600 hover:underline" onclick="confirmRemove(this)">Remove</button>
                </td>
            </tr>
            <tr class="bg-white even:bg-gray-50 border-b hover:bg-blue-50">
            <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">6</td>
                <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">Sharahiya</td>
                <td class="px-4 py-2 border border-gray-300">2108107010082</td>
                <td class="px-4 py-2 border border-gray-300">RPL</td>
                <td class="px-4 py-2 border border-gray-300">Rancang Bangun Sistem Rekomendasi Berbasis website menggunakan framework laravel</td>
                <td class="px-4 py-2 border border-gray-300">
                    <a href="#" class="text-blue-600 hover:underline" onclick="openModal('Deskripsi tentang sistem rekomendasi berbasis AI')">Lihat</a>
                </td>
                <td class="px-4 py-2 border border-gray-300">Dospem1</td>
                <td class="px-4 py-2 border border-gray-300">Sempro</td>
                <td class="px-4 py-2 border border-gray-300">
                    <button class="text-red-600 hover:underline" onclick="confirmRemove(this)">Remove</button>
                </td>
            </tr>
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

    <!-- Modal Konfirmasi Remove -->
    <div id="modalRemove" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 text-center">
            <p class="text-gray-800">Apakah Anda yakin ingin menghapus mahasiswa ini?</p>
            <div class="mt-4 flex justify-center space-x-4">
                <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600" onclick="removeStudent()">Ya</button>
                <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600" onclick="closeRemoveModal()">Tidak</button>
            </div>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        function saveLink() {
            let inputField = document.getElementById('whatsappGroup');
            inputField.disabled = true;
            alert('Link WhatsApp berhasil disimpan!');
        }

        document.getElementById('editWhatsapp').addEventListener('click', function () {
            let inputField = document.getElementById('whatsappGroup');
            inputField.disabled = false;
            inputField.focus();
            document.getElementById('editWhatsapp').classList.add('hidden');
            document.getElementById('saveWhatsapp').classList.remove('hidden');
        });

        document.getElementById('saveWhatsapp').addEventListener('click', function () {
            saveLink();
            document.getElementById('editWhatsapp').classList.remove('hidden');
            document.getElementById('saveWhatsapp').classList.add('hidden');
        });

        function openModal(deskripsi) {
            document.getElementById('modalText').innerText = deskripsi;
            document.getElementById('modalDeskripsi').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalDeskripsi').classList.add('hidden');
        }

        let selectedRow = null;
        function confirmRemove(button) {
            selectedRow = button.closest("tr");
            document.getElementById("modalRemove").classList.remove("hidden");
        }

        function removeStudent() {
            if (selectedRow) {
                selectedRow.remove();
                document.getElementById("modalRemove").classList.add("hidden");
            }
        }

        function closeRemoveModal() {
            document.getElementById("modalRemove").classList.add("hidden");
        }
    </script>

    <!-- Navbar -->
    @include('components/footer')
</body>
</html>
