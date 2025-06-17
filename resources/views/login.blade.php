<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIBITA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        inter: ["Inter", "sans-serif"],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                },
            },
        };
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .gradient-overlay {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.8) 0%, rgba(37, 99, 235, 0.9) 100%);
        }

        .glass-effect {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.95);
        }

        .input-focus:focus {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2);
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(59, 130, 246, 0.4);
        }

        .pattern-bg {
            background-image:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.15) 0%, transparent 50%);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 overflow-auto">

    <!-- Background Pattern -->
    <div class="absolute inset-0 pattern-bg"></div>

    <!-- Main Container -->
    <div class="min-h-screen flex relative z-10">

        <!-- Left Side - Image Section -->
        <div class="hidden lg:flex lg:w-1/2 xl:w-3/5 relative overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0">
                <img src="{{ asset('images/fmipaa.png') }}"
                     alt="Campus Background"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 gradient-overlay"></div>
            </div>

            <!-- Content Overlay -->
            <div class="relative z-10 flex flex-col justify-center items-center text-white p-12 text-center">
                <div class="animate-fade-in">
                    <!-- Logo -->
                    <div class="mb-8 animate-float">
                        <img src="{{ asset('images/logo.png') }}"
                             alt="SIBITA Logo"
                             class="w-24 h-20 mx-auto mb-4 drop-shadow-lg">
                    </div>

                    <!-- Welcome Text -->
                    <h1 class="text-4xl xl:text-5xl font-bold mb-4 leading-tight">
                        Selamat Datang di
                        <span class="block text-yellow-300">SIBITA</span>
                    </h1>

                    <p class="text-xl xl:text-2xl mb-6 opacity-90 font-light">
                        Sistem Informasi Bimbingan Tugas Akhir
                    </p>

                    <div class="w-24 h-1 bg-yellow-300 mx-auto rounded-full mb-8"></div>

                    <p class="text-lg opacity-80 max-w-md leading-relaxed">
                        Platform digital untuk memudahkan proses bimbingan tugas akhir mahasiswa dengan dosen pembimbing.
                    </p>
                </div>

                <!-- Decorative Elements -->
                <div class="absolute top-20 left-20 w-32 h-32 bg-white opacity-10 rounded-full animate-float" style="animation-delay: 0.5s;"></div>
                <div class="absolute bottom-20 right-20 w-20 h-20 bg-yellow-300 opacity-20 rounded-full animate-float" style="animation-delay: 1s;"></div>
                <div class="absolute top-1/2 left-10 w-16 h-16 bg-white opacity-10 rounded-full animate-float" style="animation-delay: 1.5s;"></div>
            </div>
        </div>

        <!-- Right Side - Form Section -->
        <div class="w-full lg:w-1/2 xl:w-2/5 flex items-center justify-center p-6 lg:p-12 overflow-auto">
            <div class="w-full max-w-md">

                <!-- Mobile Logo (visible on small screens) -->
                <div class="lg:hidden text-center mb-8 animate-slide-up">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="SIBITA Logo"
                         class="w-16 h-14 mx-auto mb-3">
                    <h1 class="text-2xl font-bold text-gray-800">SIBITA</h1>
                    <p class="text-sm text-gray-600">Sistem Informasi Bimbingan Tugas Akhir</p>
                </div>

                <!-- Form Container -->
                <div class="glass-effect rounded-2xl p-8 shadow-2xl animate-slide-up" style="animation-delay: 0.2s;">

                    <!-- Form Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-2">
                            Masuk ke Akun
                        </h2>
                        <p class="text-gray-600">
                            Silakan masuk dengan kredensial Anda
                        </p>
                    </div>

                    <!-- Error Message -->
                    @if ($errors->has('login'))
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-r-lg animate-slide-up">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-400 mr-2"></i>
                                <p class="text-red-700 text-sm">{{ $errors->first('login') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="/login" class="space-y-6">
                        @csrf

                        <!-- Role Selection -->
                        <div class="space-y-2">
                            <label for="role" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-user-tag mr-2 text-blue-500"></i>
                                Login Sebagai
                            </label>
                            <div class="relative">
                                <select id="role"
                                        name="role"
                                        class="w-full p-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 input-focus transition-all duration-300 appearance-none bg-white text-gray-700 font-medium"
                                        required>
                                    <option value="" disabled selected class="text-gray-400">
                                        Pilih peran Anda
                                    </option>
                                    <option value="mahasiswa" class="text-gray-700">
                                        Mahasiswa
                                    </option>
                                    <option value="dosen" class="text-gray-700">
                                        Dosen
                                    </option>
                                    <option value="admin" class="text-gray-700">
                                        Admin
                                    </option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>

                        <!-- NPM/NIP Input -->
                        <div class="space-y-2">
                            <label for="npm" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-id-card mr-2 text-blue-500"></i>
                                NPM / NIP
                            </label>
                            <div class="relative">
                                <input type="text"
                                       id="npm"
                                       name="npm"
                                       class="w-full p-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 input-focus transition-all duration-300 font-medium"
                                       placeholder="Masukkan NPM atau NIP Anda"
                                       value="{{ old('npm') }}"
                                       required>
                                <i class="fas fa-user absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-lock mr-2 text-blue-500"></i>
                                Password
                            </label>
                            <div class="relative">
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="w-full p-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 input-focus transition-all duration-300 font-medium pr-12"
                                       placeholder="••••••••••••"
                                       required>
                                <button type="button"
                                        onclick="togglePassword()"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <i id="passwordIcon" class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold p-4 rounded-xl hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 btn-hover transition-all duration-300 shadow-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Masuk ke Dashboard
                        </button>

                    </form>

                    <!-- Footer -->
                    <div class="mt-8 text-center">
                        <p class="text-sm text-gray-500">
                            © {{ date('Y') }} SIBITA - Fakultas MIPA Universitas Syiah Kuala
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Form validation and UX improvements
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = document.querySelectorAll('input, select');

            // Add floating label effect
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.classList.remove('focused');
                    }
                });

                // Check if input has value on page load
                if (input.value) {
                    input.parentElement.classList.add('focused');
                }
            });

            // Form submission animation
            form.addEventListener('submit', function() {
                const button = this.querySelector('button[type="submit"]');
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Masuk...';
                button.disabled = true;
            });

            // Role selection change effect
            const roleSelect = document.getElementById('role');
            roleSelect.addEventListener('change', function() {
                const npmInput = document.getElementById('npm');
                const npmLabel = npmInput.previousElementSibling;

                if (this.value === 'mahasiswa') {
                    npmInput.placeholder = 'Masukkan NPM Anda';
                    npmLabel.innerHTML = '<i class="fas fa-id-card mr-2 text-blue-500"></i>NPM';
                } else if (this.value === 'dosen') {
                    npmInput.placeholder = 'Masukkan NIP Anda';
                    npmLabel.innerHTML = '<i class="fas fa-id-card mr-2 text-blue-500"></i>NIP';
                } else if (this.value === 'admin') {
                    npmInput.placeholder = 'Masukkan Username Admin';
                    npmLabel.innerHTML = '<i class="fas fa-id-card mr-2 text-blue-500"></i>Username';
                }
            });
        });

        // Add some interactive animations
        document.querySelectorAll('.glass-effect').forEach(el => {
            el.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });

            el.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>
