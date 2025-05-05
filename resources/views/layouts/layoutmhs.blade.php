<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
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
<body class="flex flex-col min-h-screen font-poppins">
@include('components/navbar')
<main class="flex-grow pb-10 pt-20 bg-slate-100">
 @yield('content')
</main>
@include('components/footer')
</body>
</html>