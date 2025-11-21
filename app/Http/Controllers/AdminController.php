<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Like;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboard.admin');
    }

    public function approveArtikel($id)
    {
        Artikel::where('id_artikel', $id)->update(['status' => 'publish']);
        return back()->with('success', 'Artikel berhasil disetujui!');
    }

    public function rejectArtikel($id)
    {
        Artikel::where('id_artikel', $id)->update(['status' => 'rejected']);
        return back()->with('success', 'Artikel ditolak!');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function artikelDisukai()
    {
        $likedArticles = Artikel::whereHas('likes', function($query) {
            $query->where('id_user', auth()->user()->id_user);
        })
        ->with(['penulis', 'kategori'])
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('admin.artikel-disukai', compact('likedArticles'));
    }

    public function laporan()
    {
        // Artikel per hari (7 hari terakhir)
        $artikelPerHari = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i);
            $artikelPerHari[] = [
                'tanggal' => $tanggal->format('d M'),
                'jumlah' => Artikel::whereDate('created_at', $tanggal)->where('status', 'publish')->count()
            ];
        }

        // Artikel per bulan (6 bulan terakhir)
        $artikelPerBulan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $artikelPerBulan[] = [
                'bulan' => $bulan->format('M Y'),
                'jumlah' => Artikel::whereYear('created_at', $bulan->year)
                    ->whereMonth('created_at', $bulan->month)
                    ->where('status', 'publish')
                    ->count()
            ];
        }

        // Artikel per kategori
        $artikelPerKategori = Kategori::withCount(['artikel' => function($query) {
            $query->where('status', 'publish');
        }])->get();

        return compact('artikelPerHari', 'artikelPerBulan', 'artikelPerKategori');
    }

    public function profil()
    {
        return view('admin.profil');
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . auth()->user()->id_user . ',id_user'
        ]);

        auth()->user()->update([
            'nama' => $request->nama,
            'username' => $request->username
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.tambah-user');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,guru,siswa'
        ]);
        
        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        
        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Tidak bisa menghapus admin terakhir!');
        }
        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }

    public function createArtikel()
    {
        $kategoris = Kategori::all();
        return view('admin.buat-artikel', compact('kategoris'));
    }

    public function storeArtikel(Request $request)
    {
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

        Artikel::create([
            'judul' => $request->judul,
            'konten' => $request->isi,
            'id_user' => auth()->user()->id_user,
            'id_kategori' => $request->id_kategori,
            'foto' => $fotoPath,
            'status' => 'publish'
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Artikel berhasil dibuat!');
    }
}