<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | ARSIP DIGITAL</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fff5f2',
                            500: '#FFAB96', 
                            600: '#e89a87',
                            900: '#4a2d26',
                        },
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        .dot-pattern {
            background-image: radial-gradient(#FFAB96 0.5px, transparent 0.5px);
            background-size: 24px 24px;
            opacity: 0.12;
        }
    </style>
</head>
<body class="antialiased h-full flex items-center justify-center p-6 text-slate-900 bg-white relative overflow-hidden">

    <div class="fixed inset-0 dot-pattern -z-10"></div>
    <div class="fixed top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl -z-10"></div>
    <div class="fixed bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl -z-10"></div>

    <div class="w-full max-w-md relative">
        <div class="text-center mb-10">
            <a href="{{ url('/') }}" class="inline-flex flex-col items-center group">
                <div class="w-20 h-20 mb-4 flex items-center justify-center transition-transform duration-500 group-hover:scale-110">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">
                    ARSIP <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary-500 to-orange-400">DIGITAL</span>
                </h1>
            </a>
            <p class="mt-3 text-slate-500 font-medium italic">Silakan autentikasi identitas Anda</p>
        </div>

        <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-2xl shadow-primary-500/5 p-10 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary-500 to-orange-400"></div>

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="login" class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Email / Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-primary-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="login" id="login" required 
                            class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/5 focus:border-primary-500 transition-all text-slate-900 font-medium" 
                            placeholder="Masukkan akun Anda">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2 ml-1">
                        <label for="password" class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Password</label>
                        <a href="#" class="text-xs font-bold text-primary-500 hover:text-primary-600 transition-colors">Lupa Akses?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-300 group-focus-within:text-primary-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required 
                            class="block w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-primary-500/5 focus:border-primary-500 transition-all text-slate-900 font-medium" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center px-1">
                    <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-slate-300 rounded cursor-pointer">
                    <label for="remember_me" class="ml-2 block text-sm text-slate-500 font-bold cursor-pointer">
                        Ingat sesi saya
                    </label>
                </div>

                <button type="submit" 
                    class="w-full flex justify-center py-4 px-4 bg-primary-900 hover:bg-primary-500 text-white text-sm font-bold rounded-2xl shadow-xl shadow-primary-900/20 transition-all duration-300 hover:-translate-y-1 active:scale-95">
                    Otorisasi Masuk
                </button>
            </form>

            <div class="mt-10 pt-6 border-t border-slate-50 text-center">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                    Pusat Bantuan: 
                    <a href="#" class="text-primary-500 hover:text-primary-600 transition-colors">Hubungi Admin BRIDA</a>
                </p>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-primary-900 transition-all group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:-translate-x-1 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>