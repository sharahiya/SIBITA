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
          , }
        , }
      , }
    , };

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
              <li><a href="{{ route('resetpass') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">Reset Password</a></li>
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
    <div id="mobile-sidebar" class="fixed top-0 left-0 w-64 h-full bg-white dark:bg-gray-900 shadow-lg transform -translate-x-full transition-transform">
      <div class="p-4">
        <button id="close-sidebar" class="text-gray-800 dark:text-white">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <ul class="space-y-4 p-4 text-sm">
        <li><a href="{{ route('dashboard') }}" class="block text-blue-700 dark:text-white">Dashboard</a></li>
        <li><a href="{{ route('pengajuan') }}" class="block text-gray-900 dark:text-white hover:text-blue-700">Pengajuan</a></li>
        <li><a href="{{ route('daftardosen') }}" class="block text-gray-900 dark:text-white hover:text-blue-700">Daftar Dosen</a></li>
        <li><a href="{{ route('upload.index') }}" class="block text-gray-900 dark:text-white hover:text-blue-700">Tugas Akhir</a></li>
        <li><a href="{{ route('penjadwalanmhs') }}" class="block text-gray-900 dark:text-white hover:text-blue-700">Penjadwalan</a></li>
      </ul>
    </div>
  </nav>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const userMenuButton = document.getElementById("user-menu-button");
      const userDropdown = document.getElementById("user-dropdown");

      userMenuButton.addEventListener("click", function() {
        userDropdown.classList.toggle("hidden");
      });

      document.addEventListener("click", function(event) {
        if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
          userDropdown.classList.add("hidden");
        }
      });

      const mobileMenuButton = document.getElementById("mobile-menu-button");
      const mobileSidebar = document.getElementById("mobile-sidebar");
      const closeSidebar = document.getElementById("close-sidebar");

      mobileMenuButton.addEventListener("click", function() {
        mobileSidebar.classList.remove("-translate-x-full");
      });

      closeSidebar.addEventListener("click", function() {
        mobileSidebar.classList.add("-translate-x-full");
      });

      document.addEventListener("click", function(event) {
        if (!mobileSidebar.contains(event.target) && !mobileMenuButton.contains(event.target)) {
          mobileSidebar.classList.add("-translate-x-full");
        }
      });
    });

  </script>

</body>
</html>
