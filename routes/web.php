<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. HALAMAN DEPAN (GUEST ONLY)
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
})->name('welcome');

// 2. HALAMAN LOGIN (GUEST ONLY)
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->intended(Auth::user()->role === 'pegawai' ? '/dashboard' : '/admin');
    }
    return view('login');
})->name('login');

// 3. PROSES LOGIN (DENGAN AUTH & REDIRECT ROLE)
Route::post('/login', function (Request $request) {
    // 1. Ambil input 'login' dari form lo, terus validasi
    $credentials = [
        'email' => $request->login, // Sesuaikan 'login' dari Blade ke kolom 'email' di DB
        'password' => $request->password,
    ];

    // Proses Autentikasi
if (Auth::attempt($credentials, $request->remember)) {
    $request->session()->regenerate();
    $user = Auth::user();

    if (in_array($user->role, ['admin', 'operator'])) {
        // Paksa login ke guard filament jika perlu
        return redirect()->intended('/admin');
    }

    return redirect()->intended('/dashboard');
}

    // Jika gagal, balik ke login dengan pesan error
    return back()->withErrors([
        'email' => 'Waduh, email atau password lo salah bro!',
    ])->onlyInput('email');

})->name('login.post');

// 4. AREA DASHBOARD PEGAWAI (PROTECTED BY AUTH)
Route::middleware(['auth'])->group(function () {

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

        // Filter pencarian
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
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome');
    })->name('logout');

});


    Route::match(['get', 'post'], '/admin/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('filament.admin.auth.logout');
