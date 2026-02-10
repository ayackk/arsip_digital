<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ARSIP DIGITAL | Enterprise Archiving System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fff5f2',  // Sangat muda
                            500: '#FFAB96', // Warna utama pilihanmu
                            600: '#e89a87', // Sedikit lebih gelap untuk hover
                            900: '#4a2d26', // Gelap (Cokelat-Coral) untuk kontras teks
                        },
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        .dot-pattern {
            /* Menggunakan warna utama dengan opacity rendah */
            background-image: radial-gradient(#FFAB96 0.5px, transparent 0.5px);
            background-size: 24px 24px;
            opacity: 0.15;
        }
    </style>
</head>
<body class="antialiased h-full flex flex-col items-center justify-between text-slate-900 overflow-x-hidden">

    <div class="fixed inset-0 dot-pattern -z-10"></div>
    <div class="fixed top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl -z-10"></div>
    <div class="fixed bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl -z-10"></div>

    <header class="w-full max-w-7xl px-8 py-8 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 flex items-center justify-center">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-full w-full object-contain">
            </div>

            <span class="font-extrabold tracking-tight text-xl uppercase">
                Arsip <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary-500 to-orange-400">Digital</span>
            </span>
        </div>

        <div class="flex items-center gap-6">
            <a href="{{ url('/login') }}" class="text-sm font-bold text-primary-500 hover:text-primary-600 transition-colors">Portal Login →</a>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center px-6 py-12">
        <div class="max-w-4xl text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-100 border border-slate-200 text-slate-600 text-[10px] font-black uppercase tracking-[0.2em] mb-8">
                Official Digital Archive System
            </div>

            <h1 class="text-6xl md:text-8xl font-extrabold text-primary-900 tracking-tight leading-[0.9] mb-8">
                Aman. Cepat. <br>
                <span class="text-primary-500">Terorganisir.</span>
            </h1>

            <p class="text-xl md:text-2xl text-slate-500 max-w-2xl mx-auto font-medium leading-relaxed mb-12">
                Kelola ribuan dokumen instansi dalam satu platform terpadu dengan standar keamanan tinggi.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ url('/login') }}"
                    class="w-full sm:w-auto px-12 py-5 bg-primary-900 text-white rounded-2xl font-bold text-lg shadow-2xl shadow-primary-500/20 hover:bg-primary-500 transition-all duration-300 hover:-translate-y-1 active:scale-95">
                    Login
                </a>
            </div>
        </div>
    </main>

    <footer class="w-full max-w-7xl px-8 py-12">
        <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-sm text-slate-400 font-medium italic">
                &copy; {{ date('Y') }} Arsip Digital. BRIDA.
            </p>
        </div>
    </footer>

</body>
</html>
