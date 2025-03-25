<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan | Mahasiswa & Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    poppins: ["Poppins", "sans-serif"],
                    inter: ["Inter", "sans-serif"],
                },
            },
        },
    };
    </script>
</head>
<body class="font-poppins bg-gray-100 min-h-screen flex flex-col">
    <!-- Navbar -->
    @include('components/navbar')

    <!-- Container Utama -->
    <main class="flex-grow container mx-auto p-4 max-w-3xl mt-20 flex bg-white shadow-md rounded-lg overflow-hidden">
        <!-- Sidebar (Daftar Chat) -->
        <div class="w-2/5 border-r border-gray-300 overflow-y-auto">
            <h3 class="text-md font-semibold p-3 bg-gray-200">Chat</h3>
            <ul class="divide-y divide-gray-200">
                <li class="p-2 hover:bg-gray-100 cursor-pointer flex items-center">
                    <img class="h-8 w-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-3.jpg" alt="Dosen">
                    <div class="ml-2">
                        <p class="text-sm font-medium">Dr. Budi Santoso</p>
                        <p class="text-xs text-gray-500">Halo, bagaimana TA Anda?</p>
                    </div>
                </li>
                <li class="p-2 hover:bg-gray-100 cursor-pointer flex items-center">
                    <img class="h-8 w-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="Mahasiswa">
                    <div class="ml-2">
                        <p class="text-sm font-medium">Andi Wijaya</p>
                        <p class="text-xs text-gray-500">Baik Pak, saya sudah revisi</p>
                    </div>
                </li>
            </ul>
        </div>
        
        <!-- Panel Chat (Isi Chat) -->
        <div class="w-3/5 flex flex-col">
            <!-- Header Chat -->
            <div class="p-3 border-b border-gray-300 flex items-center">
                <img class="h-8 w-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-3.jpg" alt="Dosen">
                <p class="ml-2 text-sm font-medium">Dr. Budi Santoso</p>
            </div>
            
            <!-- Isi Chat -->
            <div class="flex-1 p-3 space-y-3 overflow-y-auto h-64">
                <div class="flex items-start space-x-2">
                    <img class="h-6 w-6 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-3.jpg" alt="Dosen">
                    <div class="bg-gray-200 p-2 rounded-lg max-w-xs">
                        <p class="text-xs">Halo, bagaimana perkembangan TA Anda?</p>
                        <span class="text-[10px] text-gray-500">08:30 AM</span>
                    </div>
                </div>
                <div class="flex items-start space-x-2 justify-end">
                    <div class="bg-blue-500 text-white p-2 rounded-lg max-w-xs">
                        <p class="text-xs">Halo Pak, saya sudah menyelesaikan Bab 2.</p>
                        <span class="text-[10px] text-gray-200">08:45 AM</span>
                    </div>
                    <img class="h-6 w-6 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="Mahasiswa">
                </div>
            </div>
            
            <!-- Form Kirim Pesan -->
            <form action="#" method="POST" class="p-3 border-t border-gray-300">
                <div class="flex gap-2">
                    <input type="text" name="message" placeholder="Tulis pesan..." class="flex-grow p-2 border rounded-md text-sm focus:outline-none focus:ring focus:border-blue-400">
                    <button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded-md text-sm">Kirim</button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    @include('components/footer')
</body>
</html>
