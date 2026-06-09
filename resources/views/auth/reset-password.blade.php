<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buat Kata Sandi Baru — Inventory Toko Plastik Diza</title>

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

            <!-- Security feature list -->
            <div class="relative z-10 space-y-3 mt-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center flex-shrink-0 border border-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-blue-100 font-medium text-sm">Privasi & Akses</p>
                        <p class="text-blue-200/70 text-xs mt-0.5">Selalu gunakan sandi yang kuat.</p>
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
            <div class="animate-fade-up delay-1 mb-6">
                {{-- Mobile logo --}}
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
                    Buat Kata Sandi Baru ✨
                </h2>
                <p class="text-gray-500 text-sm mt-1.5 leading-relaxed">
                    Silakan masukkan email Anda dan tentukan kata sandi baru untuk akun Anda.
                </p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="animate-fade-up delay-2">
                    <label for="email" class="block text-xs font-medium text-gray-600 mb-1.5 tracking-wide uppercase">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input id="email"
                               class="input-field w-full pl-10 pr-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white' }} text-gray-900 text-sm transition duration-200"
                               type="email"
                               name="email"
                               value="{{ old('email', $request->email) }}"
                               required autofocus autocomplete="username" readonly />
                    </div>
                    @error('email')
                        <p class="has-error mt-1.5 text-xs text-red-500 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="animate-fade-up delay-3">
                    <label for="password" class="block text-xs font-medium text-gray-600 mb-1.5 tracking-wide uppercase">
                        Kata Sandi Baru
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input id="password"
                               class="input-field w-full pl-10 pr-12 py-3 rounded-xl border {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white' }} text-gray-900 text-sm transition duration-200"
                               type="password"
                               name="password"
                               placeholder="Min. 8 karakter"
                               required autocomplete="new-password" />
                        
                        <button type="button" onclick="togglePassword('password', 'eye-show-1', 'eye-hide-1')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg id="eye-show-1" xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eye-hide-1" xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="has-error mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="animate-fade-up delay-4">
                    <label for="password_confirmation" class="block text-xs font-medium text-gray-600 mb-1.5 tracking-wide uppercase">
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </span>
                        <input id="password_confirmation"
                               class="input-field w-full pl-10 pr-12 py-3 rounded-xl border {{ $errors->has('password_confirmation') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white' }} text-gray-900 text-sm transition duration-200"
                               type="password"
                               name="password_confirmation"
                               placeholder="Ulangi kata sandi"
                               required autocomplete="new-password" />
                               
                        <button type="button" onclick="togglePassword('password_confirmation', 'eye-show-2', 'eye-hide-2')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg id="eye-show-2" xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eye-hide-2" xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="has-error mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="animate-fade-up delay-5 pt-3">
                    <button type="submit"
                            class="btn-primary w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                                   text-white font-semibold py-3.5 rounded-xl text-sm tracking-wide
                                   transition-all duration-200 flex items-center justify-center gap-2
                                   shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        SIMPAN & MASUK
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toggle password script -->
    <script>
        function togglePassword(inputId, eyeShowId, eyeHideId) {
            const input = document.getElementById(inputId);
            const eyeShow = document.getElementById(eyeShowId);
            const eyeHide = document.getElementById(eyeHideId);
            const isHidden = input.type === 'password';
            
            input.type = isHidden ? 'text' : 'password';
            eyeShow.classList.toggle('hidden', isHidden);
            eyeHide.classList.toggle('hidden', !isHidden);
        }
    </script>
</body>
</html>
