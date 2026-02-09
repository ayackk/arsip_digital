<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// HALAMAN DEPAN (WELCOME)
Route::get('/', function () {
    $totalArsip = DB::table('arsip_dokumen')->count();
    $totalUser = DB::table('user')->count();
    $totalJenis = DB::table('jenis_arsip')->count();

    $latestDocs = DB::table('arsip_dokumen')
        ->leftJoin('jenis_arsip', 'arsip_dokumen.jenis_arsip_id', '=', 'jenis_arsip.id')
        ->select('arsip_dokumen.*', 'jenis_arsip.nama_jenis')
        ->latest('arsip_dokumen.created_at')
        ->take(5)
        ->get();

    return view('welcome', compact('totalArsip', 'totalUser', 'totalJenis', 'latestDocs'));
});

// HALAMAN LOGIN (Langsung panggil file login.blade.php)
Route::get('/login', function () {
    return view('login'); 
})->name('login');

// PROSES LOGIN (Diarahkan ke dashboard)
Route::post('/login', function (Request $request) {
    return redirect()->route('dashboard');
})->name('login.post');

// HALAMAN DASHBOARD
Route::get('/dashboard', function (Request $request) {
    $search = $request->query('search');
    $kategori = $request->query('kategori');

    $totalArsip = DB::table('arsip_dokumen')->count();
    $totalUser = DB::table('user')->count();
    $totalJenis = DB::table('jenis_arsip')->count();
    
    $listKategori = DB::table('jenis_arsip')->get();

    $query = DB::table('arsip_dokumen')
        ->leftJoin('jenis_arsip', 'arsip_dokumen.jenis_arsip_id', '=', 'jenis_arsip.id')
        ->select('arsip_dokumen.*', 'jenis_arsip.nama_jenis');

    if ($search) {
        $query->where('arsip_dokumen.judul_arsip', 'LIKE', "%{$search}%");
    }

    if ($kategori) {
        $query->where('arsip_dokumen.jenis_arsip_id', $kategori);
    }

    $latestDocs = $query->latest('arsip_dokumen.created_at')->get();

    return view('dashboard', compact('totalArsip', 'totalUser', 'totalJenis', 'latestDocs', 'listKategori'));
})->name('dashboard');
// PROSES LOGOUT
Route::get('/logout', function () {
    // Menghapus semua sesi user
    session()->flush();
    // Balikkan ke halaman login atau landing page
    return redirect()->route('login');
})->name('logout');