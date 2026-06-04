<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk — Inventory Toko Plastik Diza</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: DM Sans + DM Serif Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet" />

    <style>
        * { font-family: 'DM Sans', sans-serif; }

        body {
            background-color: #f0f2f5;
            background-image:
                radial-gradient(at 20% 30%, rgba(59,130,246,0.07) 0px, transparent 60%),
                radial-gradient(at 80% 70%, rgba(99,102,241,0.06) 0px, transparent 60%);
            min-height: 100vh;
        }

        .card-glass {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* Floating label animation */
        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label {
            transform: translateY(-1.6rem) scale(0.82);
            color: #2563eb;
            font-weight: 500;
        }

        .input-group label {
            transition: all 0.2s ease;
            transform-origin: left;
            pointer-events: none;
        }

        /* Custom focus ring */
        .input-field:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.12);
        }

        /* Animated underline logo text */
        .brand-title {
            font-family: 'DM Serif Display', serif;
            letter-spacing: -0.02em;
        }

        /* Subtle grid pattern on the left panel */
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.07) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* Shimmer on button hover */
        .btn-login {
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
            transition: left 0.45s ease;
        }

        .btn-login:hover::after { left: 160%; }

        /* Checkbox custom */
        input[type="checkbox"]:checked {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        /* Error shake */
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%,60%  { transform: translateX(-4px); }
            40%,80%  { transform: translateX(4px); }
        }
        .has-error { animation: shake 0.4s ease; }

        /* Fade-in on load */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-up { animation: fadeUp 0.55s ease forwards; }
        .delay-1 { animation-delay: 0.05s; opacity: 0; }
        .delay-2 { animation-delay: 0.12s; opacity: 0; }
        .delay-3 { animation-delay: 0.20s; opacity: 0; }
        .delay-4 { animation-delay: 0.28s; opacity: 0; }
        .delay-5 { animation-delay: 0.36s; opacity: 0; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <!-- ══════════════════════════════════════════
         MAIN CARD — Centered design with left accent
    ═══════════════════════════════════════════ -->
    <div class="w-full max-w-[900px] rounded-3xl overflow-hidden shadow-2xl shadow-blue-900/10 flex"
         style="min-height: 560px;">

        <!-- ── LEFT PANEL (branding) ── -->
        <div class="left-panel relative hidden md:flex flex-col justify-between p-10 w-[42%]
                    bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white overflow-hidden">

            <!-- Decorative circles -->
            <div class="absolute -top-16 -left-16 w-56 h-56 rounded-full bg-white/5"></div>
            <div class="absolute bottom-10 -right-12 w-40 h-40 rounded-full bg-white/5"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                        w-64 h-64 rounded-full bg-white/[0.03]"></div>

            <!-- Logo block -->
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-white/15 flex items-center justify-center mb-6
                            border border-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20 7H4a1 1 0 00-1 1v10a1 1 0 001 1h16a1 1 0 001-1V8a1 1 0 00-1-1z"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 12v4M10 14h4"/>
                    </svg>
                </div>
                <h1 class="brand-title text-2xl font-normal leading-tight mb-2">
                    Toko Plastik<br/><span class="text-blue-200">Diza</span>
                </h1>
                <p class="text-blue-200/80 text-sm leading-relaxed">
                    Sistem manajemen inventory barang modern untuk pengelolaan stok yang efisien.
                </p>
            </div>

            <!-- Feature list -->
            <div class="relative z-10 space-y-3">
                @foreach([
                    ['icon' => 'M9 12l2 2 4-4', 'text' => 'Kelola barang masuk & keluar'],
                    ['icon' => 'M9 12l2 2 4-4',  'text' => 'Laporan stok real-time'],
                    ['icon' => 'M9 12l2 2 4-4',  'text' => 'Request stok oleh karyawan'],
                ] as $f)
                <div class="flex items-center gap-3">
                    <div class="w-5 h-5 rounded-full bg-white/20 flex items-center justify-content-center flex-shrink-0
                                border border-white/30 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="text-blue-100/90 text-sm">{{ $f['text'] }}</span>
                </div>
                @endforeach
            </div>

            <!-- Bottom note -->
            <div class="relative z-10">
                <p class="text-blue-300/60 text-xs">
                    © {{ date('Y') }} Toko Plastik Diza. All rights reserved.
                </p>
            </div>
        </div>

        <!-- ── RIGHT PANEL (form) ── -->
        <div class="card-glass flex-1 flex flex-col justify-center px-8 py-10 md:px-12">

            <!-- Header -->
            <div class="animate-fade-up delay-1 mb-8">

                {{-- Mobile logo (only show on small screens) --}}
                <div class="flex items-center gap-2 mb-6 md:hidden">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M20 7H4a1 1 0 00-1 1v10a1 1 0 001 1h16a1 1 0 001-1V8a1 1 0 00-1-1z"/>
                        </svg>
                    </div>
                    <span class="brand-title text-lg text-gray-800">Toko Plastik Diza</span>
                </div>

                <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">
                    Selamat datang kembali 👋
                </h2>
                <p class="text-gray-500 text-sm mt-1">
                    Silakan masuk untuk mengelola stok barang.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="animate-fade-up delay-1 mb-5 flex items-start gap-3 bg-green-50 border border-green-200
                            text-green-800 text-sm rounded-xl px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mt-0.5 flex-shrink-0 text-green-600"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div class="animate-fade-up delay-2">
                    <label for="email"
                           class="block text-xs font-medium text-gray-600 mb-1.5 tracking-wide uppercase">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-[18px] h-[18px] text-gray-400" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input id="email"
                               class="input-field w-full pl-10 pr-4 py-3 rounded-xl border
                                      {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white' }}
                                      text-gray-900 text-sm placeholder-gray-400
                                      transition duration-200 hover:border-gray-300"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="nama@email.com"
                               required
                               autofocus
                               autocomplete="username" />
                    </div>
                    @error('email')
                        <p class="has-error mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 flex-shrink-0"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="animate-fade-up delay-3 space-y-2">
                    <label for="password" class="block text-xs font-medium text-gray-600 tracking-wide uppercase">
                        Kata Sandi
                    </label>

                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>

                        <input id="password"
                               class="input-field w-full pl-10 pr-12 py-3 rounded-xl border {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white' }} text-gray-900 text-sm placeholder-gray-400 transition duration-200 hover:border-gray-300 focus:ring-2 focus:ring-blue-500/20"
                               type="password"
                               name="password"
                               placeholder="Masukkan kata sandi"
                               required
                               autocomplete="current-password" />
        
                        <button type="button" onclick="togglePassword()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                            <svg id="eye-show" xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-hide" xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>

                    @error('password')
                        <p class="has-error mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror

                    @if (Route::has('password.request'))
                        <div class="flex justify-end pt-0.5">
                            <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium transition-colors">
                                Lupa password?
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Remember me -->
                <div class="animate-fade-up delay-4 flex items-center gap-2.5">
                    <input id="remember_me"
                           type="checkbox"
                           name="remember"
                           class="w-4 h-4 rounded border-gray-300 text-blue-600
                                  focus:ring-blue-500 focus:ring-offset-0 cursor-pointer" />
                    <label for="remember_me"
                           class="text-sm text-gray-600 select-none cursor-pointer">
                        Ingat Saya
                    </label>
                </div>

                <!-- Submit -->
                <div class="animate-fade-up delay-5 pt-1">
                    <button type="submit"
                            class="btn-login w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                                   text-white font-semibold py-3.5 rounded-xl text-sm tracking-wide
                                   transition-all duration-200 flex items-center justify-center gap-2
                                   focus:outline-none focus:ring-4 focus:ring-blue-500/30
                                   shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        MASUK
                    </button>
                </div>

            </form>

            <!-- Footer note -->
            <p class="animate-fade-up delay-5 mt-6 text-center text-xs text-gray-400">
                Hanya untuk pengguna terdaftar.
                Hubungi admin untuk mendapatkan akses.
            </p>

        </div>
    </div>

    <!-- Toggle password script -->
    <script>
        function togglePassword() {
            const input   = document.getElementById('password');
            const eyeShow = document.getElementById('eye-show');
            const eyeHide = document.getElementById('eye-hide');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            eyeShow.classList.toggle('hidden', isHidden);
            eyeHide.classList.toggle('hidden', !isHidden);
        }
    </script>
</body>
</html>