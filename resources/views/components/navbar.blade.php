<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            poppins: ["Poppins", "sans-serif"]
          }
        }
      }
    };
  </script>
</head>
<body class="font-poppins">

  <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 border-b border-gray-200 dark:border-gray-600">
    <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">
      <a href="#" class="flex items-center space-x-3">
        <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo">
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">SIBITA</span>
      </a>

      <!-- Mobile Menu Button -->
      <button id="mobile-menu-button" class="md:hidden text-gray-800 dark:text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>

      <!-- Desktop Menu -->
      <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2">
        <ul class="flex space-x-8 text-sm">
          <li><a href="{{ route('dashboard') }}" class=" text-blue-700 dark:text-white">Dashboard</a></li>
          <li>
            <a href="{{ $hasPembimbing ? route('pengajuan2') : route('pengajuan') }}" class=" text-gray-900 dark:text-white hover:text-blue-700">
              Pembimbing
            </a>
          </li>
          <li><a href="{{ route('upload.index') }}" class=" text-gray-900 dark:text-white hover:text-blue-700">Berkas</a></li>
          <li><a href="{{ route('penjadwalanmhs') }}" class=" text-gray-900 dark:text-white hover:text-blue-700">Penjadwalan</a></li>
          <li><a href="{{ route('daftardosen') }}" class=" text-gray-900 dark:text-white hover:text-blue-700">Daftar Dosen</a></li>
        </ul>
      </div>

      <!-- User Profile and Notifications -->
      <div class="flex items-center space-x-4">
        <!-- Notifikasi Icon -->
        <a href="{{ route('notifikasi') }}" class="relative">
          <svg class="w-6 h-6 text-gray-800 dark:text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6 6 0 00-12 0v3c0 .386-.146.75-.405 1.045L4 17h5m6 0a3 3 0 11-6 0"></path>
          </svg>
          @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
            <span class="absolute top-0 right-0 inline-block min-w-[1rem] h-4 text-xs text-white bg-red-600 rounded-full text-center px-1">
                {{ $unreadNotifCount }}
            </span>
        @endif
        </a>

        <!-- Profil User -->
        <div class="relative">
          <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button">
            @php
                $user = Auth::guard('mahasiswa')->user();
                $firstName = explode(' ', $user->nama)[0];
            @endphp

                <span class="w-8 h-8 flex items-center justify-center text-white bg-blue-400 rounded-full">
                    {{ strtoupper(substr($firstName, 0, 1)) }}
                </span>
          </button>

          <div class="absolute right-0 top-full mt-2 z-50 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
            <div class="px-4 py-3">
              <span class="block text-sm text-gray-900 dark:text-white">{{ $user->nama }}</span>
              <span class="block text-sm text-gray-500 dark:text-gray-400">{{ $user->npm }}</span>
            </div>
            <ul class="py-2">
              <li>
                <button id="openResetPasswordModal" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                  Reset Password
                </button>
              </li>
              <li>
                <button id="openResetPasswordModalMobile" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600 md:hidden">
                  Reset Password
                </button>
              </li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                  Sign out
                </button>
              </form>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar" class="fixed top-0 left-0 w-64 h-full bg-white dark:bg-gray-900 shadow-lg transform -translate-x-full transition-transform z-40">
      <div class="p-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-600">
        <a href="#" class="flex items-center space-x-3">
          <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo" />
          <span class="text-2xl font-semibold whitespace-nowrap dark:text-white">SIBITA</span>
        </a>
        <button id="close-sidebar" class="text-gray-800 dark:text-white focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <ul class="space-y-4 p-4 text-sm">
        <li><a href="{{ route('dashboard') }}" class="block text-blue-700 dark:text-white">Dashboard</a></li>
        <li><a href="{{ route('pengajuan') }}" class="block text-gray-900 dark:text-white hover:text-blue-700">Pembimbing</a></li>
        <li><a href="{{ route('daftardosen') }}" class="block text-gray-900 dark:text-white hover:text-blue-700">Daftar Dosen</a></li>
        <li><a href="{{ route('upload.index') }}" class="block text-gray-900 dark:text-white hover:text-blue-700">Tugas Akhir</a></li>
        <li><a href="{{ route('penjadwalanmhs') }}" class="block text-gray-900 dark:text-white hover:text-blue-700">Penjadwalan</a></li>
        <li>
          <button id="openResetPasswordModalMobile" class="block w-full text-left text-gray-900 dark:text-white hover:text-blue-700">
            Reset Password
          </button>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Modal Reset Password -->
  <div id="resetPasswordModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
          <div class="bg-blue-100 rounded-full p-3 mr-3">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2m-2-2a2 2 0 00-2 2m0 0a2 2 0 01-2 2m2-2v6m0 0v2a2 2 0 01-2 2h-2m2-2a2 2 0 00-2-2m0 0h-2v-2m2 2v2a2 2 0 002 2m-2-2h2m0 0v2a2 2 0 002 2m-2-2h2"></path>
            </svg>
          </div>
          <h2 class="text-xl font-semibold text-gray-800">Reset Password</h2>
        </div>
        <button id="closeResetPasswordModal" class="text-gray-400 hover:text-gray-600">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <p class="text-gray-600 text-sm mb-6">Ubah password Anda untuk menjaga keamanan akun.</p>

      <form id="resetPasswordForm">
        @csrf
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
            <input type="password" name="current_password" required
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Masukkan password lama">
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
        <div id="resetErrorMessages" class="hidden mt-4 p-3 bg-red-100 border border-red-300 rounded-md">
          <ul class="text-sm text-red-600 list-disc list-inside"></ul>
        </div>

        <!-- Success Messages -->
        <div id="resetSuccessMessage" class="hidden mt-4 p-3 bg-green-100 border border-green-300 rounded-md">
          <p class="text-sm text-green-600"></p>
        </div>

        <!-- Loading -->
        <div id="resetLoading" class="hidden mt-4 text-center">
          <div class="inline-flex items-center">
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600 mr-2"></div>
            <span class="text-sm text-gray-600">Mengubah password...</span>
          </div>
        </div>

        <div class="flex space-x-3 mt-6">
          <button type="button" id="cancelResetPassword" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200">
            Batal
          </button>
          <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
            Ubah Password
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Background overlay for mobile sidebar -->
  <div id="mobile-overlay" class="fixed inset-0 bg-gray-800 bg-opacity-75 z-30 hidden"></div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const userMenuButton = document.getElementById("user-menu-button");
      const userDropdown = document.getElementById("user-dropdown");
      const mobileMenuButton = document.getElementById("mobile-menu-button");
      const mobileSidebar = document.getElementById("mobile-sidebar");
      const mobileOverlay = document.getElementById("mobile-overlay");
      const closeSidebar = document.getElementById("close-sidebar");

      // Reset Password Modal Elements
      const resetPasswordModal = document.getElementById("resetPasswordModal");
      const openResetPasswordModal = document.getElementById("openResetPasswordModal");
      const openResetPasswordModalMobile = document.getElementById("openResetPasswordModalMobile");
      const closeResetPasswordModal = document.getElementById("closeResetPasswordModal");
      const cancelResetPassword = document.getElementById("cancelResetPassword");
      const resetPasswordForm = document.getElementById("resetPasswordForm");
      const resetErrorDiv = document.getElementById("resetErrorMessages");
      const resetSuccessDiv = document.getElementById("resetSuccessMessage");
      const resetLoading = document.getElementById("resetLoading");

      // User dropdown toggle
      userMenuButton.addEventListener("click", function(e) {
        e.stopPropagation();
        userDropdown.classList.toggle("hidden");
      });

      // Close dropdown when clicking outside
      document.addEventListener("click", function(event) {
        if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
          userDropdown.classList.add("hidden");
        }
      });

      // Mobile sidebar functions
      function openMobileSidebar() {
        mobileOverlay.classList.remove("hidden");
        mobileSidebar.classList.remove("-translate-x-full");
      }

      function closeMobileSidebar() {
        mobileSidebar.classList.add("-translate-x-full");
        mobileOverlay.classList.add("hidden");
      }

      // Mobile menu button click
      mobileMenuButton.addEventListener("click", function(e) {
        e.stopPropagation();
        openMobileSidebar();
      });

      // Close sidebar button click
      closeSidebar.addEventListener("click", function(e) {
        e.stopPropagation();
        closeMobileSidebar();
      });

      // Close sidebar when clicking overlay
      mobileOverlay.addEventListener("click", function() {
        closeMobileSidebar();
      });

      // Reset Password Modal Functions
      function openResetModal() {
        resetPasswordModal.classList.remove("hidden");
        userDropdown.classList.add("hidden"); // Close dropdown when opening modal
        closeMobileSidebar(); // Close mobile sidebar if open

        // Reset form
        resetPasswordForm.reset();
        resetErrorDiv.classList.add("hidden");
        resetSuccessDiv.classList.add("hidden");
      }

      function closeResetModal() {
        resetPasswordModal.classList.add("hidden");
      }

      function showResetErrors(message) {
        const errorList = resetErrorDiv.querySelector('ul');
        errorList.innerHTML = `<li>${message}</li>`;
        resetErrorDiv.classList.remove('hidden');
        resetSuccessDiv.classList.add('hidden');
      }

      function showResetSuccess(message) {
        const successP = resetSuccessDiv.querySelector('p');
        successP.textContent = message;
        resetSuccessDiv.classList.remove('hidden');
        resetErrorDiv.classList.add('hidden');
      }

      // Open reset password modal (desktop)
      if (openResetPasswordModal) {
        openResetPasswordModal.addEventListener("click", function(e) {
          e.preventDefault();
          openResetModal();
        });
      }

      // Open reset password modal (mobile)
      if (openResetPasswordModalMobile) {
        openResetPasswordModalMobile.addEventListener("click", function(e) {
          e.preventDefault();
          openResetModal();
        });
      }

      // Close reset password modal
      closeResetPasswordModal.addEventListener("click", closeResetModal);
      cancelResetPassword.addEventListener("click", closeResetModal);

      // Close modal when clicking outside
      resetPasswordModal.addEventListener("click", function(e) {
        if (e.target === resetPasswordModal) {
          closeResetModal();
        }
      });

      // Handle reset password form submission
      resetPasswordForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Hide previous messages
        resetErrorDiv.classList.add('hidden');
        resetSuccessDiv.classList.add('hidden');
        resetLoading.classList.remove('hidden');

        const formData = new FormData(resetPasswordForm);

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
          resetLoading.classList.add('hidden');

          if (data.success) {
            showResetSuccess('Password berhasil diubah!');
            resetPasswordForm.reset();

            // Close modal after 2 seconds
            setTimeout(() => {
              closeResetModal();
            }, 2000);
          } else {
            showResetErrors(data.message || 'Terjadi kesalahan');
          }
        })
        .catch(error => {
          resetLoading.classList.add('hidden');
          console.error('Error:', error);
          showResetErrors('Terjadi kesalahan sistem');
        });
      });

      // Close modal with ESC key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          if (!resetPasswordModal.classList.contains('hidden')) {
            closeResetModal();
          }
          if (!mobileSidebar.classList.contains('-translate-x-full')) {
            closeMobileSidebar();
          }
          if (!userDropdown.classList.contains('hidden')) {
            userDropdown.classList.add('hidden');
          }
        }
      });
    });
  </script>

</body>
</html>
