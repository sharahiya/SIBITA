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

  <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 border-b border-gray-200 dark:border-gray-600 shadow-sm">
    <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">

      <!-- Mobile Menu Button (Left Side) -->
      <button id="mobile-menu-button"
              class="lg:hidden p-2 text-gray-700 dark:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-600 transition-colors duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>

      <!-- Logo Section (Hidden on Mobile) -->
      <a href="#" class="hidden lg:flex items-center space-x-3 flex-shrink-0">
        <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo">
        <span class="self-center text-xl md:text-2xl font-semibold whitespace-nowrap dark:text-white">SIBITA</span>
      </a>

      <!-- Desktop Navigation Menu -->
      <div class="hidden lg:flex absolute left-1/2 transform -translate-x-1/2">
        <ul class="flex space-x-6 xl:space-x-8 text-sm">
          <li>
            <a href="{{ route('dashboarddosen') }}"
               class="text-blue-700 dark:text-white font-medium hover:text-blue-800 transition-colors duration-200">
               Dashboard
            </a>
          </li>
          <li>
            <a href="{{ route('profiledosen') }}"
               class="text-gray-900 dark:text-white hover:text-blue-700 font-medium transition-colors duration-200">
              Profile
            </a>
          </li>
          <li>
            <a href="{{ route('requestdosen') }}"
               class="text-gray-900 dark:text-white hover:text-blue-700 font-medium transition-colors duration-200">
               Request
            </a>
          </li>
          <li>
            <a href="{{ route('penjadwalandosen') }}"
               class="text-gray-900 dark:text-white hover:text-blue-700 font-medium transition-colors duration-200">
               Penjadwalan
            </a>
          </li>
          <li>
            <a href="{{ route('riwayatdosen') }}"
               class="text-gray-900 dark:text-white hover:text-blue-700 font-medium transition-colors duration-200">
               Riwayat
            </a>
          </li>
        </ul>
      </div>

      <!-- Right Section: Notifications + Profile (Desktop Only) -->
      <div class="flex items-center space-x-3">

        <!-- Notification Icon (Always Visible) -->
        <a href="{{ route('notifikasidosen') }}"
           class="relative p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
          <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-700 dark:text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6 6 0 00-12 0v3c0 .386-.146.75-.405 1.045L4 17h5m6 0a3 3 0 11-6 0"></path>
          </svg>
          @if(isset($unreadNotifCount) && $unreadNotifCount > 0)
            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-[1.125rem] h-[1.125rem] text-xs font-medium text-white bg-red-500 rounded-full border-2 border-white dark:border-gray-900">
                {{ $unreadNotifCount > 99 ? '99+' : $unreadNotifCount }}
            </span>
          @endif
        </a>

        <!-- User Profile Dropdown (Desktop Only) -->
        <div class="relative hidden lg:block">
          <button type="button"
                  class="flex items-center text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 hover:bg-gray-700 transition-colors duration-200"
                  id="user-menu-button">
            @php
                $user = Auth::guard('dosen')->user();
                $firstName = explode(' ', $user->nama)[0];
            @endphp
            <span class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center text-white bg-blue-500 rounded-full font-medium text-sm">
                {{ strtoupper(substr($firstName, 0, 1)) }}
            </span>
          </button>

          <!-- User Dropdown Menu -->
          <div class="absolute right-0 top-full mt-2 z-50 hidden w-56 bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600 border border-gray-200 dark:border-gray-600" id="user-dropdown">
            <!-- User Info -->
            <div class="px-4 py-3">
              <span class="block text-sm font-medium text-gray-900 dark:text-white truncate">{{ $user->nama }}</span>
              <span class="block text-sm text-gray-500 dark:text-gray-400">{{ $user->nip }}</span>
            </div>

            <!-- Menu Items -->
            <ul class="py-2">
              <li>
                <button id="openResetPasswordModal"
                        class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600 transition-colors duration-200">
                  <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2m-2-2a2 2 0 00-2 2m0 0a2 2 0 01-2 2m2-2v6"></path>
                  </svg>
                  Reset Password
                </button>
              </li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit"
                          class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Sign out
                  </button>
                </form>
              </li>
            </ul>
          </div>
        </div>

      </div>
    </div>

    <!-- Mobile Navigation Sidebar -->
    <div id="mobile-sidebar"
         class="fixed top-0 left-0 w-72 h-full bg-white dark:bg-gray-900 shadow-xl transform -translate-x-full transition-transform duration-300 ease-in-out z-40 border-r border-gray-200 dark:border-gray-700">

      <!-- Sidebar Header -->
      <div class="p-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
        <a href="#" class="flex items-center space-x-3">
          <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo" />
          <span class="text-xl font-semibold whitespace-nowrap dark:text-white">SIBITA</span>
        </a>
        <button id="close-sidebar"
                class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg focus:outline-none transition-colors duration-200">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <!-- User Info in Sidebar -->
      <div class="p-4 border-b border-gray-200 dark:border-gray-600 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700">
        <div class="flex items-center space-x-3">
          <span class="w-12 h-12 flex items-center justify-center text-white bg-blue-500 rounded-full font-medium text-lg">
            {{ strtoupper(substr($firstName, 0, 1)) }}
          </span>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $user->nama }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->nip }}</p>
          </div>
        </div>
      </div>

      <!-- Navigation Links -->
      <div class="p-4">
        <nav class="space-y-2">
          <a href="{{ route('dashboarddosen') }}"
             class="flex items-center px-3 py-2 text-sm font-medium text-blue-700 bg-blue-50 dark:text-blue-400 dark:bg-blue-900/20 rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
            </svg>
            Dashboard
          </a>

          <a href="{{ route('profiledosen') }}"
             class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Profile
          </a>

          <a href="{{ route('requestdosen') }}"
             class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
            Request
          </a>

          <a href="{{ route('penjadwalandosen') }}"
             class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Penjadwalan
          </a>

          <a href="{{ route('riwayatdosen') }}"
             class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Riwayat
          </a>
        </nav>

        <!-- Sidebar Actions -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600 space-y-2">
          <button id="openResetPasswordModalMobile"
                  class="flex items-center w-full px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2m-2-2a2 2 0 00-2 2m0 0a2 2 0 01-2 2m2-2v6"></path>
            </svg>
            Reset Password
          </button>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex items-center w-full px-3 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-200">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
              </svg>
              Sign out
            </button>
          </form>
        </div>
      </div>
    </div>
  </nav>

  <!-- Modal Reset Password -->
  <div id="resetPasswordModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4 transform scale-95 transition-transform duration-300">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
          <div class="bg-blue-100 rounded-full p-3 mr-3">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2m-2-2a2 2 0 00-2 2m0 0a2 2 0 01-2 2m2-2v6m0 0v2a2 2 0 01-2 2h-2m2-2a2 2 0 00-2-2m0 0h-2v-2m2 2v2a2 2 0 002 2m-2-2h2m0 0v2a2 2 0 002 2m-2-2h2"></path>
            </svg>
          </div>
          <h2 class="text-xl font-semibold text-gray-800">Reset Password</h2>
        </div>
        <button id="closeResetPasswordModal" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors duration-200">
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
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                   placeholder="Masukkan password lama">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <input type="password" name="new_password" required minlength="6"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                   placeholder="Masukkan password baru (min. 6 karakter)">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" required minlength="6"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
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
          <button type="button" id="cancelResetPassword"
                  class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200">
            Batal
          </button>
          <button type="submit"
                  class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
            Ubah Password
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Background overlay for mobile sidebar -->
  <div id="mobile-overlay" class="fixed inset-0 bg-gray-800 bg-opacity-75 z-30 hidden transition-opacity duration-300"></div>

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

      // User dropdown toggle (Desktop only)
      if (userMenuButton) {
        userMenuButton.addEventListener("click", function(e) {
          e.stopPropagation();
          userDropdown.classList.toggle("hidden");

          // Close mobile sidebar if open
          if (!mobileSidebar.classList.contains("-translate-x-full")) {
            closeMobileSidebar();
          }
        });
      }

      // Close dropdown when clicking outside
      document.addEventListener("click", function(event) {
        if (userMenuButton && userDropdown &&
            !userMenuButton.contains(event.target) &&
            !userDropdown.contains(event.target)) {
          userDropdown.classList.add("hidden");
        }
      });

      // Mobile sidebar functions
      function openMobileSidebar() {
        // mobileOverlay.classList.remove("hidden");
        mobileSidebar.classList.remove("-translate-x-full");
        document.body.style.overflow = "hidden"; // Prevent background scrolling

        // Close user dropdown if open
        if (userDropdown) {
          userDropdown.classList.add("hidden");
        }
      }

      function closeMobileSidebar() {
        mobileSidebar.classList.add("-translate-x-full");
        mobileOverlay.classList.add("hidden");
        document.body.style.overflow = ""; // Restore scrolling
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
        resetPasswordModal.querySelector('.transform').classList.remove('scale-95');
        resetPasswordModal.querySelector('.transform').classList.add('scale-100');

        if (userDropdown) userDropdown.classList.add("hidden"); // Close dropdown when opening modal
        closeMobileSidebar(); // Close mobile sidebar if open
        document.body.style.overflow = "hidden"; // Prevent background scrolling

        // Reset form
        resetPasswordForm.reset();
        resetErrorDiv.classList.add("hidden");
        resetSuccessDiv.classList.add("hidden");
      }

      function closeResetModal() {
        const modalContent = resetPasswordModal.querySelector('.transform');
        modalContent.classList.add('scale-95');
        modalContent.classList.remove('scale-100');

        setTimeout(() => {
          resetPasswordModal.classList.add("hidden");
          document.body.style.overflow = ""; // Restore scrolling
        }, 200);
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

      // Close modal and sidebar with ESC key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          if (!resetPasswordModal.classList.contains('hidden')) {
            closeResetModal();
          }
          if (!mobileSidebar.classList.contains('-translate-x-full')) {
            closeMobileSidebar();
          }
          if (userDropdown && !userDropdown.classList.contains('hidden')) {
            userDropdown.classList.add('hidden');
          }
        }
      });

      // Handle window resize
      window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) { // lg breakpoint
          closeMobileSidebar();
        }
      });
    });
  </script>

</body>
</html>
