<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Kata Sandi — Inventory Toko Plastik Diza</title>

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
        .btn-primary {
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease;
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
            transition: left 0.45s ease;
        }

        .btn-primary:hover::after { left: 160%; }

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
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 9c0-4.5 8-4.5 8 0" />
                        <rect x="5" y="9" width="14" height="12" rx="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" opacity="0.6" />
                    </svg>
                </div>
                <h1 class="brand-title text-2xl font-normal leading-tight mb-2">
                    Toko Plastik<br/><span class="text-blue-200">Diza</span>
                </h1>
                <p class="text-blue-200/80 text-sm leading-relaxed">
                    Sistem manajemen inventory barang modern untuk pengelolaan stok yang efisien.
                </p>
            </div>

            <!-- Feature list (altered for recovery context) -->
            <div class="relative z-10 space-y-3 mt-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0 border border-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-blue-100 font-medium text-sm">Keamanan Terjamin</p>
                        <p class="text-blue-200/70 text-xs mt-0.5">Kami menjaga data akses Anda.</p>
                    </div>
                </div>
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
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 9c0-4.5 8-4.5 8 0" />
                            <rect x="5" y="9" width="14" height="12" rx="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" opacity="0.6" />
                        </svg>
                    </div>
                    <span class="brand-title text-lg text-gray-800">Toko Plastik Diza</span>
                </div>

                <h2 class="text-2xl font-semibold text-gray-900 tracking-tight">
                    Lupa Kata Sandi? 🔒
                </h2>
                <p class="text-gray-500 text-sm mt-2 leading-relaxed">
                    Tidak masalah. Masukkan alamat email yang terdaftar, dan kami akan mengirimkan tautan untuk membuat kata sandi yang baru.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="animate-fade-up delay-1 mb-5 flex items-start gap-3 bg-green-50 border border-green-200
                            text-green-800 text-sm rounded-xl px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 flex-shrink-0 text-green-600"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                    <div class="font-medium">{{ session('status') }}</div>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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
                               class="input-field w-full pl-10 pr-4 py-3.5 rounded-xl border
                                      {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white' }}
                                      text-gray-900 text-sm placeholder-gray-400
                                      transition duration-200 hover:border-gray-300"
                               type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="nama@email.com"
                               required
                               autofocus />
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

                <!-- Submit -->
                <div class="animate-fade-up delay-3 pt-2">
                    <button type="submit"
                            class="btn-primary w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                                   text-white font-semibold py-3.5 rounded-xl text-sm tracking-wide
                                   transition-all duration-200 flex items-center justify-center gap-2
                                   focus:outline-none focus:ring-4 focus:ring-blue-500/30
                                   shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                        </svg>
                        KIRIM TAUTAN RESET
                    </button>
                </div>
            </form>

            <!-- Back to Login -->
            <div class="animate-fade-up delay-4 mt-8 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke halaman Masuk
                </a>
            </div>

        </div>
    </div>

</body>
</html>
