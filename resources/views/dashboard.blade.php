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
        </div>
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

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slide-in {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .animate-fade-in {
        animation: fade-in 1s ease-out;
    }

    .animate-slide-in {
        animation: slide-in 1s ease-out;
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
                    // Success - reload page
                    alert('Password berhasil diubah! Halaman akan dimuat ulang.');
                    window.location.reload();
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
    });
</script>

@endsection
