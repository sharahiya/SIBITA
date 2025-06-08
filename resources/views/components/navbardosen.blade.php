<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  />
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

<nav
  class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 border-b border-gray-200 dark:border-gray-600"
>
  <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4 relative">
    <!-- Logo -->
    <a href="#" class="flex items-center space-x-3">
      <img
        src="{{ asset('images/logo.png') }}"
        class="h-8"
        alt="Logo"
      />
      <span
        class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"
        >SIBITA</span
      >
    </a>

    <!-- Desktop Menu -->
    <div
      class="hidden lg:flex absolute left-1/2 transform -translate-x-1/2"
      aria-label="Primary Navigation"
    >
      <ul class="flex space-x-8 text-sm">
        <li>
          <a
            href="{{ route('dashboarddosen') }}"
            class="text-blue-700 dark:text-white"
            >Dashboard</a
          >
        </li>
        <li>
          <a
            href="{{ route('profiledosen') }}"
            class="text-blue-700 dark:text-white"
            >Profile</a
          >
        </li>
        <li>
          <a
            href="{{ route('requestdosen') }}"
            class="text-gray-900 dark:text-white hover:text-blue-700"
            >Request</a
          >
        </li>
        <li>
          <a
            href="{{ route('penjadwalandosen') }}"
            class="text-gray-900 dark:text-white hover:text-blue-700"
            >Penjadwalan</a
          >
        </li>
        <li>
          <a
            href="{{ route('riwayatdosen') }}"
            class="text-gray-900 dark:text-white hover:text-blue-700"
            >Riwayat</a
          >
        </li>
      </ul>
    </div>

    <!-- Right icons & buttons -->
    <div class="flex items-center space-x-4">
        <!-- Notifikasi Icon -->
        <a href="{{ route('notifikasidosen') }}" class="relative">
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
                $user = Auth::guard('dosen')->user();
                $firstName = explode(' ', $user->nama)[0];
            @endphp

                <span class="w-8 h-8 flex items-center justify-center text-white bg-blue-400 rounded-full">
                    {{ strtoupper(substr($firstName, 0, 1)) }}
                </span>
            </button>

            <div class="absolute right-0 top-full mt-2 z-50 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-lg dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">{{ $user->nama }}</span>
                    <span class="block text-sm text-gray-500 dark:text-gray-400">{{ $user->nip }}</span>
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

      <!-- Mobile Menu Button -->
      <button
        id="menu-toggle"
        class="lg:hidden text-gray-800 dark:text-white focus:outline-none"
        aria-label="Toggle menu"
        aria-expanded="false"
      >
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Sidebar -->
  <div
    id="mobile-menu"
    class="fixed inset-0 bg-gray-800 bg-opacity-75 z-40 hidden"
    aria-hidden="true"
  >
    <div
      class="w-64 bg-white dark:bg-gray-900 h-full shadow-lg transform -translate-x-full transition-transform duration-300"
      id="mobile-sidebar"
      tabindex="-1"
    >
      <div class="p-4 flex justify-between items-center border-b border-gray-200 dark:border-gray-600">
        <a href="#" class="flex items-center space-x-3">
          <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo" />
          <span class="text-2xl font-semibold whitespace-nowrap dark:text-white"
            >SIBITA</span
          >
        </a>
        <button
          id="close-sidebar"
          class="text-gray-800 dark:text-white focus:outline-none"
          aria-label="Close menu"
        >
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <ul class="space-y-4 p-4 text-sm">
        <li>
          <a
            href="{{ route('dashboarddosen') }}"
            class="block text-blue-700 dark:text-white"
            >Dashboard</a
          >
        </li>
        <li>
          <a
            href="{{ route('profiledosen') }}"
            class="block text-blue-700 dark:text-white"
            >Profile</a
          >
        </li>
        <li>
          <a
            href="{{ route('requestdosen') }}"
            class="block text-gray-900 dark:text-white hover:text-blue-700"
            >Request</a
          >
        </li>
        <li>
          <a
            href="{{ route('penjadwalandosen') }}"
            class="block text-gray-900 dark:text-white hover:text-blue-700"
            >Penjadwalan</a
          >
        </li>
        <li>
          <a
            href="{{ route('riwayatdosen') }}"
            class="block text-gray-900 dark:text-white hover:text-blue-700"
            >Riwayat</a
          >
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const userMenuButton = document.getElementById("user-menu-button");
    const userDropdown = document.getElementById("user-dropdown");
    const menuToggle = document.getElementById("menu-toggle");
    const mobileMenu = document.getElementById("mobile-menu");
    const mobileSidebar = document.getElementById("mobile-sidebar");
    const closeSidebar = document.getElementById("close-sidebar");

    // Toggle user dropdown menu
    userMenuButton.addEventListener("click", (e) => {
      e.stopPropagation();
      const expanded = userMenuButton.getAttribute("aria-expanded") === "true";
      userMenuButton.setAttribute("aria-expanded", !expanded);
      userDropdown.classList.toggle("hidden");
    });

    // Close dropdown if click outside
    document.addEventListener("click", (e) => {
      if (
        !userMenuButton.contains(e.target) &&
        !userDropdown.contains(e.target)
      ) {
        userDropdown.classList.add("hidden");
        userMenuButton.setAttribute("aria-expanded", "false");
      }
    });

    // Toggle mobile menu sidebar
    menuToggle.addEventListener("click", (e) => {
      e.stopPropagation();
      mobileMenu.classList.remove("hidden");
      setTimeout(() => {
        mobileSidebar.classList.remove("-translate-x-full");
      }, 10);
      menuToggle.setAttribute("aria-expanded", "true");
    });

    // Close sidebar when clicking close button
    closeSidebar.addEventListener("click", (e) => {
      e.stopPropagation();
      mobileSidebar.classList.add("-translate-x-full");
      setTimeout(() => {
        mobileMenu.classList.add("hidden");
      }, 300);
      menuToggle.setAttribute("aria-expanded", "false");
    });

    // Close sidebar if click outside sidebar or toggle button
    mobileMenu.addEventListener("click", (e) => {
      if (
        e.target === mobileMenu &&
        !mobileSidebar.contains(e.target) &&
        !menuToggle.contains(e.target)
      ) {
        mobileSidebar.classList.add("-translate-x-full");
        setTimeout(() => {
          mobileMenu.classList.add("hidden");
        }, 300);
        menuToggle.setAttribute("aria-expanded", "false");
      }
    });

    // Close sidebar and dropdown when clicking outside anywhere
    document.addEventListener("click", (e) => {
      if (
        !mobileSidebar.contains(e.target) &&
        !menuToggle.contains(e.target) &&
        !userMenuButton.contains(e.target) &&
        !userDropdown.contains(e.target)
      ) {
        // Close mobile menu
        if (!mobileSidebar.classList.contains("-translate-x-full")) {
          mobileSidebar.classList.add("-translate-x-full");
          setTimeout(() => {
            mobileMenu.classList.add("hidden");
          }, 300);
          menuToggle.setAttribute("aria-expanded", "false");
        }
        // Close user dropdown
        if (!userDropdown.classList.contains("hidden")) {
          userDropdown.classList.add("hidden");
          userMenuButton.setAttribute("aria-expanded", "false");
        }
      }
    });
  });
</script>

</body>
</html>
