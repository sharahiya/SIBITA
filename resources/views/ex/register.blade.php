<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
  <section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-4 py-6 mx-auto md:h-screen lg:py-0 mt-10">
      <a href="#" class="flex items-center mb-4 text-xl font-semibold text-gray-900 dark:text-white">
        <img class="w-25 h-20 mr-2" src="{{ asset('images/logo.png') }}" alt="logo">
      </a>
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-sm xl:p-0 dark:bg-gray-800 dark:border-gray-700 mb-6">
        <div class="p-4 space-y-3 md:space-y-4 sm:p-6">
          <h1 class="text-xl font-bold text-gray-900 dark:text-white text-center">
            Buat Akun
          </h1>
          <p class="text-sm font-normal text-gray-900 dark:text-white text-center mb-4">
            Silahkan masukkan data
          </p>

          <form class="space-y-3 md:space-y-4" action="#">
            <div>
              <label for="nama" class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Nama</label>
              <input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Masukkan nama" required="">
            </div>
            <div>
              <label for="jenis_akun" class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Jenis Akun</label>
              <select name="jenis_akun" id="jenis_akun" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="mahasiswa">Mahasiswa</option>
                <option value="dosen">Dosen</option>
              </select>
            </div>
            <div>
              <label for="password" class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Password</label>
              <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required="">
            </div>
            <div>
              <label for="konfirmasi_password" class="block mb-1 text-xs font-medium text-gray-900 dark:text-white">Konfirmasi Password</label>
              <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" required="">
            </div>
            <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Daftar</button>
            <p class="text-xs font-light text-gray-500 dark:text-gray-400 text-center">
              Sudah memiliki akun? <a href="#" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Masuk</a>
            </p>
          </form>
        </div>
      </div>
    </div>
  </section>
</body>
</html>