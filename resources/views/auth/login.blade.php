<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Smart Pocket</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#ecfdf5', 100: '#d1fae5', 200: '#a7f3d0',
                            300: '#6ee7b7', 400: '#34d399', 500: '#10b981',
                            600: '#059669', 700: '#047857', 800: '#065f46', 900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .card-grad-1 { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
        .gradient-text { background: linear-gradient(135deg, #059669 0%, #10b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        .input-modern {
            transition: all 0.2s ease;
        }
        .input-modern:focus {
            transform: translateY(-1px);
        }
        
        .btn-modern {
            transition: all 0.2s ease;
        }
        .btn-modern:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
        }
        .btn-modern:active {
            transform: translateY(0);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-brand-50/30 min-h-screen flex items-center justify-center p-4">

    <!-- SATU CARD BESAR -->
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.06)] border border-slate-100 overflow-hidden animate-fade-in">
        
        <div class="grid lg:grid-cols-2">
            
            <!-- KIRI: Branding -->
            <div class="p-8 lg:p-10 bg-gradient-to-br from-brand-50/50 to-white">
                
                <!-- Logo -->
                <div class="flex items-center gap-2.5 mb-8">
                    <div class="w-10 h-10 card-grad-1 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-lg text-slate-900">Smart Pocket</div>
                        <div class="text-[10px] text-slate-500">BMT SMKN 11 BANDUNG</div>
                    </div>
                </div>

                <!-- Heading -->
                <h1 class="text-3xl font-bold leading-snug mb-4 tracking-tight">
                    Membangun Masa Depan <br>
                    Finansial Siswa <br>
                    <span class="gradient-text">SMKN 11.</span>
                </h1>

                <!-- Deskripsi -->
                <p class="text-sm text-slate-600 mb-8 leading-relaxed">
                    Platform perbankan mini yang dirancang khusus untuk memfasilitasi kebutuhan transaksi, tabungan, dan pembelajaran keuangan.
                </p>

                <!-- Stats -->
                <div class="flex items-center gap-6 pt-6 border-t border-slate-200">
                    <div>
                        <div class="text-2xl font-bold text-slate-900">500+</div>
                        <div class="text-xs text-slate-500 mt-0.5">Siswa Aktif</div>
                    </div>
                    <div class="w-px h-10 bg-slate-200"></div>
                    <div>
                        <div class="text-2xl font-bold text-slate-900">24/7</div>
                        <div class="text-xs text-slate-500 mt-0.5">Akses Mandiri</div>
                    </div>
                    <div class="w-px h-10 bg-slate-200"></div>
                    <div>
                        <div class="text-2xl font-bold text-slate-900 flex items-center gap-1.5">
                            Safe
                            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                            </svg>
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5">Terintegrasi</div>
                    </div>
                </div>

            </div>

            <!-- KANAN: Form Login -->
            <div class="p-8 lg:p-10 border-l border-slate-100">
                
                <!-- Header Form -->
                <div class="text-center mb-6">
                    <div class="w-12 h-12 card-grad-1 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 mb-1">Masuk ke Akun Anda</h2>
                    <p class="text-xs text-slate-500">Akses Dashboard Bank Mini Terpadu</p>
                </div>

                @if (session('status'))
                    <div class="mb-4 p-3 bg-brand-50 border border-brand-200 rounded-lg flex items-start gap-2">
                        <svg class="w-4 h-4 text-brand-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-brand-800 font-medium">{{ session('status') }}</p>
                    </div>
                @endif

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    
                    <!-- Username -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nomor Induk Siswa / Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="username" 
                                value="{{ old('username') }}" 
                                required 
                                autofocus
                                autocomplete="username"
                                class="input-modern block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500" 
                                placeholder="siswa@smkn11.sch.id"
                            >
                        </div>
                        @error('username')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                </svg>
                            </div>
                            <input 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="current-password"
                                class="input-modern block w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500" 
                                placeholder="••••••••"
                            >
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg id="eye-icon" class="w-4 h-4 text-slate-400 hover:text-slate-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="flex justify-end mt-1.5">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">Lupa Password?</a>
                            @endif
                        </div>
                        @error('password')
                            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-brand-600 border-slate-200 rounded focus:ring-brand-500">
                        <label for="remember" class="text-xs text-slate-600">Ingat saya di perangkat ini</label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn-modern w-full card-grad-1 text-white font-semibold py-2.5 px-4 rounded-lg shadow-md flex items-center justify-center gap-2 text-sm">
                        Masuk Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>
                </form>

                <!-- Footer -->
                <div class="mt-5 pt-4 border-t border-slate-100">
                    <p class="text-center text-xs text-slate-600">
                        Belum memiliki akun? 
                        <a href="#" class="font-semibold text-brand-600 hover:text-brand-700">Hubungi Admin</a>
                    </p>
                </div>

            </div>

        </div>

    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.querySelector('input[name="password"]');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>';
            }
        }
    </script>
</body>
</html>