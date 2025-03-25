<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col bg-gray-100">

  <!-- Navbar -->
  @include('components/navbar')

  <div class="py-10 flex-grow">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <!-- Layout grid -->
      <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        
        <!-- Sidebar -->
        <aside class="hidden lg:col-span-3 lg:block xl:col-span-2">
          <nav aria-label="Sidebar" class="sticky top-4 mt-16 divide-y divide-gray-300">
            <div class="space-y-1 pb-8">
              <a href="#" class="bg-gray-200 text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                <svg class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                </svg>
                <span class="truncate">Home</span>
              </a>
              <a href="{{ route('profile') }}" class="text-gray-700 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
              <svg class="text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
             <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9A3.75 3.75 0 1112 5.25 3.75 3.75 0 0115.75 9zM4.5 19.5a8.25 8.25 0 0115 0"></path>
            </svg>
            <span class="truncate">Profile</span>
            </a>
              <a href="{{ route('pengajuan') }}" class="text-gray-700 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z"></path>
                </svg>
                <span class="truncate">Pengajuan</span>
              </a>
              <a href="{{ route('daftardosen') }}" class="text-gray-700 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                </svg>
                <span class="truncate">Daftar Dosen</span>
              </a>
            </div>
            <div class="pt-10">
              <p class="px-3 text-sm font-medium text-gray-500">Menu Lain</p>
              <div class="mt-3 space-y-2">
                <a href="{{ route('panduan') }}" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">Panduan</a>
                <a href="{{ route('pengaturanakun') }}" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">Pengaturan Akun</a>
                <a href="{{ route('logout') }}" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">Logout</a>
              </div>
            </div>
          </nav>
        </aside>

        <main class="lg:col-span-9 xl:col-span-10 mt-16"> <!-- Mengurangi margin atas -->
    <div class="p-3 mb-3 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
        <time class="text-sm font-semibold text-gray-900 dark:text-white">January 13th, 2025</time> <!-- Mengubah ukuran font -->
        <ol class="mt-2 divide-y divide-gray-200 dark:divide-gray-700">
            <li>
                <a href="#" class="items-center block p-2 sm:flex hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-8 h-8 mb-2 me-2 text-gray-500 sm:mb-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a7 7 0 100-14 7 7 0 000 14zm0 1a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd"/>
                    </svg>

                    <div class="text-gray-600 dark:text-gray-400">
                        <div class="text-xs font-normal"><span class="font-medium text-gray-900 dark:text-white">Prof.Taufik</span> Menyetujui<span class="font-medium text-gray-900 dark:text-white"> Seminar Proposal</span> mahasiswa<span class="font-medium text-gray-900 dark:text-white"> Sharahiya</span></div>
                    </div>
                </a>
                <a href="/jadwal-seminar" class="inline-block mt-2 px-4 py-1.5 mr bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 focus:outline-none focus:ring-0 active:bg-blue-800 transition duration-150 ease-in-out">
                    Tetapkan Jadwal Seminar
                </a>
            </li>
            <ol class="mt-2 divide-y divide-gray-200 dark:divide-gray-700">
            <li>
                <a href="#" class="items-center block p-2 sm:flex hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-8 h-8 mb-2 me-2 text-gray-500 sm:mb-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a7 7 0 100-14 7 7 0 000 14zm0 1a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd"/>
                    </svg>

                    <div class="text-gray-600 dark:text-gray-400">
                        <div class="text-xs font-normal"><span class="font-medium text-gray-900 dark:text-white">Prof.Taufik</span> Menyetujui<span class="font-medium text-gray-900 dark:text-white"> Seminar Proposal</span> mahasiswa<span class="font-medium text-gray-900 dark:text-white"> Sharahiya</span></div>
                    </div>
                </a>
                <a href="/jadwal-seminar" class="inline-block mt-2 px-4 py-1.5 mr bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 focus:outline-none focus:ring-0 active:bg-blue-800 transition duration-150 ease-in-out">
                    Tetapkan Jadwal Seminar
                </a>
            </li>
        </ol>
        </ol>
        <ol class="mt-2 divide-y divide-gray-200 dark:divide-gray-700">
            <li>
                <a href="#" class="items-center block p-2 sm:flex hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-8 h-8 mb-2 me-2 text-gray-500 sm:mb-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a7 7 0 100-14 7 7 0 000 14zm0 1a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd"/>
                    </svg>

                    <div class="text-gray-600 dark:text-gray-400">
                        <div class="text-xs font-normal"><span class="font-medium text-gray-900 dark:text-white">Prof.Taufik</span> Menyetujui<span class="font-medium text-gray-900 dark:text-white"> Seminar Proposal</span> mahasiswa<span class="font-medium text-gray-900 dark:text-white"> Sharahiya</span></div>
                    </div>
                </a>
                <a href="/jadwal-seminar" class="inline-block mt-2 px-4 py-1.5 mr bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 focus:outline-none focus:ring-0 active:bg-blue-800 transition duration-150 ease-in-out">
                    Tetapkan Jadwal Seminar
                </a>
            </li>
        </ol>
    </div>

    <div class="p-3 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
        <time class="text-sm font-semibold text-gray-900 dark:text-white">January 13th, 2022</time> <!-- Mengubah ukuran font -->
        <ol class="mt-2 divide-y divide-gray-200 dark:divide-gray-700">
            <li>
                <a href="#" class="items-center block p-2 sm:flex hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-8 h-8 mb-2 me-2 text-gray-500 sm:mb-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a7 7 0 100-14 7 7 0 000 14zm0 1a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd"/>
                    </svg>

                    <div class="text-gray-600 dark:text-gray-400">
                        <div class="text-xs font-normal"><span class="font-medium text-gray-900 dark:text-white">Alim Misbullah</span> Menyetujui<span class="font-medium text-gray-900 dark:text-white"> Seminar Hasil</span> mahasiswa<span class="font-medium text-gray-900 dark:text-white"> Tyara Rayna</span></div>
                    </div>
                </a>
                <a href="/jadwal-seminar" class="inline-block mt-2 px-4 py-1.5 mr bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 focus:outline-none focus:ring-0 active:bg-blue-800 transition duration-150 ease-in-out">
                    Tetapkan Jadwal Seminar
                </a>
            </li>
        </ol>
        <ol class="mt-2 divide-y divide-gray-200 dark:divide-gray-700">
            <li>
                <a href="#" class="items-center block p-2 sm:flex hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-8 h-8 mb-2 me-2 text-gray-500 sm:mb-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a7 7 0 100-14 7 7 0 000 14zm0 1a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd"/>
                    </svg>

                    <div class="text-gray-600 dark:text-gray-400">
                        <div class="text-xs font-normal"><span class="font-medium text-gray-900 dark:text-white">Prof.Taufik</span> Menyetujui<span class="font-medium text-gray-900 dark:text-white"> Seminar Proposal</span> mahasiswa<span class="font-medium text-gray-900 dark:text-white"> Sharahiya</span></div>
                    </div>
                </a>
                <a href="/jadwal-seminar" class="inline-block mt-2 px-4 py-1.5 mr bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 focus:outline-none focus:ring-0 active:bg-blue-800 transition duration-150 ease-in-out">
                    Tetapkan Jadwal Seminar
                </a>
            </li>
        </ol>
        <ol class="mt-2 divide-y divide-gray-200 dark:divide-gray-700">
            <li>
                <a href="#" class="items-center block p-2 sm:flex hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-8 h-8 mb-2 me-2 text-gray-500 sm:mb-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a7 7 0 100-14 7 7 0 000 14zm0 1a8 8 0 100-16 8 8 0 000 16z" clip-rule="evenodd"/>
                    </svg>

                    <div class="text-gray-600 dark:text-gray-400">
                        <div class="text-xs font-normal"><span class="font-medium text-gray-900 dark:text-white">Prof.Taufik</span> Menyetujui<span class="font-medium text-gray-900 dark:text-white"> Seminar Proposal</span> mahasiswa<span class="font-medium text-gray-900 dark:text-white"> Sharahiya</span></div>
                    </div>
                </a>
                <a href="/jadwal-seminar" class="inline-block mt-2 px-4 py-1.5 mr bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded-full shadow-md hover:bg-blue-700 focus:outline-none focus:ring-0 active:bg-blue-800 transition duration-150 ease-in-out">
                    Tetapkan Jadwal Seminar
                </a>
            </li>
        </ol>
    </div>
</main>

      </div>
    </div>
  </div>

@include('components/footer')
</body>
</html>