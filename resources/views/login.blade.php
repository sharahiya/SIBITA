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
<body class="bg-blue-100 min-h-screen flex flex-col items-center justify-center">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
        <div class="flex flex-col items-center mb-4">
            <img src="{{ asset('images/icon/logo.png') }}" alt="Logo" class="w-20 h-20 mb-2">
            <h1 class="text-2xl font-semibold text-gray-900">SIBITA</h1>
        </div>
        <form class="space-y-4">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="name@company.com" required>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="••••••••" required>
            </div>
            <div class="flex justify-between items-center">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" class="mr-2"> Ingat saya
                </label>
                <a href="#" class="text-sm text-blue-500 hover:underline">Lupa password?</a>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 transition">Masuk</button>
            <p class="text-sm text-center text-gray-600">
                Belum punya akun? <a href="#" class="text-blue-500 hover:underline">Daftar</a>
            </p>
        </form>
    </div>
</body>
</html>