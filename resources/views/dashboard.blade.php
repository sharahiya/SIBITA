@extends('layouts.layoutmhs')
@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-1">
    <div class="flex items-center space-x-4">
        @php
        $user = Auth::guard('mahasiswa')->user();
        $firstName = explode(' ', $user->nama)[0];
    @endphp

        <span class="w-14 h-14 flex items-center justify-center text-white bg-blue-400 rounded-full text-2xl">
            {{ strtoupper(substr($firstName, 0, 1)) }}
        </span>
        <div>
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-x-2">
                Hi, {{ $mahasiswa->nama }}!
            </h2>
        </div>
    </div>

    <!-- Grid dengan 2 kolom untuk informasi mahasiswa -->
    <div class="mt-4 grid grid-cols-[30px_auto] gap-y-2 items-center">
        <i class="text-gray-500 fas fa-id-card"></i>
        <p class="text-sm text-gray-600">NPM : {{ $mahasiswa->npm }}</p>

        <i class="text-gray-500 fas fa-calendar-alt"></i>
        <p class="text-sm text-gray-600">Semester Sajian : Genap 2024/2025</p>

        <i class="text-gray-500 fas fa-chalkboard-teacher"></i>
        <p class="text-sm text-gray-600">Dosen Wali : {{ $mahasiswa->dosenWali->nama ?? 'Belum ditentukan' }}</p>

        <i class="text-gray-500 fas fa-id-badge"></i>
        <p class="text-sm text-gray-600">NIP Dosen Wali : {{ $mahasiswa->dosenWali->nip ?? '-' }}</p>
    </div>

    <!-- Informasi Dospem & Penguji -->
    <div class="mt-6">
        <h2 class="text-md font-semibold text-gray-800">Dosen Pembimbing & Penguji</h2>
        <div class="grid grid-cols-2 gap-4 mt-2">
            <!-- Dospem 1 -->
            <div class="bg-gray-50 p-3 rounded-md flex items-center gap-2">
                <i class="text-gray-600 fas fa-user-tie"></i>
                <div>
                    <h3 class="text-sm text-gray-700">Dospem 1</h3>
                    @if (!$dospem1)
                        <p class="text-xs text-gray-500">Belum ada data - <a href="{{ route('pengajuan') }}" class="text-blue-600">Ajukan</a></p>
                    @elseif ($dospem1->getPengajuanByMahasiswaId($mahasiswa->id_mahasiswa)[0]->status == 'pending')
                        <p class="text-xs text-yellow-600 italic">Menunggu persetujuan</p>
                    @elseif ($dospem1->getPengajuanByMahasiswaId($mahasiswa->id_mahasiswa)[0]->status == 'ditolak')
                        <p class="text-xs text-red-600">Ditolak - <a href="{{ route('pengajuan') }}" class="text-blue-600">Ajukan ulang</a></p>
                    @elseif ($dospem1->getPengajuanByMahasiswaId($mahasiswa->id_mahasiswa)[0]->status == 'diterima')
                        <p class="text-xs text-green-600 font-medium">{{ $dospem1->nama }}</p>
                    @endif
                </div>
            </div>

            <!-- Dospem 2 -->
            <div class="bg-gray-50 p-3 rounded-md flex items-center gap-2">
                <i class="text-gray-600 fas fa-user-tie"></i>
                <div>
                    <h3 class="text-sm text-gray-700">Dospem 2</h3>
                    @if (!$dospem2)
                        <p class="text-xs text-gray-500">Belum ada data - <a href="{{ route('pengajuan') }}" class="text-blue-600">Ajukan</a></p>
                    @elseif ($dospem2->getPengajuanByMahasiswaId($mahasiswa->id_mahasiswa)[0]->status == 'pending')
                        <p class="text-xs text-yellow-600 italic">Menunggu persetujuan</p>
                    @elseif ($dospem2->getPengajuanByMahasiswaId($mahasiswa->id_mahasiswa)[0]->status == 'ditolak')
                        <p class="text-xs text-red-600">Ditolak - <a href="{{ route('pengajuan') }}" class="text-blue-600">Ajukan ulang</a></p>
                    @elseif ($dospem2->getPengajuanByMahasiswaId($mahasiswa->id_mahasiswa)[0]->status == 'diterima')
                        <p class="text-xs text-green-600 font-medium">{{ $dospem2->nama }}</p>
                    @endif
                </div>
            </div>

            <!-- Penguji 1 -->
            <div class="bg-gray-50 p-3 rounded-md flex items-center gap-2">
                <i class="text-gray-600 fas fa-user-check"></i>
                <div>
                    <h3 class="text-sm text-gray-700">Penguji 1</h3>
                    @if (!$penguji1)
                        <p class="text-xs text-gray-500">Belum ada data</p>
                    @else
                        <p class="text-xs text-green-600 font-medium">{{ $penguji1->dosen->nama }}</p>
                    @endif
                </div>
            </div>

            <!-- Penguji 2 -->
            <div class="bg-gray-50 p-3 rounded-md flex items-center gap-2">
                <i class="text-gray-600 fas fa-user-check"></i>
                <div>
                    <h3 class="text-sm text-gray-700">Penguji 2</h3>
                    @if (!$penguji2)
                        <p class="text-xs text-gray-500">Belum ada data</p>
                    @else
                        <p class="text-xs text-green-600 font-medium">{{ $penguji2->dosen->nama }}</p>
                    @endif
                </div>
            </div>

            <!-- Penguji 3 (Opsional) - Tampilkan jika ada -->
            @if ($penguji3)
            <div class="bg-gray-50 p-3 rounded-md flex items-center gap-2 {{ $penguji1 && $penguji2 ? 'col-span-2' : '' }}">
                <i class="text-gray-600 fas fa-user-check"></i>
                <div>
                    <h3 class="text-sm text-gray-700">
                        Penguji 3
                        <span class="text-gray-500 text-xs">(Opsional)</span>
                    </h3>
                    <p class="text-xs text-green-600 font-medium">{{ $penguji3->dosen->nama }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Indikator status penguji -->
        @if ($penguji1 && $penguji2)
            <div class="mt-3 p-2 bg-green-50 border border-green-200 rounded-md">
                <div class="flex items-center gap-2">
                    <i class="text-green-600 fas fa-check-circle text-sm"></i>
                    <p class="text-xs text-green-700">
                        Tim penguji lengkap
                        @if ($penguji3)
                            (termasuk penguji 3 opsional)
                        @endif
                    </p>
                </div>
            </div>
        @elseif ($penguji1 || $penguji2)
            <div class="mt-3 p-2 bg-yellow-50 border border-yellow-200 rounded-md">
                <div class="flex items-center gap-2">
                    <i class="text-yellow-600 fas fa-clock text-sm"></i>
                    <p class="text-xs text-yellow-700">
                        Tim penguji belum lengkap - Menunggu penetapan koordinator TA
                    </p>
                </div>
            </div>
        @else
            <div class="mt-3 p-2 bg-gray-50 border border-gray-200 rounded-md">
                <div class="flex items-center gap-2">
                    <i class="text-gray-500 fas fa-info-circle text-sm"></i>
                    <p class="text-xs text-gray-600">
                        Tim penguji belum ditetapkan
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-5 mt-8">
    <h2 class="text-lg font-bold text-gray-800 mb-6 text-center">📌 Status Mahasiswa</h2>
    @if(count($status))
        <ol class="relative border-s border-gray-200">
            @foreach($status as $item)
                <li class="mb-6 ms-3">
                    <div class="absolute w-2 h-2 bg-gray-300 rounded-full mt-1.5 -start-1 border border-white"></div>
                    <time class="text-xs text-gray-400">{{ $item['tanggal'] }}</time>
                    <h3 class="text-md font-semibold text-gray-900">{{ $item['judul'] }}</h3>
                    <p class="text-xs text-gray-500">{{ $item['deskripsi'] }}</p>
                </li>
            @endforeach
        </ol>
    @else
        <p class="text-center text-gray-500 text-sm">Belum ada progress yang dicatat.</p>
    @endif
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
                           placeholder="Masukkan password lama (NPM Anda)">
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

<!-- Modal Success Password Changed -->
<div id="successPasswordModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform transition-all duration-300 scale-95">
        <div class="flex items-center justify-center mb-4">
            <div class="bg-green-100 rounded-full p-3">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Password Berhasil Diubah!</h2>
            <p class="text-gray-600 text-sm">Password Anda telah berhasil diperbarui. Halaman akan dimuat ulang dalam beberapa detik.</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-4">
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div id="progressBar" class="bg-green-600 h-2 rounded-full transition-all duration-1000 ease-linear" style="width: 0%"></div>
            </div>
            <p class="text-center text-sm text-gray-500 mt-2">
                <span id="countdown">3</span> detik
            </p>
        </div>

        <div class="flex space-x-3">
            <button id="reloadNowBtn" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
                Muat Ulang Sekarang
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slide-in {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes modal-appear {
        from { opacity: 0; transform: scale(0.9) translateY(-20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }

    .animate-slide-in {
        animation: slide-in 1s ease-out;
    }

    .animate-modal-appear {
        animation: modal-appear 0.3s ease-out;
    }

    .delay-100 { animation-delay: 0.2s; }
    .delay-200 { animation-delay: 0.4s; }
    .delay-300 { animation-delay: 0.6s; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($mustChangePassword)
        const form = document.getElementById('changePasswordForm');
        const errorDiv = document.getElementById('errorMessages');
        const loading = document.getElementById('loading');
        const changePasswordModal = document.getElementById('changePasswordModal');
        const successPasswordModal = document.getElementById('successPasswordModal');

        // Success modal elements
        const progressBar = document.getElementById('progressBar');
        const countdown = document.getElementById('countdown');
        const reloadNowBtn = document.getElementById('reloadNowBtn');

        let countdownInterval;
        let progressInterval;

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Hide previous errors
            errorDiv.classList.add('hidden');
            loading.classList.remove('hidden');

            const formData = new FormData(form);

            fetch('{{ route("mahasiswa.change-password") }}', {
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
                    // Hide change password modal
                    changePasswordModal.classList.add('hidden');

                    // Show success modal with animation
                    showSuccessModal();
                } else {
                    // Show errors
                    showErrors(data.message || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                loading.classList.add('hidden');
                console.error('Error:', error);
                showErrors('Terjadi kesalahan sistem');
            });
        });

        function showSuccessModal() {
            successPasswordModal.classList.remove('hidden');
            const modalContent = successPasswordModal.querySelector('.bg-white');
            modalContent.classList.add('animate-modal-appear');

            // Start countdown and progress bar
            let timeLeft = 3;
            let progressWidth = 0;

            // Update countdown every second
            countdownInterval = setInterval(() => {
                timeLeft--;
                countdown.textContent = timeLeft;

                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    clearInterval(progressInterval);
                    window.location.reload();
                }
            }, 1000);

            // Update progress bar smoothly
            progressInterval = setInterval(() => {
                progressWidth += 100 / 30; // 30 steps over 3 seconds
                if (progressWidth >= 100) {
                    progressWidth = 100;
                    clearInterval(progressInterval);
                }
                progressBar.style.width = progressWidth + '%';
            }, 100);

            // Reload now button
            reloadNowBtn.addEventListener('click', function() {
                clearInterval(countdownInterval);
                clearInterval(progressInterval);
                window.location.reload();
            });
        }

        function showErrors(message) {
            const errorList = errorDiv.querySelector('ul');
            errorList.innerHTML = `<li>${message}</li>`;
            errorDiv.classList.remove('hidden');
        }

        // Prevent closing modal by clicking outside or ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !successPasswordModal.classList.contains('hidden')) {
                // Allow ESC to reload immediately if success modal is shown
                clearInterval(countdownInterval);
                clearInterval(progressInterval);
                window.location.reload();
            } else if (e.key === 'Escape') {
                e.preventDefault();
            }
        });

        // Prevent closing success modal by clicking outside
        successPasswordModal.addEventListener('click', function(e) {
            if (e.target === successPasswordModal) {
                // Click outside closes and reloads immediately
                clearInterval(countdownInterval);
                clearInterval(progressInterval);
                window.location.reload();
            }
        });
        @endif
    });
</script>

@endsection
