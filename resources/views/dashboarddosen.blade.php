@extends('layouts.layoutdosen')
@section('content')
    <div class="container mx-auto px-4 pt-4">
        <!-- Header -->
        <div class="bg-white p-5 shadow-md rounded-lg w-full max-w-5xl mx-auto">
            <h1 class="text-xl font-semibold text-gray-800">Dashboard Dosen</h1>
            <p class="text-gray-600 text-sm">Selamat datang, {{ $dosen->nama }}</p>
        </div>

        <!-- Statistik Kartu -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4 max-w-5xl mx-auto">
            <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
                <h2 class="text-base font-semibold">Mahasiswa Bimbingan</h2>
                <p class="text-xl font-bold">{{ $bimbinganCount }}</p>
            </div>
            <div class="bg-emerald-500 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
                <h2 class="text-base font-semibold">Selesai Sempro</h2>
                <p class="text-xl font-bold">{{ $selesaiSempro }}</p>
            </div>
            <div class="bg-yellow-400 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
                <h2 class="text-base font-semibold">Selesai Semhas</h2>
                <p class="text-xl font-bold">{{ $selesaiSemhas }}</p>
            </div>
            <div class="bg-red-500 text-white p-4 rounded-lg shadow-md hover:scale-105 transition">
                <h2 class="text-base font-semibold">Selesai Sidang</h2>
                <p class="text-xl font-bold">{{ $selesaiSidang }}</p>
            </div>
        </div>

        <!-- Jadwal Dosen sebagai Penguji/Dospem -->
        <div class="bg-white p-5 shadow-md rounded-lg mt-6 max-w-5xl mx-auto animate-fadeIn">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Jadwal Saya</h2>
            <div class="overflow-y-auto max-h-60">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-5 py-3">Nama Mahasiswa</th>
                            <th class="px-5 py-3">NPM</th>
                            <th class="px-5 py-3">Jenis Ujian</th>
                            <th class="px-5 py-3">Judul TA</th>
                            <th class="px-5 py-3">Peran</th>
                            <th class="px-5 py-3">Tanggal</th>
                            <th class="px-5 py-3">Waktu</th>
                            <th class="px-5 py-3">Ruangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwalSaya as $jadwal)
                        <tr class="bg-white border-b hover:bg-gray-50 transition duration-300">
                            <td class="px-5 py-3">{{ $jadwal->mahasiswa->nama }}</td>
                            <td class="px-5 py-3">{{ $jadwal->mahasiswa->npm }}</td>
                            <td class="px-5 py-3">{{ $jadwal->jenis_ujian }}</td>
                            <td class="px-5 py-3">{{ $jadwal->topik_ta }}</td>
                            <td class="px-5 py-3">{{ $jadwal->peran }}</td>
                            <td class="px-5 py-3">{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d F Y') }}</td>
                            <td class="px-5 py-3">{{ $jadwal->jam }}</td>
                            <td class="px-5 py-3">{{ $jadwal->ruangan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Ganti Password (Wajib) -->
    @if($mustChangePassword)
    <div id="changePasswordModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
            <div class="flex items-center justify-center mb-4">
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.924-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>

            <div class="text-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Ganti Password</h2>
                <p class="text-gray-600 text-sm">Untuk keamanan akun, Anda harus mengganti password default terlebih dahulu sebelum melanjutkan.</p>
            </div>

            <form id="changePasswordForm">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                        <input type="password" name="current_password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Masukkan password lama (NIP Anda)">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" name="new_password" required minlength="6"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Masukkan password baru (min. 6 karakter)">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" required minlength="6"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Ulangi password baru">
                    </div>
                </div>

                <!-- Error Messages -->
                <div id="errorMessages" class="hidden mt-4 p-3 bg-red-100 border border-red-300 rounded-md">
                    <ul class="text-sm text-red-600 list-disc list-inside"></ul>
                </div>

                <!-- Loading -->
                <div id="loading" class="hidden mt-4 text-center">
                    <div class="inline-flex items-center">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600 mr-2"></div>
                        <span class="text-sm text-gray-600">Mengubah password...</span>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        Ganti Password
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

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
                <p id="successMessage" class="text-gray-600">Password berhasil diubah! Halaman akan dimuat ulang dalam beberapa detik.</p>
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

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

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

    <script>
        // Modal utility functions
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
            
            // Auto reload after 3 seconds
            setTimeout(() => {
                window.location.reload();
            }, 3000);
        }

        function closeSuccessModal() {
            hideModal('successModal');
            window.location.reload();
        }

        function showErrorModal(message) {
            document.getElementById('errorMessage').textContent = message;
            showModal('errorModal');
        }

        function closeErrorModal() {
            hideModal('errorModal');
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if($mustChangePassword)
            const form = document.getElementById('changePasswordForm');
            const errorDiv = document.getElementById('errorMessages');
            const loading = document.getElementById('loading');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Hide previous errors
                errorDiv.classList.add('hidden');
                loading.classList.remove('hidden');

                const formData = new FormData(form);

                fetch('{{ route("dosen.change-password") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    loading.classList.add('hidden');

                    if (data.success) {
                        // Success - show success modal
                        showSuccessModal('Password berhasil diubah! Halaman akan dimuat ulang.');
                    } else {
                        // Show errors in error modal
                        showErrorModal(data.message || 'Terjadi kesalahan saat mengubah password.');
                    }
                })
                .catch(error => {
                    loading.classList.add('hidden');
                    console.error('Error:', error);
                    showErrorModal('Terjadi kesalahan sistem. Silakan coba lagi.');
                });
            });

            function showErrors(message) {
                const errorList = errorDiv.querySelector('ul');
                errorList.innerHTML = `<li>${message}</li>`;
                errorDiv.classList.remove('hidden');
            }

            // Prevent closing modal by clicking outside or ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    e.preventDefault();
                }
            });
            @endif

            // Close modals when clicking outside (except for mandatory password change)
            document.addEventListener('click', function(e) {
                const modals = ['successModal', 'errorModal'];
                
                modals.forEach(modalId => {
                    const modal = document.getElementById(modalId);
                    if (e.target === modal) {
                        hideModal(modalId);
                    }
                });
            });

            // Close modals with Escape key (except for mandatory password change)
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const modals = ['successModal', 'errorModal'];
                    modals.forEach(modalId => {
                        const modal = document.getElementById(modalId);
                        if (!modal.classList.contains('hidden')) {
                            hideModal(modalId);
                        }
                    });
                }
            });
        });
    </script>

@endsection
