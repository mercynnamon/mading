<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;

Route::get('/', [\App\Http\Controllers\PublicController::class, 'index'])->name('public.index');

// Public routes for visitors (no authentication required)
Route::get('/artikel/{id}', [\App\Http\Controllers\PublicController::class, 'artikel'])->name('public.artikel');
Route::get('/kategori/{id}', [\App\Http\Controllers\PublicController::class, 'kategori'])->name('public.kategori');
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('public.search');

// Routes untuk user yang sudah login di halaman publik
Route::middleware(['auth'])->group(function () {
    Route::post('/public/like/{id}', [LikeController::class, 'toggle'])->name('public.like');
    Route::post('/public/artikel/{id}/komentar', function ($id, \Illuminate\Http\Request $request) {
        $request->validate(['isi' => 'required|string']);
        
        \App\Models\Komentar::create([
            'isi' => $request->isi,
            'id_artikel' => $id,
            'id_user' => auth()->user()->id_user
        ]);
        
        return back()->with('success', 'Komentar berhasil ditambahkan!');
    })->name('public.komentar.store');
});

// Dashboard redirect for authenticated users
Route::get('/dashboard', function () {
    if (auth()->check()) {
        $user = auth()->user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'guru':
                return redirect()->route('guru.dashboard');
            case 'siswa':
                return redirect()->route('siswa.dashboard');
            default:
                auth()->logout();
                return redirect()->route('login')->with('error', 'Role tidak valid.');
        }
    }
    return redirect()->route('login');
})->name('dashboard');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.submit');
});
Route::middleware(['auth'])->post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Admin routes - hanya admin yang bisa akses
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () { 
            $adminController = new \App\Http\Controllers\AdminController();
            $laporan = $adminController->laporan();
            return view('dashboard.admin', $laporan); 
        })->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/admin/users/store', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/admin/artikel', function (\Illuminate\Http\Request $request) {
            $query = \App\Models\Artikel::with(['penulis', 'kategori']);
            
            if ($request->filter == 'guru') {
                $query->whereHas('penulis', function($q) {
                    $q->where('role', 'guru');
                });
            } elseif ($request->filter == 'siswa') {
                $query->whereHas('penulis', function($q) {
                    $q->where('role', 'siswa');
                });
            }
            
            $artikel = $query->orderBy('created_at', 'desc')->get();
            return view('admin.artikel', compact('artikel'));
        })->name('admin.artikel');
    Route::post('/admin/artikel/{id}/approve', function ($id) {
        \App\Models\Artikel::where('id_artikel', $id)->update(['status' => 'publish']);
        return back()->with('success', 'Artikel berhasil disetujui!');
    })->name('artikel.approve');
    Route::post('/admin/artikel/{id}/reject', function ($id) {
        \App\Models\Artikel::where('id_artikel', $id)->update(['status' => 'rejected']);
        return back()->with('success', 'Artikel ditolak!');
    })->name('artikel.reject');
        Route::post('/admin/kategori/store', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori'
            ]);
            
            \App\Models\Kategori::create([
                'nama_kategori' => $request->nama_kategori
            ]);
            
            return back()->with('success', 'Kategori berhasil ditambahkan!');
        })->name('admin.kategori.store');
        Route::delete('/admin/kategori/{id}', function ($id) {
            $kategori = \App\Models\Kategori::findOrFail($id);
            if ($kategori->artikel()->count() > 0) {
                return back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh artikel!');
            }
            $kategori->delete();
            return back()->with('success', 'Kategori berhasil dihapus!');
        })->name('admin.kategori.delete');
        Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::get('/admin/artikel-disukai', [AdminController::class, 'artikelDisukai'])->name('admin.artikel-disukai');
        Route::get('/admin/laporan', function() {
            $adminController = new \App\Http\Controllers\AdminController();
            $laporan = $adminController->laporan();
            return view('admin.laporan', $laporan);
        })->name('admin.laporan');
        Route::get('/admin/profil', [AdminController::class, 'profil'])->name('admin.profil');
        Route::post('/admin/profil', [AdminController::class, 'updateProfil'])->name('admin.profil.update');
        Route::get('/admin/artikel/create', [AdminController::class, 'createArtikel'])->name('admin.artikel.create');
        Route::post('/admin/artikel/store', [AdminController::class, 'storeArtikel'])->name('admin.artikel.store');
        Route::get('/admin/artikel-detail/{id}', function ($id, \Illuminate\Http\Request $request) {
            $artikel = \App\Models\Artikel::with(['penulis', 'kategori', 'komentars.user'])
                ->where('id_artikel', $id)
                ->firstOrFail();
            $backUrl = $request->get('back', route('admin.dashboard'));
            return view('artikel.detail', compact('artikel', 'backUrl'));
        })->name('admin.artikel.detail');
    });
    
 
    Route::middleware(['role:guru'])->group(function () {
        Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
        Route::get('/guru/artikel-saya', [GuruController::class, 'artikelSaya'])->name('guru.artikel-saya');
        Route::get('/guru/artikel-pending', [GuruController::class, 'artikelPending'])->name('guru.artikel-pending');
        Route::post('/guru/artikel/{id}/approve', [GuruController::class, 'approveArtikel'])->name('guru.artikel.approve');
        Route::post('/guru/artikel/{id}/reject', [GuruController::class, 'rejectArtikel'])->name('guru.artikel.reject');
        Route::get('/guru/artikel-disukai', [GuruController::class, 'artikelDisukai'])->name('guru.artikel-disukai');
        Route::get('/guru/profil', [GuruController::class, 'profil'])->name('guru.profil');
        Route::post('/guru/profil', [GuruController::class, 'updateProfil'])->name('guru.profil.update');
        Route::get('/guru/artikel/create', [GuruController::class, 'createArtikel'])->name('guru.artikel.create');
        Route::post('/guru/artikel/store', [GuruController::class, 'storeArtikel'])->name('guru.artikel.store');
    });
    
    // Siswa routes 
    Route::middleware(['role:siswa'])->group(function () {
        Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
        Route::get('/siswa/artikel-saya', [SiswaController::class, 'artikelSaya'])->name('siswa.artikel-saya');
        Route::get('/siswa/artikel-disukai', [SiswaController::class, 'artikelDisukai'])->name('siswa.artikel-disukai');
        Route::get('/siswa/profil', [SiswaController::class, 'profil'])->name('siswa.profil');
        Route::post('/siswa/profil', [SiswaController::class, 'updateProfil'])->name('siswa.profil.update');
        Route::get('/siswa/artikel/create', [SiswaController::class, 'createArtikel'])->name('siswa.artikel.create');
        Route::post('/siswa/artikel/store', [SiswaController::class, 'storeArtikel'])->name('siswa.artikel.store');
    });
    
    // Artikel routes 
    Route::middleware(['role:admin,guru,siswa'])->group(function () {
        Route::get('/artikel/create', function () {
            $kategoris = \App\Models\Kategori::all();
            return view('dashboard.siswa.buat-artikel', compact('kategoris'));
        })->name('artikel.create');
        
    Route::post('/artikel/store', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'judul' => 'required|string|max:255',
            'id_kategori' => 'required|integer|exists:kategori,id_kategori',
            'isi' => 'required|string',
            'foto' => 'nullable|image|max:2048'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('artikel', 'public');
        }

        $status = in_array(auth()->user()->role, ['admin', 'guru']) ? 'publish' : 'pending';
        
        \App\Models\Artikel::create([
            'judul' => $request->judul,
            'konten' => $request->isi,
            'id_user' => auth()->user()->id_user,
            'id_kategori' => $request->id_kategori,
            'foto' => $fotoPath,
            'status' => $status
        ]);

        $redirectRoute = match(auth()->user()->role) {
            'admin' => 'admin.dashboard',
            'guru' => 'guru.dashboard', 
            'siswa' => 'siswa.dashboard',
            default => 'login'
        };
        return redirect()->route($redirectRoute)->with('success', 'Artikel berhasil dibuat!');
    })->name('artikel.store');
        Route::delete('/artikel/{id}', function ($id) {
            $artikel = \App\Models\Artikel::where('id_artikel', $id)
                ->where('id_user', auth()->user()->id_user)
                ->first();
            if ($artikel) {
                $artikel->delete();
                return response()->json(['success' => true, 'message' => 'Artikel berhasil dihapus!']);
            }
            return response()->json(['success' => false, 'message' => 'Artikel tidak ditemukan!']);
        })->name('artikel.delete');
    });

    // Routes yang bisa diakses semua role yang sudah login
    Route::get('/artikel-detail/{id}', function ($id) {
        $artikel = \App\Models\Artikel::with(['penulis', 'kategori', 'komentars.user'])
            ->where('id_artikel', $id)
            ->firstOrFail();
        return view('artikel.detail', compact('artikel'));
    })->name('artikel.detail');
    
    // Search route for authenticated users (dashboard search)
    Route::get('/dashboard/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('dashboard.search');

    
    // Like route  (admin, guru, siswa)
    Route::post('/like/{id}', [LikeController::class, 'toggle'])->name('like.toggle');
    Route::post('/siswa/like/{id}', [LikeController::class, 'toggle'])->name('siswa.like');
    
    // Komentar route
    Route::post('/artikel/{id}/komentar', function ($id, \Illuminate\Http\Request $request) {
        $request->validate(['isi' => 'required|string']);
        
        \App\Models\Komentar::create([
            'isi' => $request->isi,
            'id_artikel' => $id,
            'id_user' => auth()->user()->id_user
        ]);
        
        return back()->with('success', 'Komentar berhasil ditambahkan!');
    })->name('komentar.store');
});