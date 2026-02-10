<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arsip Digital | Smart Repository</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fff5f2',
                            100: '#ffece7',
                            500: '#FFAB96',
                            600: '#e89a87',
                            700: '#4a2d26'
                        }
                    },
                    fontFamily: { sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #fcfaf9; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        .custom-scrollbar::-webkit-scrollbar { height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        /* Scrollbar juga pakai warna coral */
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #FFAB96; border-radius: 10px; }
    </style>
</head>
<body class="antialiased text-slate-900 px-4 py-6 md:px-8">

    <div class="max-w-[1400px] mx-auto space-y-8">

        <nav class="flex flex-col md:flex-row items-center justify-between gap-6 bg-white/70 backdrop-blur-md p-4 rounded-3xl border border-white shadow-sm ring-1 ring-slate-200/50">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 flex items-center justify-center">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-full w-full object-contain">
                </div>
                <div>
                    <h1 class="text-xl font-extrabold tracking-tight text-slate-800">
                        ARSIP<span class="text-primary-500">DIGITAL</span>
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}" class="text-sm font-bold text-slate-500 hover:text-primary-500 px-4 transition-colors">Beranda</a>
                <div class="h-6 w-[1px] bg-slate-200"></div>
                <a href="{{ url('/logout') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary-700 hover:bg-red-600 text-white rounded-2xl font-bold text-sm transition-all shadow-xl shadow-primary-700/20 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                    <button type="submit" class="text-red-500">
                         Keluar Aplikasi
            </button>
        </form>
                </a>
            </div>
        </nav>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">

            <div class="p-8 border-b border-slate-50 flex flex-col xl:flex-row xl:items-center justify-between gap-8">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800">Eksplorasi Dokumen</h2>
                    <p class="text-sm text-slate-400 mt-1">Gunakan kata kunci atau filter kategori untuk mencari data spesifik.</p>
                </div>

                <form action="{{ url('/dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full xl:w-auto">
                    <div class="relative group">
                        <select name="kategori" onchange="this.form.submit()" class="appearance-none w-full xl:w-56 bg-slate-50 border-none rounded-2xl px-6 py-4 text-sm font-bold text-slate-600 outline-none ring-2 ring-transparent focus:ring-primary-500 transition-all cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach($listKategori as $kat)
                                <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_jenis }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>

                    <div class="relative group">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama dokumen..." class="w-full xl:w-80 pl-14 pr-6 py-4 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-primary-500 outline-none transition-all shadow-inner">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-5 text-[11px] font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100">Judul Dokumen</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100">Tgl Naskah</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100">OPD / Instansi</th>
                            <th class="px-6 py-5 text-[11px] font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100">Kategori</th>
                            <th class="px-8 py-5 text-[11px] font-extrabold uppercase tracking-wider text-primary-500 border-b border-slate-100 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($latestDocs as $doc)
                        <tr class="group hover:bg-primary-50/50 transition-all duration-300">
                            <td class="px-8 py-6 max-w-xs">
                                <div class="flex flex-col">
                                    <span class="font-bold text-slate-700 group-hover:text-primary-700 transition-colors line-clamp-2">
                                        {{ $doc->judul_arsip ?? 'Untitled Document' }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 mt-1 font-medium">Ref ID: #{{ $doc->id ?? '000' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-6 whitespace-nowrap">
                                <div class="text-sm text-slate-500 font-semibold italic">
                                    {{ isset($doc->tanggal_naskah) ? date('d M Y', strtotime($doc->tanggal_naskah)) : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-lg">
                                    {{ $doc->opd ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-xs font-extrabold text-primary-600 uppercase tracking-tighter">{{ $doc->nama_jenis ?? 'Umum' }}</span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                @if(isset($doc->file_arsip) && $doc->file_arsip)
                                <a href="{{ asset('storage/'.$doc->file_arsip) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white rounded-xl text-[11px] font-bold uppercase tracking-widest transition-all shadow-lg shadow-primary-500/20 active:scale-90">
                                    Buka File
                                </a>
                                @else
                                <span class="text-[10px] font-bold text-slate-300 uppercase">File Tidak Ada</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center text-slate-400 font-bold uppercase tracking-widest">Data tidak ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <footer class="flex flex-col md:flex-row items-center justify-between gap-4 py-8">
            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.4em]">© {{ date('Y') }} Digital Archive — BRIDA</p>
        </footer>
    </div>
</body>
</html>
