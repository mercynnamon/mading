<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Ambil semua user untuk dropdown
        $users = User::orderBy('nama')->get();
        return view('auth.login', compact('users'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'Username tidak ditemukan.',
            ])->withInput();
        }

        // Debug password check
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah.',
            ])->withInput();
        }

        Auth::login($user);
        
        // Regenerate session untuk keamanan
        $request->session()->regenerate();
        
        // Clear any previous intended URL to prevent wrong redirects
        $request->session()->forget('url.intended');

        // Redirect berdasarkan role dengan intended URL check
        $intendedUrl = $request->session()->pull('url.intended');
        
        // Jika ada intended URL, pastikan sesuai dengan role
        if ($intendedUrl) {
            $allowedPaths = $this->getAllowedPathsForRole($user->role);
            $path = parse_url($intendedUrl, PHP_URL_PATH);
            
            foreach ($allowedPaths as $allowedPath) {
                if (str_starts_with($path, $allowedPath)) {
                    return redirect($intendedUrl);
                }
            }
        }

        // Default redirect berdasarkan role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'guru':
                return redirect()->route('guru.dashboard');
            case 'siswa':
                return redirect()->route('siswa.dashboard');
            default:
                Auth::logout();
                return redirect()->route('public.index')->withErrors(['username' => 'Role tidak valid.']);
        }
    }
    
    private function getAllowedPathsForRole($role)
    {
        switch ($role) {
            case 'admin':
                return ['/admin'];
            case 'guru':
                return ['/guru', '/artikel'];
            case 'siswa':
                return ['/siswa', '/artikel'];
            default:
                return [];
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('public.index')->with('success', 'Anda telah berhasil logout.');
    }
}