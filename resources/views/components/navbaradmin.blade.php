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
                        poppins: ["Poppins", "sans-serif"],
                    },
                },
            },
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

    <!-- Mobile Menu Toggle Button -->
    <button id="menu-toggle" class="lg:hidden text-gray-800 dark:text-white focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
    </button>

    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-900 transform -translate-x-full transition-transform lg:relative lg:translate-x-0 lg:w-auto lg:flex lg:items-center">
      <div class="flex flex-col lg:flex-row lg:space-x-8 p-4 lg:p-0">
        <ul class="space-y-4 lg:space-y-0 lg:flex lg:space-x-8 text-sm">
          <li><a href="{{ route('dashboardadmin') }}" class="text-blue-700 dark:text-white">Dashboard</a></li>
          <li><a href="{{ route('manajemenakun') }}" class="text-gray-900 dark:text-white hover:text-blue-700">Manajemen Akun</a></li>
          <li><a href="{{ route('penjadwalanadmin') }}" class="text-gray-900 dark:text-white hover:text-blue-700">Penjadwalan</a></li>
          <li><a href="{{ route('requestadmin') }}" class="text-gray-900 dark:text-white hover:text-blue-700">Penguji</a></li>
        </ul>
      </div>
    </div>

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
                    <span class="block text-sm text-gray-500 dark:text-gray-400"></span>
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
</nav>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const menuToggle = document.getElementById("menu-toggle");
    const sidebar = document.getElementById("sidebar");
    const userMenuButton = document.getElementById("user-menu-button");
    const userDropdown = document.getElementById("user-dropdown");

    menuToggle.addEventListener("click", function() {
        sidebar.classList.toggle("-translate-x-full");
    });

    userMenuButton.addEventListener("click", function() {
        userDropdown.classList.toggle("hidden");
    });

    document.addEventListener("click", function(event) {
        if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.classList.add("hidden");
        }
    });
});
</script>

</body>
</html>
