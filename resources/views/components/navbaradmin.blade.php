<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            poppins: ["Poppins", "sans-serif"],
          },
        },
      },
    };
  </script>
</head>
<body class="font-poppins">

<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 border-b border-gray-200 dark:border-gray-600">
  <div class="max-w-screen-xl mx-auto flex items-center justify-between p-4">
    <!-- Logo -->
    <a href="#" class="flex items-center space-x-3">
      <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo" />
      <span class="text-2xl font-semibold whitespace-nowrap dark:text-white">SIBITA</span>
    </a>

    <!-- Desktop Menu -->
    <div class="hidden lg:flex space-x-8 text-sm">
      <a href="{{ route('dashboardadmin') }}" class="text-blue-700 dark:text-white hover:underline">Dashboard</a>

      <!-- Dropdown Manajemen Akun -->
      <div class="relative">
        <button id="akunDropdownButton" type="button"
          class="flex items-center space-x-1 text-gray-900 dark:text-white hover:text-blue-700 focus:outline-none focus:ring-0">
          <span>Manajemen Akun</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>

        <!-- Dropdown Menu -->
        <div id="akunDropdown" class="hidden absolute left-0 mt-2 w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600 z-50">
          <ul class="py-2">
            <li><a href="{{ route('manajemenakun') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">Kelola Akun</a></li>
            <li><a href="{{ route('daftarakunadmin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">Daftar Akun</a></li>
          </ul>
        </div>
      </div>

      <a href="{{ route('penjadwalanadmin') }}" class="text-gray-900 dark:text-white hover:text-blue-700">Penjadwalan</a>
      <a href="{{ route('requestadmin') }}" class="text-gray-900 dark:text-white hover:text-blue-700">Penguji</a>
    </div>

    <!-- Right: Icons -->
    <div class="hidden lg:flex items-center space-x-4">
      <!-- Notifikasi Icon -->
      <a href="{{ route('notifikasiadmin') }}" class="relative">
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
            $user = Auth::guard('admin')->user();
            $firstName = explode(' ', $user->nama)[0];
          @endphp
          <span class="w-8 h-8 flex items-center justify-center text-white bg-blue-400 rounded-full">
            {{ strtoupper(substr($firstName, 0, 1)) }}
          </span>
        </button>

        <div class="absolute right-0 top-full mt-2 z-50 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
          <div class="px-4 py-3">
            <span class="block text-sm text-gray-900 dark:text-white">{{ $user->nama }}</span>
            <span class="block text-sm text-gray-500 dark:text-gray-400">Admin</span>
          </div>
          <ul class="py-2">
            <li><a href="{{ route('resetpass') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">Reset Password</a></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                  Sign out
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>

      <!-- Mobile Menu Button -->
      <button id="mobile-menu-button" class="lg:hidden text-gray-800 dark:text-white ml-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>
    </div>

    <!-- Mobile Menu Button (moved outside of desktop menu) -->
    <button id="mobile-menu-button" class="lg:hidden text-gray-800 dark:text-white">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
      </svg>
    </button>
  </div>

  <!-- Mobile Sidebar -->
  <div id="mobile-sidebar"
    class="fixed top-0 left-0 w-64 h-full bg-white dark:bg-gray-900 shadow-lg transform -translate-x-full transition-transform z-50">
    <div class="p-4 flex justify-between items-center">
      <a href="#" class="flex items-center space-x-3">
        <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo" />
        <span class="text-2xl font-semibold whitespace-nowrap dark:text-white">SIBITA</span>
      </a>
      <button id="close-sidebar" class="text-gray-800 dark:text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    <ul class="space-y-4 p-4 text-sm">
      <li><a href="{{ route('dashboardadmin') }}" class="block text-blue-700 dark:text-white">Dashboard</a></li>
      <li>
        <button id="mobileAkunDropdownBtn" class="w-full flex justify-between items-center text-gray-900 dark:text-white hover:text-blue-700 focus:outline-none">
          <span>Manajemen Akun</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 9l-7 7-7-7"></path>
          </svg>
        </button>
        <ul id="mobileAkunDropdown" class="hidden pl-4 mt-2 space-y-1 text-gray-700 dark:text-gray-300">
          <li><a href="{{ route('manajemenakun') }}" class="block hover:text-blue-700">Kelola Akun</a></li>
          <li><a href="{{ route('daftarakunadmin') }}" class="block hover:text-blue-700">Daftar Akun</a></li>
        </ul>
      </li>
      <li><a href="{{ route('penjadwalanadmin') }}" class="block text-gray-900 dark:text-white hover:text-blue-700">Penjadwalan</a></li>
      <li><a href="{{ route('requestadmin') }}" class="block text-gray-900 dark:text-white hover:text-blue-700">Penguji</a></li>
    </ul>
  </div>
</nav>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    // User dropdown
    const userMenuButton = document.getElementById("user-menu-button");
    const userDropdown = document.getElementById("user-dropdown");

    if (userMenuButton && userDropdown) {
      userMenuButton.addEventListener("click", function (e) {
        e.stopPropagation();
        userDropdown.classList.toggle("hidden");
      });
    }

    // Akun dropdown (desktop)
    const akunDropdownButton = document.getElementById("akunDropdownButton");
    const akunDropdown = document.getElementById("akunDropdown");

    if (akunDropdownButton && akunDropdown) {
      akunDropdownButton.addEventListener("click", function (e) {
        e.stopPropagation();
        akunDropdown.classList.toggle("hidden");
      });
    }

    // Mobile sidebar
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileSidebar = document.getElementById("mobile-sidebar");
    const closeSidebar = document.getElementById("close-sidebar");

    if (mobileMenuButton && mobileSidebar) {
      mobileMenuButton.addEventListener("click", function (e) {
        e.stopPropagation();
        mobileSidebar.classList.remove("-translate-x-full");
      });
    }

    if (closeSidebar && mobileSidebar) {
      closeSidebar.addEventListener("click", function (e) {
        e.stopPropagation();
        mobileSidebar.classList.add("-translate-x-full");
      });
    }

    // Toggle dropdown submenu Manajemen Akun di mobile sidebar
    const mobileAkunDropdownBtn = document.getElementById("mobileAkunDropdownBtn");
    const mobileAkunDropdown = document.getElementById("mobileAkunDropdown");

    if (mobileAkunDropdownBtn && mobileAkunDropdown) {
      mobileAkunDropdownBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        mobileAkunDropdown.classList.toggle("hidden");
      });
    }

    // Tutup semua dropdown dan sidebar saat klik di luar
    document.addEventListener("click", function (event) {
      if (mobileSidebar && mobileMenuButton && !mobileSidebar.contains(event.target) && !mobileMenuButton.contains(event.target)) {
        mobileSidebar.classList.add("-translate-x-full");
      }

      if (userDropdown && userMenuButton && !userDropdown.contains(event.target) && !userMenuButton.contains(event.target)) {
        userDropdown.classList.add("hidden");
      }

      if (akunDropdown && akunDropdownButton && !akunDropdown.contains(event.target) && !akunDropdownButton.contains(event.target)) {
        akunDropdown.classList.add("hidden");
      }

      if (
        mobileAkunDropdown &&
        mobileAkunDropdownBtn &&
        !mobileAkunDropdown.contains(event.target) &&
        !mobileAkunDropdownBtn.contains(event.target)
      ) {
        mobileAkunDropdown.classList.add("hidden");
      }
    });
  });
</script>

</body>
</html>
