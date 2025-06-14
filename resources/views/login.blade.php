<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIBITA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-300 via-blue-400 to-blue-600 p-4">

    <div class="max-w-4xl w-full bg-white rounded-xl shadow-md flex flex-col md:flex-row overflow-hidden relative z-10">

        <!-- Ilustrasi -->
<div class="w-full md:w-1/2 order-1 md:order-none bg-blue-100">
    <img src="{{ asset('images/fmipaa.png') }}" alt="Ilustrasi Akademik"
         class="w-full h-full object-cover">
</div>

        <!-- Form Login -->
        <div class="w-full md:w-1/2 p-6 flex flex-col justify-center">
            <div class="flex flex-col items-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-18 h-14 mb-2">
                <h1 class="text-xl font-semibold text-gray-900">SIBITA</h1>
                <p class="text-xs text-gray-500 text-center">Sistem Informasi Bimbingan Tugas Akhir</p>
            </div>
            @if ($errors->has('login'))
                <div class="mb-4 text-red-600 text-sm text-center">
                    {{ $errors->first('login') }}
                </div>
            @endif
            <form method="POST" action="/login" class="space-y-3">
                @csrf
                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Login Sebagai</label>
                    <select id="role" name="role" class="w-full text-sm p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                        <option value="" class="text-gray-400 text-sm" disabled selected>Pilih Login Sebagai</option>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dosen">Dosen</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- NPM/NIDN -->
                <div>
                    <label for="npm" class="block text-sm font-medium text-gray-700">NPM / NIP</label>
                    <input type="text" id="npm" name="npm" class="w-full text-sm p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Masukkan NPM atau NIDN" required>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="w-full text-sm p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
                </div>

                <!-- Tombol -->
                <button type="submit" class="w-full bg-blue-500 text-white text-sm p-2 rounded-lg hover:bg-blue-600 transition">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>
