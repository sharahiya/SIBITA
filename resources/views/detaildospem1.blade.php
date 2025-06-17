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
            <h1 class="text-2xl font-semibold text-gray-800">Detail Dosen Pembimbing</h1>
        </div>

        <h2 class="text-lg font-semibold text-gray-900 mb-2">
            {{ $dosen->nama }}
        </h2>
        <table class="text-sm text-gray-700">
            <tr>
            <td class="pr-4">Bidang</td>
            <td>: {{ $dosen->bidang }}</td>
            </tr>
            <tr>
            <td class="pr-4">Jurusan</td>
            <td>: {{ $dosen->jurusan->nama_jurusan }}</td>
            </tr>
            <tr>
            <td class="pr-4">Fakultas</td>
            <td>: {{ $dosen->fakultas->nama_fakultas }}</td>
            </tr>
            <tr>
            <td class="pr-4">Jumlah Mahasiswa Bimbingan</td>
            <td>: {{ $jumlahMahasiswa }}</td>
            </tr>
        </table>

        <!-- Link WhatsApp Read-Only -->
        <div class="mt-4">
            <label for="whatsappGroup" class="text-xs text-gray-600">Link WhatsApp Grup:</label>
            <div class="flex items-center space-x-3">
                <input type="text"
                    value="{{ $dosen->link_wa_group ?? 'https://chat.whatsapp.com/xxxxx' }}"
                    class="w-80 p-2 text-sm border border-gray-300 bg-gray-100 rounded-md text-gray-700"
                    disabled>
                <a href="{{ $dosen->link_wa_group ?? 'https://chat.whatsapp.com/xxxxx' }}" target="_blank"
                    class="inline-block px-4 py-2 bg-green-500 text-white text-sm rounded-md hover:bg-green-600 transition-all shadow-sm">
                    Buka WhatsApp
                </a>
            </div>
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
                <tbody id="tableMahasiswa">
                    @foreach($ajuanBimbingan as $index => $ajuan)
                    <tr class="bg-white even:bg-gray-50 border-b hover:bg-blue-50">
                        <td class="px-4 py-2 border border-gray-300">{{ $index+1 }}</td>
                        <td class="px-4 py-2 border border-gray-300 font-medium">{{ $ajuan->mahasiswa->nama }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->mahasiswa->npm }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->bidang }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->topik_ta }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            <a href="#" onclick="openModal('{{ $ajuan->deskripsi_ta }}')"
                               class="text-blue-600 hover:underline">Lihat</a>
                        </td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->id_dosen_1 == $dosen->id_dosen ? 'Dospem 1' : 'Dospem 2' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $ajuan->mahasiswa->seminar_status ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Deskripsi -->
<div id="modalDeskripsi" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg mx-4 transform transition-all duration-300">
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

        <div class="mb-6">
            <div class="bg-gray-50 p-4 rounded-lg border">
                <p id="modalText" class="text-gray-700 leading-relaxed text-sm"></p>
            </div>
        </div>

        <div class="flex justify-end">
            <button onclick="closeModal()" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Remove -->
<div id="modalRemove" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform transition-all duration-300">
        <div class="flex items-center justify-center mb-4">
            <div class="bg-red-100 rounded-full p-3">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.924-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
        </div>

        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Konfirmasi Penghapusan</h2>
            <p class="text-gray-600">Apakah Anda yakin ingin menghapus mahasiswa ini dari daftar bimbingan?</p>
        </div>

        <div class="flex space-x-3">
            <button onclick="closeRemoveModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200">
                Batal
            </button>
            <button onclick="removeStudent()" class="flex-1 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-200">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<!-- Modal Success -->
<div id="modalSuccess" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform transition-all duration-300">
        <div class="flex items-center justify-center mb-4">
            <div class="bg-green-100 rounded-full p-3">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Berhasil!</h2>
            <p id="successMessage" class="text-gray-600"></p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-4">
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div id="successProgressBar" class="bg-green-600 h-2 rounded-full transition-all duration-1000 ease-linear" style="width: 0%"></div>
            </div>
            <p class="text-center text-sm text-gray-500 mt-2">
                Halaman akan dimuat ulang dalam <span id="successCountdown">3</span> detik
            </p>
        </div>

        <div class="flex justify-center">
            <button onclick="reloadPageNow()" class="bg-green-600 text-white py-2 px-6 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-all duration-200">
                Muat Ulang Sekarang
            </button>
        </div>
    </div>
</div>

<!-- Modal Error -->
<div id="modalError" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform transition-all duration-300">
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
            <button onclick="closeErrorModal()" class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-all duration-200">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
let pengajuanToRemoveId = null;
let successCountdownInterval = null;
let successProgressInterval = null;

function openModal(deskripsi) {
    document.getElementById('modalText').textContent = deskripsi;
    document.getElementById('modalDeskripsi').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modalDeskripsi').classList.add('hidden');
}

// Konfirmasi remove mahasiswa
function confirmRemove(button) {
    pengajuanToRemoveId = button.getAttribute('data-id');
    document.getElementById('modalRemove').classList.remove('hidden');
}

function closeRemoveModal() {
    document.getElementById('modalRemove').classList.add('hidden');
}

function showSuccessModal(message) {
    document.getElementById('successMessage').textContent = message;
    document.getElementById('modalSuccess').classList.remove('hidden');

    // Start countdown and progress bar
    let timeLeft = 3;
    let progressWidth = 0;

    const countdownElement = document.getElementById('successCountdown');
    const progressBar = document.getElementById('successProgressBar');

    // Update countdown every second
    successCountdownInterval = setInterval(() => {
        timeLeft--;
        countdownElement.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(successCountdownInterval);
            clearInterval(successProgressInterval);
            location.reload();
        }
    }, 1000);

    // Update progress bar smoothly
    successProgressInterval = setInterval(() => {
        progressWidth += 100 / 30; // 30 steps over 3 seconds
        if (progressWidth >= 100) {
            progressWidth = 100;
            clearInterval(successProgressInterval);
        }
        progressBar.style.width = progressWidth + '%';
    }, 100);
}

function showErrorModal(message) {
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('modalError').classList.remove('hidden');
}

function closeErrorModal() {
    document.getElementById('modalError').classList.add('hidden');
}

function reloadPageNow() {
    if (successCountdownInterval) clearInterval(successCountdownInterval);
    if (successProgressInterval) clearInterval(successProgressInterval);
    location.reload();
}

function removeStudent() {
    if (!pengajuanToRemoveId) return;

    // Close remove modal first
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
        showSuccessModal(data.message || 'Mahasiswa berhasil dihapus dari daftar bimbingan.');
    })
    .catch(error => {
        console.error(error);
        showErrorModal('Terjadi kesalahan saat menghapus mahasiswa. Silakan coba lagi.');
    });
}

// Event listener pencarian
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', searchMahasiswa);
    searchInput.addEventListener('input', searchMahasiswa);

    // Close modals when clicking outside
    document.getElementById('modalDeskripsi').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    document.getElementById('modalRemove').addEventListener('click', function(e) {
        if (e.target === this) closeRemoveModal();
    });

    document.getElementById('modalError').addEventListener('click', function(e) {
        if (e.target === this) closeErrorModal();
    });

    document.getElementById('modalSuccess').addEventListener('click', function(e) {
        if (e.target === this) reloadPageNow();
    });

    // ESC key to close modals
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (!document.getElementById('modalDeskripsi').classList.contains('hidden')) {
                closeModal();
            } else if (!document.getElementById('modalRemove').classList.contains('hidden')) {
                closeRemoveModal();
            } else if (!document.getElementById('modalError').classList.contains('hidden')) {
                closeErrorModal();
            } else if (!document.getElementById('modalSuccess').classList.contains('hidden')) {
                reloadPageNow();
            }
        }
    });
});

function searchMahasiswa() {
    const searchInput = document.getElementById('searchInput');
    const filter = searchInput.value.toLowerCase();
    const table = document.getElementById('tableMahasiswa');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const nameCell = rows[i].getElementsByTagName('td')[1];
        const npmCell = rows[i].getElementsByTagName('td')[2];

        if (nameCell && npmCell) {
            const nameText = (nameCell.textContent || nameCell.innerText).toLowerCase();
            const npmText = (npmCell.textContent || npmCell.innerText).toLowerCase();

            if (nameText.indexOf(filter) > -1 || npmText.indexOf(filter) > -1) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
}
</script>

@endsection
