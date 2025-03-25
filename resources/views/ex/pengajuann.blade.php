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

   <!-- Konten utama harus memiliki flex-grow agar footer tetap di bawah -->
   <div class="flex-grow py-10">
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
<!-- Main Content -->
<main class="lg:col-span-9 xl:col-span-10 mt-14">
  
<form>
    <div class="mb-6 max-w-sm ml-0">
        <label for="BM" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Bidang Penelitian Mahasiswa</label>
        <select id="BM" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <option value="RPL">Rekayasa Perangkat Lunak</option>
        <option value="DM">Data Mining</option>
        <option value="JRGN">Jaringan</option>
        <option value="GIS">Sistem Informasi Geografis</option>
        </select>
    </div>
    <div class="mb-6">
    <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Judul Tugas Akhir</label>
    <input type="text" id="default-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
</div>
    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Deskripsi Tugas Akhir</label>
    <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>

    <div class="mb-6 max-w-sm ml-0">
                <label for="bidang1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Bidang Dospem 1</label>
                <select id="bidang1" name="bidang1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="RPL">Rekayasa Perangkat Lunak</option>
                    <option value="DM">Data Mining</option>
                    <option value="JRGN">Jaringan</option>
                    <option value="GIS">Sistem Informasi Geografis</option>
                </select>
            </div>

            <div class="mb-6 max-w-sm ml-0">
                <label for="dospem1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Dosen Pembimbing 1</label>
                <select id="dospem1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </select>
            </div>

            <div class="mb-6 max-w-sm ml-0">
                <label for="bidang2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Bidang Dospem 2</label>
                <select id="bidang2" name="bidang2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="RPL">Rekayasa Perangkat Lunak</option>
                    <option value="DM">Data Mining</option>
                    <option value="JRGN">Jaringan</option>
                    <option value="GIS">Sistem Informasi Geografis</option>
                </select>
            </div>

            <div class="mb-6 max-w-sm ml-0">
                <label for="dospem2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Dosen Pembimbing 2</label>
                <select id="dospem2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </select>
            </div>

            <div class="flex gap-3">
    <a href="/status" class="text-blue-700 hover:underline text-sm font-medium self-center">Lihat Status</a>
    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Submit
    </button>
</div>
        </form>

        </main>
      </div>
    </div>
  </div>

  <script>
    const dosenData = {
        'RPL': ['Nazaruddin Abdullah, S.Si, M.Eng.Sc', 'Ir. Rahmad Dawood, S.Kom, M.Sc., IPM., ASEAN Eng. APEC Cr.', 'Kurnia Saputra, S.T, M.Sc', 'Dalila Husna Yunardi, BSc, M.Sc'],
        'DM': ['Prof. Dr. Taufik Fuadi Abidin, S.Si, M.Tech', 'Dr. Muhammad Subianto, S.Si, M.Si', 'Ir. Irvanizam Zamanhuri, S.Si., M.Sc., IPM.', 'Viska Mutiawani, B.IT, M.IT','Dr. Zahnur Nurdin, S.Si, M.InfoTech','Alim Misbullah, S.Si., MS.', 'Amalia Mabrina Masbar Rus, B.IT., MBIS.', 'Laina Farsiah, S.Si., M.Sc.' ],
        'JRGN': ['Mahyus Ihsan, S.Si, M.Si.', 'Rasudin Abubakar, S.Si, M.Info.Tech', 'Razief Perucha Fauzie Afidh, S.Si, M.Sc', 'Arie Budiansyah, ST., M.Eng', 'Zulfan Abdullah, S.Si, M.Sc', 'Husaini Muhammad, S.ST., M.Sc.'],
        'GIS': ['Dr. Nizamuddin, S.Si, M.Info.Sc', 'Dr. Muzailin Affan, S.Si, M.Sc', 'Ardiansyah A. Damhoeri, BSEE, M.Sc'],
    };

    const bidangSelect1 = document.getElementById('bidang1');
    const dospemSelect1 = document.getElementById('dospem1');
    const bidangSelect2 = document.getElementById('bidang2');
    const dospemSelect2 = document.getElementById('dospem2');

    function updateDosen1() {
        const selectedBidang = bidangSelect1.value;
        const dosenList = dosenData[selectedBidang] || [];

        dospemSelect1.innerHTML = '<option value="">-- Pilih Dosen Pembimbing 1 --</option>';

        dosenList.forEach(dosen => {
            const option = document.createElement('option');
            option.value = dosen;
            option.textContent = dosen;
            dospemSelect1.appendChild(option);
        });
    }

    function updateDosen2() {
        const selectedBidang = bidangSelect2.value;
        const dosenList = dosenData[selectedBidang] || [];

        dospemSelect2.innerHTML = '<option value="">-- Pilih Dosen Pembimbing 2 --</option>';

        dosenList.forEach(dosen => {
            const option = document.createElement('option');
            option.value = dosen;
            option.textContent = dosen;
            dospemSelect2.appendChild(option);
        });
    }

    bidangSelect1.addEventListener('change', updateDosen1);
    bidangSelect2.addEventListener('change', updateDosen2);
  </script>

</form>

</main>
 


      </div>
    </div>
  </div>

  

@include('components/footer')
</body>
</html>