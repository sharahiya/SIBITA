@extends('layouts.layoutdosen')

@section('content')
<style>
    .notification-container {
        max-height: 490px;
        overflow-y: auto;
    }
    .notification-item {
        padding: 12px;
        border-radius: 8px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        background: #D6E6F2;
    }
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 50;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(4px);
        animation: fadeIn 0.3s ease-out;
    }
    .modal.show {
        display: flex;
    }
    .modal-content {
        transform: scale(0.9);
        opacity: 0;
        animation: modalShow 0.3s ease-out forwards;
    }
    .modal.show .modal-content {
        transform: scale(1);
        opacity: 1;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes modalShow {
        from { 
            transform: scale(0.9);
            opacity: 0;
        }
        to { 
            transform: scale(1);
            opacity: 1;
        }
    }
    .modal-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
    }
</style>

<div class="container mx-auto px-4 pt-4">
    <div class="bg-white p-4 shadow-lg rounded-lg w-full max-w-3xl mx-auto">
        <div class="text-center mb-4">
            <h1 class="text-lg font-semibold text-gray-800">Notifikasi</h1>
        </div>
        
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded text-sm text-center my-2">
                {{ session('success') }}
            </div>
        @endif
        
        @if($notifikasis->isNotEmpty())
        <div class="flex justify-end gap-2 mb-4">
            <button onclick="showConfirmModal('Tandai semua notifikasi sebagai sudah dibaca?', 'markAllRead')" 
                    class="bg-green-600 text-white text-sm px-3 py-1 rounded hover:bg-green-700 transition">
                Tandai Sudah Dibaca
            </button>

            <button onclick="showConfirmModal('Yakin ingin menghapus semua notifikasi?', 'deleteAll')" 
                    class="bg-red-600 text-white text-sm px-3 py-1 rounded hover:bg-red-700 transition">
                Hapus Semua
            </button>
        </div>
        @endif
        
        <div class="space-y-3 notification-container" id="notifContainer">
            @forelse($notifikasis as $index => $notif)
                @php
                    $tanggal = \Carbon\Carbon::parse($notif->tanggal_kirim)->translatedFormat('d F Y');
                    $isUnread = $notif->status_baca === 'belum';
                    $bgClass = $isUnread ? 'bg-yellow-100 font-semibold' : 'bg-gray-100';
                    $tipe = $notif->tipe_notifikasi ?? 'Umum';
                    $pesan = $notif->pesan ?? '';
                    $notifId = $notif->id_notifikasi;
                @endphp
                <div class="p-4 rounded-lg shadow-sm {{ $bgClass }} flex justify-between items-start gap-4">
                    <div class="flex-1">
                        <p class="text-gray-800 text-sm font-medium">{{ $pesan }}</p>
                        <p class="text-gray-500 text-xs italic mt-1">{{ $tipe }} • {{ $tanggal }}</p>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <button onclick="handleClick({{ $index }})"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 text-xs rounded transition">
                            🔍 Lihat
                        </button>
                        @if($isUnread)
                            <form action="{{ route('notifikasi.baca.satu', $notifId) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 text-xs hover:underline">Tandai Dibaca</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm text-center py-4">🚫 Tidak ada notifikasi.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="modalConfirm" class="modal">
    <div class="modal-backdrop" onclick="closeModal('modalConfirm')"></div>
    <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 relative">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div id="confirmIcon" class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Tindakan</h3>
                    <p class="text-sm text-gray-500">Pastikan tindakan yang akan dilakukan</p>
                </div>
            </div>
            <button onclick="closeModal('modalConfirm')" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div id="confirmAlert" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p id="confirmMessage" class="text-sm text-yellow-800"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex gap-3 p-6 bg-gray-50 rounded-b-2xl">
            <button onclick="closeModal('modalConfirm')" 
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-3 rounded-lg transition-colors font-medium">
                Batal
            </button>
            <button id="confirmButton" 
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg transition-colors font-medium">
                Ya, Lanjutkan
            </button>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="modalSuccess" class="modal">
    <div class="modal-backdrop" onclick="closeModal('modalSuccess')"></div>
    <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 relative">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Berhasil</h3>
                    <p class="text-sm text-gray-500">Tindakan berhasil dilakukan</p>
                </div>
            </div>
            <button onclick="closeModal('modalSuccess')" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p id="successMessage" class="text-sm text-green-800"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex gap-3 p-6 bg-gray-50 rounded-b-2xl">
            <button onclick="closeModal('modalSuccess')" 
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition-colors font-medium">
                OK
            </button>
        </div>
    </div>
</div>

<!-- Info Modal for Notification Details -->
<div id="modalInfo" class="modal">
    <div class="modal-backdrop" onclick="closeModal('modalInfo')"></div>
    <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 relative">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Detail Notifikasi</h3>
                    <p class="text-sm text-gray-500">Informasi lengkap notifikasi</p>
                </div>
            </div>
            <button onclick="closeModal('modalInfo')" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Content -->
        <div class="p-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div>
                        <h4 class="text-sm font-medium text-blue-800 mb-2">Pesan:</h4>
                        <p id="infoMessage" class="text-sm text-blue-700 mb-3"></p>
                        <h4 class="text-sm font-medium text-blue-800 mb-1">Tipe:</h4>
                        <p id="infoType" class="text-sm text-blue-700"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex gap-3 p-6 bg-gray-50 rounded-b-2xl">
            <button onclick="closeModal('modalInfo')" 
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-3 rounded-lg transition-colors font-medium">
                Tutup
            </button>
            <button id="infoActionButton" 
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition-colors font-medium">
                Lihat Detail
            </button>
        </div>
    </div>
</div>

<!-- Hidden forms for actions -->
<form id="markAllReadForm" action="{{ route('notifikasi.baca.semua') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="id_user" value="{{ $dosenId }}">
</form>

<form id="deleteAllForm" action="{{ route('notifikasi.hapus.semua') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="id_user" value="{{ $dosenId }}">
</form>

<script>
    let notifikasi = @json($notifikasis);

    function getRedirectUrl(tipe) {
        const routes = {
            "Pengajuan Bimbingan": "/requestdosen",
            "Pengajuan Seminar Proposal": "/requestdosen",
            "Pengajuan Seminar Hasil": "/requestdosen",
            "Pengajuan Proposal": "/requestdosen",
            "Pengajuan Hasil": "/requestdosen",
            "Pengajuan Sidang": "/requestdosen",
        };

        return routes[tipe] || "/dosen/dashboard";
    }

    function handleClick(index) {
        const notif = notifikasi[index];
        
        // Show info modal with notification details
        document.getElementById('infoMessage').innerText = notif.pesan || 'Tidak ada pesan';
        document.getElementById('infoType').innerText = notif.tipe_notifikasi || 'Umum';
        
        // Set up action button
        const actionButton = document.getElementById('infoActionButton');
        actionButton.onclick = function() {
            closeModal('modalInfo');
            
            const redirectUrl = getRedirectUrl(notif.tipe_notifikasi);
            fetch(`/notifikasi/baca/${notif.id_notifikasi}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            }).then(() => {
                window.location.href = redirectUrl;
            }).catch(error => {
                console.error('Error marking notification as read:', error);
                showSuccessModal('Terjadi kesalahan saat memproses notifikasi');
            });
        };
        
        showModal('modalInfo');
    }

    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function showConfirmModal(message, action) {
        document.getElementById('confirmMessage').innerText = message;
        
        const confirmButton = document.getElementById('confirmButton');
        const confirmAlert = document.getElementById('confirmAlert');
        const confirmIcon = document.getElementById('confirmIcon');
        
        confirmButton.onclick = function() {
            if (action === 'markAllRead') {
                document.getElementById('markAllReadForm').submit();
            } else if (action === 'deleteAll') {
                document.getElementById('deleteAllForm').submit();
            }
            closeModal('modalConfirm');
        };

        // Update button color and alert style based on action
        if (action === 'deleteAll') {
            confirmButton.className = "flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg transition-colors font-medium";
            confirmButton.textContent = "Ya, Hapus";
            confirmAlert.className = "bg-red-50 border border-red-200 rounded-lg p-4 mb-6";
            confirmIcon.innerHTML = `
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
            `;
        } else {
            confirmButton.className = "flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition-colors font-medium";
            confirmButton.textContent = "Ya, Tandai";
            confirmAlert.className = "bg-green-50 border border-green-200 rounded-lg p-4 mb-6";
            confirmIcon.innerHTML = `
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            `;
        }

        showModal('modalConfirm');
    }

    function showSuccessModal(message) {
        document.getElementById('successMessage').innerText = message;
        showModal('modalSuccess');
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal-backdrop')) {
            const modal = event.target.closest('.modal');
            if (modal) {
                closeModal(modal.id);
            }
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const openModal = document.querySelector('.modal.show');
            if (openModal) {
                closeModal(openModal.id);
            }
        }
    });

    // Check for success message from session
    @if(session('success'))
        setTimeout(() => {
            showSuccessModal('{{ session('success') }}');
        }, 500);
    @endif
</script>
@endsection
