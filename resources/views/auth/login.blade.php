<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Smart Pocket BMT SMKN 11</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0',
                            300: '#86efac', 400: '#4ade80', 500: '#22c55e',
                            600: '#16a34a', 700: '#15803d', 800: '#166534', 900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }
        
        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        body {
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .input-field {
            transition: all 0.2s ease;
        }
        .input-field:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
        }
        
        .btn-masuk {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            transition: all 0.2s ease;
        }
        .btn-masuk:hover {
            background: linear-gradient(135deg, #15803d 0%, #166534 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.3);
        }
        
        .login-card {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08), 0 4px 20px rgba(0, 0, 0, 0.04);
        }
        
        .checkbox-custom {
            appearance: none;
            width: 16px;
            height: 16px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .checkbox-custom:checked {
            background: #16a34a;
            border-color: #16a34a;
        }
        .checkbox-custom:checked::after {
            content: '';
            position: absolute;
            left: 4px;
            top: 1px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        .dot-pattern {
            background-image: radial-gradient(circle, #e5e7eb 1px, transparent 1px);
            background-size: 24px 24px;
        }
        
        .blob-1 {
            background: radial-gradient(circle, rgba(34, 197, 94, 0.08) 0%, transparent 70%);
        }
        .blob-2 {
            background: radial-gradient(circle, rgba(134, 239, 172, 0.1) 0%, transparent 70%);
        }
    </style>
</head>
<body class="bg-white">

    <!-- MAIN CONTENT (Tanpa Navbar) -->
    <main class="min-h-screen flex">
        
        <!-- LEFT SIDE: Marketing Content (60%) -->
        <div class="hidden lg:flex lg:w-[60%] relative overflow-hidden bg-gradient-to-br from-slate-50 to-white">
            <!-- Dot Pattern Background -->
            <div class="absolute inset-0 dot-pattern opacity-40"></div>
            
            <!-- Decorative Blobs -->
            <div class="absolute top-20 right-20 w-96 h-96 blob-1 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 left-20 w-80 h-80 blob-2 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col justify-center px-16 xl:px-24 py-16 max-w-3xl">
                
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 border border-amber-200 rounded-full mb-8 w-fit">
                    <i class="ph ph-graduation-cap text-amber-600 text-sm"></i>
                    <span class="text-xs font-semibold text-amber-800">Edukasi Literasi Finansial Terpadu</span>
                </div>

                <!-- Heading -->
                <h1 class="text-5xl xl:text-6xl font-black text-slate-900 leading-[1.1] tracking-tight mb-6">
                    Membangun Masa Depan<br>
                    Finansial Siswa <span class="text-brand-500">SMKN 11</span>.
                </h1>

                <!-- Description -->
                <p class="text-base text-slate-600 leading-relaxed mb-10 max-w-xl">
                    Platform perbankan mini yang dirancang khusus untuk memfasilitasi kebutuhan transaksi, tabungan, dan pembelajaran keuangan bagi seluruh komunitas SMKN 11 Bandung.
                </p>

                <!-- Stats -->
                <div class="flex items-center gap-12 pt-8 border-t border-slate-200">
                    <div>
                        <p class="text-3xl font-black text-slate-900 mb-1">500+</p>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Siswa Aktif</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-slate-900 mb-1">24/7</p>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Akses Mandiri</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-slate-900 mb-1 flex items-center gap-2">
                            Safe
                            <i class="ph ph-shield-check text-brand-600 text-2xl"></i>
                        </p>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Sistem Terintegrasi</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- RIGHT SIDE: Login Card (40%) -->
        <div class="w-full lg:w-[40%] flex items-center justify-center p-6 lg:p-12 bg-slate-50/50">
            <div class="w-full max-w-md">
                
                <!-- Login Card -->
                <div class="login-card bg-white rounded-2xl p-8 lg:p-10 border border-slate-100">
                    
                    <!-- Lock Icon -->
                    <div class="flex justify-center mb-6">
                        <div class="w-14 h-14 bg-brand-50 rounded-full flex items-center justify-center">
                            <i class="ph ph-lock-key text-brand-600 text-2xl"></i>
                        </div>
                    </div>

                    <!-- Card Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">Masuk ke Akun Anda</h2>
                        <p class="text-sm text-slate-500">Akses Dashboard Bank Mini Terpadu</p>
                    </div>

                    @if (session('status'))
                        <div class="mb-6 p-3 bg-brand-50 border border-brand-200 rounded-lg flex items-start gap-2">
                            <i class="ph ph-check-circle text-brand-600 text-lg flex-shrink-0 mt-0.5"></i>
                            <p class="text-xs text-brand-800 font-medium">{{ session('status') }}</p>
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-xs font-semibold text-slate-700 mb-1.5">
                                Nomor Induk Siswa / Username
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="ph ph-user text-slate-400 text-base"></i>
                                </div>
                                <input 
                                    id="username" 
                                    type="text" 
                                    name="username" 
                                    value="{{ old('username') }}" 
                                    required 
                                    autofocus
                                    autocomplete="username"
                                    class="input-field w-full pl-10 pr-4 py-3 bg-white border border-slate-200 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none text-sm"
                                    placeholder="Masukkan NIS atau Username"
                                >
                            </div>
                            @error('username')
                                <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                                    <i class="ph ph-warning-circle text-sm"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="block text-xs font-semibold text-slate-700">
                                    Kata Sandi
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="ph ph-lock-key text-slate-400 text-base"></i>
                                </div>
                                <input 
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    required 
                                    autocomplete="current-password"
                                    class="input-field w-full pl-10 pr-10 py-3 bg-white border border-slate-200 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none text-sm"
                                    placeholder="••••••••"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-brand-600 transition"
                                >
                                    <i id="eye-icon" class="ph ph-eye text-base"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                                    <i class="ph ph-warning-circle text-sm"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center pt-1">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer gap-2">
                                <input 
                                    id="remember_me" 
                                    type="checkbox" 
                                    name="remember"
                                    class="checkbox-custom"
                                >
                                <span class="text-sm text-slate-600">Ingat saya di perangkat ini</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button 
                            type="submit" 
                            class="btn-masuk w-full py-3.5 text-white font-bold rounded-lg flex items-center justify-center gap-2 text-sm mt-4"
                        >
                            Masuk Sekarang
                            <i class="ph ph-arrow-right text-base"></i>
                        </button>

                    </form>

                    <!-- Sign Up -->
                    <p class="text-center text-sm text-slate-600 mt-6">
                        Belum memiliki akun? 
                        <a href="#" class="font-bold text-brand-600 hover:text-brand-700 transition">Daftar di Bank Mini Terpadu</a>
                    </p>

                </div>

            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-slate-100 py-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-6">
                
                <!-- Left: Brand -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-brand-700 rounded-lg flex items-center justify-center shadow-lg shadow-brand-500/30">
                        <i class="ph ph-wallet text-white text-lg"></i>
                    </div>
                    <div>
                        <div class="font-bold text-sm text-slate-900">SMKN 11 Bandung</div>
                        <div class="text-xs text-slate-500">Jl. Banteng Wetan No.8, Bandung</div>
                    </div>
                </div>

                <!-- Center: Links -->
                <div class="flex flex-wrap items-center gap-6 text-xs text-slate-600">
                    <a href="#" class="hover:text-brand-600 transition">Panduan Pengguna</a>
                    <a href="#" class="hover:text-brand-600 transition">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-brand-600 transition">Kebijakan Privasi</a>
                </div>

                <!-- Right: Support Team -->
                <div class="flex items-center gap-2">
                    <div class="flex -space-x-2">
                        <div class="w-7 h-7 rounded-full bg-brand-100 border-2 border-white flex items-center justify-center">
                            <i class="ph ph-user text-brand-600 text-xs"></i>
                        </div>
                        <div class="w-7 h-7 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center">
                            <i class="ph ph-user text-emerald-600 text-xs"></i>
                        </div>
                        <div class="w-7 h-7 rounded-full bg-teal-100 border-2 border-white flex items-center justify-center">
                            <i class="ph ph-user text-teal-600 text-xs"></i>
                        </div>
                    </div>
                    <span class="text-xs text-slate-600">Tim Support Siap Membantu</span>
                </div>

            </div>

            <div class="pt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    &copy; {{ date('Y') }} Bank Mini Terpadu SMKN 11 Bandung. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'ph ph-eye-slash text-base';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'ph ph-eye text-base';
            }
        }
    </script>
</body>
</html>