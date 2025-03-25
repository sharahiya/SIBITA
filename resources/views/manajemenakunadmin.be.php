<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script>
    tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ["Poppins", "sans-serif", "Montserrat"],
                        helvetica: ["Helvetica", "Arial", "sans-serif"],
                        inter: ["Inter", "sans-serif"],
                        roboto: ["Roboto", "sans-serif"],
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-gray-100 font-poppins min-h-screen flex flex-col">


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
                <span class="truncate">Home</span>
              </a>
              <a href="{{ route('profile') }}" class="text-gray-700 hover:bg-gray-50 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                <span class="truncate">Profile</span>
              </a>
              <a href="#" class="bg-gray-200 text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
                <span class="truncate">Manajemen Akun</span>
              </a>
            </div>
            <div class="pt-10">
              <p class="px-3 text-sm font-medium text-gray-500">Menu Lain</p>
              <div class="mt-3 space-y-2">
                <a href="{{ route('logout') }}" class="group flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900">Logout</a>
              </div>
            </div>
          </nav>
        </aside>

        <!-- Main Content -->
        <main class="lg:col-span-9 xl:col-span-10 mt-14">
          <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-between items-center mb-6">
              <h1 class="text-2xl font-semibold text-gray-900">Manajemen Data Akun</h1>
              <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-md">Tambah Akun Baru</a>
            </div>

            <!-- Dropdown for selecting Dosen/Mahasiswa -->
            <div class="mb-4">
              <label for="akun-select" class="block text-sm font-medium text-gray-700">Pilih Tipe Akun</label>
              <select id="akun-select" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="dosen">Dosen</option>
                <option value="mahasiswa">Mahasiswa</option>
              </select>
            </div>

            <!-- Search Input -->
            <div class="mb-4">
              <label for="search" class="block text-sm font-medium text-gray-700">Cari Akun</label>
              <input id="search" type="text" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Cari berdasarkan nama, email atau jabatan">
            </div>
            
            <!-- Tabel Akun -->
            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
              <table class="min-w-full divide-y divide-gray-200">
                <thead>
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                  </tr>
                </thead>
                <tbody id="akun-list" class="bg-white divide-y divide-gray-200">
                  <!-- Data Akun Dosen/Mahasiswa -->
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">John Doe</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">john@example.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Dosen</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                      <form action="#" method="POST" class="inline-block ml-4">
                        <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                      </form>
                    </td>
                  </tr>
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Jane Smith</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">jane@example.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Mahasiswa</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                      <form action="#" method="POST" class="inline-block ml-4">
                        <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                      </form>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </main>

      </div>
    </div>
  </div>

  <!-- Footer -->
  @include('components/footer')

  <script>
    // Handling the filtering of accounts by type (Dosen/Mahasiswa)
    document.getElementById('akun-select').addEventListener('change', function() {
      const selectedType = this.value;
      filterAkun(selectedType);
    });

    // Handling the search functionality
    document.getElementById('search').addEventListener('input', function() {
      const query = this.value.toLowerCase();
      searchAkun(query);
    });

    // Function to filter accounts based on selected type
    function filterAkun(type) {
      const rows = document.querySelectorAll('#akun-list tr');
      rows.forEach(row => {
        const jabatan = row.cells[2].textContent.toLowerCase();
        if (jabatan === type || type === 'all') {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }

    // Function to search accounts
    function searchAkun(query) {
      const rows = document.querySelectorAll('#akun-list tr');
      rows.forEach(row => {
        const nama = row.cells[0].textContent.toLowerCase();
        const email = row.cells[1].textContent.toLowerCase();
        const jabatan = row.cells[2].textContent.toLowerCase();
        if (nama.includes(query) || email.includes(query) || jabatan.includes(query)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    }
  </script>

</body>
</html>
