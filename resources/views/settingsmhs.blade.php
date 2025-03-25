<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Ganti Password</title>
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
<body class="bg-gray-100 font-poppins min-h-screen flex flex-col items-center justify-center">
<!-- Navbar -->
@include('components/navbar')
    <div class="bg-white p-6 shadow-lg rounded-lg w-full max-w-md">
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-4">Ganti Password</h2>
        
        <form id="changePasswordForm">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password Lama</label>
                <div class="relative">
                    <input type="password" id="oldPassword" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    <i class="fa fa-eye absolute right-3 top-3 text-gray-500 cursor-pointer" onclick="togglePassword('oldPassword')"></i>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                <div class="relative">
                    <input type="password" id="newPassword" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    <i class="fa fa-eye absolute right-3 top-3 text-gray-500 cursor-pointer" onclick="togglePassword('newPassword')"></i>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input type="password" id="confirmPassword" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                    <i class="fa fa-eye absolute right-3 top-3 text-gray-500 cursor-pointer" onclick="togglePassword('confirmPassword')"></i>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Submit</button>
        </form>
    </div>

    <script>
        function togglePassword(fieldId) {
            let field = document.getElementById(fieldId);
            field.type = field.type === "password" ? "text" : "password";
        }

        document.getElementById('changePasswordForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let oldPassword = document.getElementById('oldPassword').value;
            let newPassword = document.getElementById('newPassword').value;
            let confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword !== confirmPassword) {
                alert("Password baru dan konfirmasi password tidak cocok.");
                return;
            }
            
            alert("Password berhasil diubah!");
        });
    </script>
</body>
</html>
