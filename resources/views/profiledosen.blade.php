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
        <p class="text-gray-700 text-sm">Bidang: {{ $dosen->bidang }}</p>

        <!-- Menampilkan Jumlah Bimbingan terlebih dahulu -->
        <div class="mt-6">
            <p class="text-gray-700 text-sm">Jumlah Mahasiswa yang Dibimbing:
                <span id="jumlahMahasiswa" class="font-semibold text-blue-600">{{ $jumlahMahasiswa }}</span>
            </p>
        </div>

        <!-- Kuota Bimbingan -->
        <div class="mt-6">
            <label for="kuotaBimbingan" class="text-xs text-gray-600">Kuota Bimbingan:</label>
            <div class="flex items-center space-x-2 mt-1">
                <input type="number" id="kuotaBimbingan" value="{{ $dosen->kuota_bimbingan }}" min="1"
                    class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-24 focus:ring-blue-500 focus:border-blue-500" disabled>
            </div>
        </div>

        <!-- Tombol Simpan untuk Kuota -->
        <div class="mt-4" id="saveButtonContainer" style="display: none;">
            {{-- <button id="saveKuotaButton" class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-700 text-xs">
                Simpan Kuota
            </button> --}}
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

        <!-- Daftar Mahasiswa -->
        <h2 class="text-lg font-semibold text-gray-800 mt-6">Daftar Mahasiswa Bimbingan</h2>
        <div class="mt-6 mb-4">
            <div class="flex items-center space-x-2">
                <input type="text"
                    id="searchInput"
                    placeholder="Cari mahasiswa berdasarkan nama, NPM, bidang, atau judul TA"
                    class="border border-gray-300 text-gray-700 text-xs rounded-lg p-2 w-64 focus:ring-blue-500 focus:border-blue-500">
            </div>
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
                        <th class="px-4 py-2 border border-gray-300">Action</th>
                    </tr>
                </thead>
                <tbody id="mahasiswaTableBody">
                    <!-- Baris Mahasiswa -->
                    @php
                        $no = 1;
                    @endphp
                    @foreach($ajuanBimbingan as $index => $ajuan)
                    <tr class="bg-white even:bg-gray-50 border-b hover:bg-blue-50">
                        <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">{{ $no++ }}</td>
                        <td class="px-4 py-2 border border-gray-300 font-medium text-gray-900">{{ $ajuan->mahasiswa->nama }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->mahasiswa->npm }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->bidang }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->topik_ta }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            <a href="#" class="text-blue-600 hover:underline" onclick="openModal('{{ $ajuan->deskripsi_ta }}')">Lihat</a>
                        </td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->dosen_ke == '1' ? 'Dospem 1' : 'Dospem 2' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->mahasiswa->seminar_status ?? '-' }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            @if($ajuan->mahasiswa->seminar_status == "Bimbingan")
                            <button class="text-red-600 hover:underline" onclick="confirmRemove(this)" data-id="{{ $ajuan->id_pengajuan }}">
                                Remove
                            </button>
                            @else
                            <span class="text-[10px] text-gray-500 italic">Sudah seminar</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Deskripsi -->
<div id="modalDeskripsi" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
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

<!-- Modal Konfirmasi Remove -->
<div id="modalRemove" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform scale-95 transition-transform duration-300" id="modalRemoveContent">
        <div class="flex items-center justify-center mb-4">
            <div class="bg-red-100 rounded-full p-3">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.924-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
        </div>

        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Konfirmasi Penghapusan</h2>
            <p class="text-gray-600">Apakah Anda yakin ingin menghapus mahasiswa ini dari daftar bimbingan? Tindakan ini tidak dapat dibatalkan.</p>
        </div>

        <div class="flex space-x-3">
            <button onclick="removeStudent()" class="flex-1 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">
                Ya, Hapus
            </button>
            <button onclick="closeRemoveModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200">
                Batal
            </button>
        </div>
    </div>
</div>

<!-- Modal Edit Kuota -->
<div id="modalKuota" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform scale-95 transition-transform duration-300" id="modalKuotaContent">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-3 mr-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Edit Kuota Bimbingan</h2>
            </div>
            <button onclick="closeModalKuota()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="mb-4">
            <label for="editKuotaInput" class="block text-sm font-medium text-gray-700 mb-2">Kuota Bimbingan Baru:</label>
            <input type="number" id="editKuotaInput"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                   min="1" placeholder="Masukkan kuota baru">
            <p class="text-xs text-gray-500 mt-1">Kuota minimal: 1 mahasiswa</p>
        </div>

        <div class="flex space-x-3">
            <button onclick="saveKuotaEdit()" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
                Simpan
            </button>
            <button onclick="closeModalKuota()" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200">
                Batal
            </button>
        </div>
    </div>
</div>

<!-- Modal Edit WhatsApp Link -->
<div id="modalWhatsapp" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform scale-95 transition-transform duration-300" id="modalWhatsappContent">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-3 mr-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">Edit Link WhatsApp</h2>
            </div>
            <button onclick="closeModalWhatsapp()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="mb-4">
            <label for="editWhatsappInput" class="block text-sm font-medium text-gray-700 mb-2">Link WhatsApp Grup:</label>
            <input type="text" id="editWhatsappInput"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                   placeholder="https://chat.whatsapp.com/xxxxx">
            <p class="text-xs text-gray-500 mt-1">Masukkan link grup WhatsApp untuk mahasiswa bimbingan</p>
        </div>

        <div class="flex space-x-3">
            <button onclick="saveWhatsappEdit()" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
                Simpan
            </button>
            <button onclick="closeModalWhatsapp()" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200">
                Batal
            </button>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform scale-95 transition-transform duration-300" id="successModalContent">
        <div class="flex items-center justify-center mb-4">
            <div class="bg-green-100 rounded-full p-3 animate-pulse">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Berhasil!</h2>
            <p id="successMessage" class="text-gray-600"></p>
        </div>

        <div class="flex justify-center">
            <button onclick="closeSuccessModal()" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
                OK
            </button>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform scale-95 transition-transform duration-300" id="errorModalContent">
        <div class="flex items-center justify-center mb-4">
            <div class="bg-red-100 rounded-full p-3">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
        </div>

        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Terjadi Kesalahan</h2>
            <p id="errorMessage" class="text-gray-600"></p>
        </div>

        <div class="flex justify-center">
            <button onclick="closeErrorModal()" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">
                OK
            </button>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loadingModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-4">
        <div class="flex items-center justify-center">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mr-3"></div>
            <span class="text-gray-700 font-medium">Memproses...</span>
        </div>
    </div>
</div>

<style>
    /* Animation classes */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: scale(0.8) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .animate-slideIn {
        animation: slideIn 0.3s ease-out;
    }
</style>

<!-- Script JavaScript -->
<script>
    let pengajuanToRemoveId = null;

    // Utility functions for modals
    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector('div > div');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100', 'animate-slideIn');
        }, 10);
    }

    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector('div > div');

        modalContent.classList.add('scale-95');
        modalContent.classList.remove('scale-100');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function showSuccessModal(message) {
        document.getElementById('successMessage').textContent = message;
        showModal('successModal');
    }

    function closeSuccessModal() {
        hideModal('successModal');
    }

    function showErrorModal(message) {
        document.getElementById('errorMessage').textContent = message;
        showModal('errorModal');
    }

    function closeErrorModal() {
        hideModal('errorModal');
    }

    function showLoadingModal() {
        document.getElementById('loadingModal').classList.remove('hidden');
    }

    function hideLoadingModal() {
        document.getElementById('loadingModal').classList.add('hidden');
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const tbody = document.getElementById('mahasiswaTableBody');
        const rows = tbody.getElementsByTagName('tr');

        for (let row of rows) {
            const nama = row.getElementsByTagName('td')[1].textContent.toLowerCase();
            const npm = row.getElementsByTagName('td')[2].textContent.toLowerCase();
            const bidang = row.getElementsByTagName('td')[3].textContent.toLowerCase();
            const topik = row.getElementsByTagName('td')[4].textContent.toLowerCase();

            if (nama.includes(searchValue) ||
                npm.includes(searchValue) ||
                bidang.includes(searchValue) ||
                topik.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });

    // WhatsApp edit functionality
    document.getElementById('editWhatsapp').addEventListener('click', function () {
        document.getElementById('editWhatsappInput').value = document.getElementById('whatsappGroup').value;
        showModal('modalWhatsapp');
    });

    function closeModalWhatsapp() {
        hideModal('modalWhatsapp');
    }

    function saveWhatsappEdit() {
        let newWhatsappLink = document.getElementById('editWhatsappInput').value;

        if (!newWhatsappLink.trim()) {
            showErrorModal('Link WhatsApp tidak boleh kosong!');
            return;
        }

        showLoadingModal();

        fetch("{{ route('dosen.updateWhatsapp') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ link: newWhatsappLink })
        })
        .then(response => response.json())
        .then(data => {
            hideLoadingModal();
            document.getElementById('whatsappGroup').value = newWhatsappLink;
            closeModalWhatsapp();
            showSuccessModal(data.message || 'Link WhatsApp berhasil diubah!');
        })
        .catch(error => {
            hideLoadingModal();
            console.error('Error:', error);
            showErrorModal('Terjadi kesalahan saat menyimpan link WhatsApp.');
        });
    }

    // Description modal
    function openModal(deskripsi) {
        document.getElementById('modalText').textContent = deskripsi;
        showModal('modalDeskripsi');
    }

    function closeModal() {
        hideModal('modalDeskripsi');
    }

    // Remove student functionality
    function confirmRemove(button) {
        pengajuanToRemoveId = button.getAttribute('data-id');
        showModal('modalRemove');
    }

    function closeRemoveModal() {
        hideModal('modalRemove');
    }

    function removeStudent() {
        if (!pengajuanToRemoveId) return;

        showLoadingModal();
        closeRemoveModal();

        fetch(`/bimbingan/remove/${pengajuanToRemoveId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Gagal menghapus');
            return response.json();
        })
        .then(data => {
            hideLoadingModal();
            showSuccessModal(data.message || 'Mahasiswa berhasil dihapus dari daftar bimbingan.');

            // Auto reload after 2 seconds
            setTimeout(() => {
                location.reload();
            }, 2000);
        })
        .catch(error => {
            hideLoadingModal();
            console.error(error);
            showErrorModal('Terjadi kesalahan saat menghapus mahasiswa.');
        });
    }

    // Kuota modal functionality (if needed)
    function closeModalKuota() {
        hideModal('modalKuota');
    }

    function saveKuotaEdit() {
        let kuota = document.getElementById('editKuotaInput').value;

        if (!kuota || kuota < 1) {
            showErrorModal('Kuota harus berupa angka positif!');
            return;
        }

        showLoadingModal();

        fetch("{{ route('dosen.updateKuota') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ kuota: kuota })
        })
        .then(response => response.json())
        .then(data => {
            hideLoadingModal();
            document.getElementById('kuotaBimbingan').value = kuota;
            closeModalKuota();
            showSuccessModal(data.message || 'Kuota bimbingan berhasil diubah!');
        })
        .catch(error => {
            hideLoadingModal();
            console.error('Error:', error);
            showErrorModal('Terjadi kesalahan saat menyimpan kuota.');
        });
    }

    // Close modals when clicking outside
    document.addEventListener('click', function(e) {
        const modals = ['modalDeskripsi', 'modalRemove', 'modalKuota', 'modalWhatsapp'];

        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (e.target === modal) {
                hideModal(modalId);
            }
        });
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modals = ['modalDeskripsi', 'modalRemove', 'modalKuota', 'modalWhatsapp', 'successModal', 'errorModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (!modal.classList.contains('hidden')) {
                    hideModal(modalId);
                }
            });
        }
    });
</script>

@endsection
