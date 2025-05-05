@extends('layouts.layoutdosen')

@section('content')
    <div class="container mx-auto px-4 pt-4">
        <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-6xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-semibold text-gray-800">Data Dosen Pembimbing</h1>
            </div>

            <h2 class="text-lg font-semibold text-gray-900 mb-2">
                Prof. Dr. Taufik Fuadi Abidin, S.Si, M.Tech
            </h2>
            <p class="text-gray-700 text-sm">Bidang: Data Mining</p>

            <!-- Menampilkan Jumlah Bimbingan terlebih dahulu -->
            <div class="mt-6">
                <p class="text-gray-700 text-sm">Jumlah Mahasiswa yang Dibimbing: 
                    <span id="jumlahMahasiswa" class="font-semibold text-blue-600">10</span>
                </p>
            </div>

            <!-- Kuota Bimbingan -->
            <div class="mt-6">
                <label for="kuotaBimbingan" class="text-xs text-gray-600">Kuota Bimbingan:</label>
                <div class="flex items-center space-x-2 mt-1">
                    <input type="number" id="kuotaBimbingan" value="25" min="1" 
                        class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-24 focus:ring-blue-500 focus:border-blue-500" disabled>
                    <button id="editKuotaButton" class="px-3 py-2 bg-blue-800 text-white text-xs rounded-lg hover:bg-blue-600 transition">
                        Edit
                    </button>
                </div>
            </div>

            <!-- Tombol Simpan untuk Kuota -->
            <div class="mt-4" id="saveButtonContainer" style="display: none;">
                <button id="saveKuotaButton" class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-700 text-xs">
                    Simpan Kuota
                </button>
            </div>

            <!-- Input Link WhatsApp -->
            <div class="mt-6">
                <label for="whatsappGroup" class="text-xs text-gray-600">Link WhatsApp Grup:</label>
                <div class="flex items-center space-x-2 mt-1">
                    <input type="text" id="whatsappGroup" 
                        value="{{ auth()->user()->whatsapp_link ?? 'https://chat.whatsapp.com/xxxxx' }}"
                        class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-80 focus:ring-blue-500 focus:border-blue-500"
                        disabled>
                    <button id="editWhatsapp" class="px-3 py-2 bg-blue-800 text-white text-xs rounded-lg hover:bg-blue-600 transition">
                        Edit
                    </button>
                </div>
            </div>

            <!-- Daftar Mahasiswa -->
            <h2 class="text-lg font-semibold text-gray-800 mt-6">Daftar Mahasiswa Bimbingan</h2>

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

    <!-- Modal Edit Kuota -->
    <div id="modalKuota" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-lg font-semibold text-gray-800">Edit Kuota Bimbingan</h3>
            <div class="mt-4">
                <label for="editKuotaInput" class="text-xs text-gray-600">Kuota Bimbingan Baru:</label>
                <input type="number" id="editKuotaInput" class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-full mt-2" min="1">
            </div>
            <div class="mt-4 flex justify-end">
                <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600" onclick="saveKuotaEdit()">Simpan</button>
                <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 ml-2" onclick="closeModalKuota()">Batal</button>
            </div>
        </div>
    </div>

    <!-- Modal Edit WhatsApp Link -->
    <div id="modalWhatsapp" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h3 class="text-lg font-semibold text-gray-800">Edit Link WhatsApp</h3>
            <div class="mt-4">
                <label for="editWhatsappInput" class="text-xs text-gray-600">Link WhatsApp Baru:</label>
                <input type="text" id="editWhatsappInput" class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-full mt-2">
            </div>
            <div class="mt-4 flex justify-end">
                <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600" onclick="saveWhatsappEdit()">Simpan</button>
                <button class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 ml-2" onclick="closeModalWhatsapp()">Batal</button>
            </div>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        // Fungsi untuk menyimpan kuota
        document.getElementById('saveKuotaButton').addEventListener('click', function () {
            let kuota = document.getElementById('kuotaBimbingan').value;
            alert(`Kuota Bimbingan berhasil disimpan! Kuota Baru: ${kuota}`);
            toggleEditKuota(false);
        });

        // Fungsi untuk mengaktifkan mode edit kuota
        document.getElementById('editKuotaButton').addEventListener('click', function () {
            toggleEditKuota(true);
        });

        // Fungsi untuk menampilkan dan menyembunyikan tombol edit/save
        function toggleEditKuota(isEdit) {
            document.getElementById('kuotaBimbingan').disabled = !isEdit;
            document.getElementById('editKuotaButton').style.display = isEdit ? 'none' : 'inline-block';
            document.getElementById('saveButtonContainer').style.display = isEdit ? 'block' : 'none';
        }

        // Fungsi untuk menyimpan link WhatsApp
        document.getElementById('editWhatsapp').addEventListener('click', function () {
            document.getElementById('modalWhatsapp').classList.remove('hidden');
            document.getElementById('editWhatsappInput').value = document.getElementById('whatsappGroup').value;
        });

        function saveWhatsappEdit() {
            let newWhatsappLink = document.getElementById('editWhatsappInput').value;
            document.getElementById('whatsappGroup').value = newWhatsappLink;
            document.getElementById('modalWhatsapp').classList.add('hidden');
            alert('Link WhatsApp berhasil diubah!');
        }

        function closeModalWhatsapp() {
            document.getElementById('modalWhatsapp').classList.add('hidden');
        }

        function openModal(deskripsi) {
            document.getElementById('modalText').textContent = deskripsi;
document.getElementById('modalDeskripsi').classList.remove('hidden');
}
           
function closeModal() {
        document.getElementById('modalDeskripsi').classList.add('hidden');
    }

    // Konfirmasi remove mahasiswa
    function confirmRemove(button) {
        document.getElementById('modalRemove').classList.remove('hidden');
    }

    function closeRemoveModal() {
        document.getElementById('modalRemove').classList.add('hidden');
    }

    function removeStudent() {
        alert('Mahasiswa berhasil dihapus!');
        closeRemoveModal();
    }
</script>

@endsection