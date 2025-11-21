<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - E-Mading Baknus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
            padding: 8px 0;
        }
        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shimmer 3s infinite;
        }
        .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            position: relative;
            z-index: 2;
        }
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .hero-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 25px;
        }
        .hero-stats {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }
        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
        }
        .quick-action-card {
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s ease;
        }
        .quick-action-card:hover {
            transform: translateY(-5px);
            color: inherit;
        }
        .quick-action-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: white;
            font-size: 1.5rem;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            border-radius: 15px;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .stat-card {
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1a5276;
            margin-bottom: 5px;
        }
        .stat-label {
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        .dropdown-menu {
            z-index: 99999 !important;
            position: absolute !important;
        }
        .navbar .dropdown {
            z-index: 10000 !important;
            position: relative !important;
        }
        .navbar-nav .dropdown-menu {
            z-index: 99999 !important;
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
        }
        .navbar-nav .nav-item.dropdown {
            position: relative !important;
            z-index: 10000 !important;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-user-shield me-2"></i>
                <span>E-Mading</span>
                <span style="color: #ffd700;">Admin</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border: none; background: rgba(255,255,255,0.2);">
                <i class="fas fa-bars text-white"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.users') }}">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.artikel') }}">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.artikel-disukai') }}">Disukai</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.laporan') }}">Laporan</a></li>
                </ul>
                <div class="d-flex me-3">
                    <input class="form-control me-2" type="search" id="searchInput" placeholder="Cari artikel..." style="border-radius: 20px; border: 2px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); color: white;">
                    <button class="btn btn-outline-light" type="button" id="searchBtn" style="border-radius: 20px;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="d-flex align-items-center">
                    <span class="text-white me-2 small">{{ Auth::user()->nama }}</span>
                    <a href="{{ route('admin.profil') }}" class="btn btn-outline-light btn-sm me-1" title="Profil">
                        <i class="fas fa-user"></i>
                    </a>
                    <button onclick="document.getElementById('logout-form').submit();" class="btn btn-outline-light btn-sm" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <!-- Hero Section -->
        <div class="hero-section mb-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="hero-content">
                        <h1 class="hero-title">Dashboard Admin</h1>
                        <p class="hero-subtitle">Kelola sistem E-Mading Baknus dengan kontrol penuh</p>
                        <div class="hero-stats">
                            <div class="stat-item">
                                <i class="fas fa-newspaper text-primary"></i>
                                <span>{{ \App\Models\Artikel::where('id_user', auth()->user()->id_user)->count() }} Artikel Saya</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-users text-success"></i>
                                <span>{{ \App\Models\User::count() }} Total User</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-clock text-warning"></i>
                                <span>{{ \App\Models\Artikel::where('status', 'pending')->count() }} Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="hero-image">
                        <img src="{{ asset('logo.png') }}" alt="E-Mading Admin" class="img-fluid rounded-3 shadow">
                    </div>
                </div>
            </div>
        </div>
        

        
        <!-- Chart Section -->
        <div id="chartSection" class="chart-section mb-5">
            <h5 class="mb-4"><i class="fas fa-chart-pie text-primary me-2"></i>Statistik & Chart</h5>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Artikel per Status</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="statusChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i>Artikel per Hari (7 Hari Terakhir)</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="hariChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>User per Role</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="userChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Artikel per Kategori</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="kategoriChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Artikel Terbaru Section -->
        <div class="artikel-section mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0"><i class="fas fa-newspaper text-primary me-2"></i>Artikel Terbaru</h5>
                <a href="{{ route('admin.artikel') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-eye me-1"></i>Lihat Semua
                </a>
            </div>
            <div class="row mb-4" id="artikelContainer">
                @php
                    $artikelTerbaru = \App\Models\Artikel::with(['penulis', 'kategori'])
                        ->where('status', 'publish')
                        ->orderBy('created_at', 'desc')
                        ->take(6)
                        ->get();
                @endphp
                @foreach ($artikelTerbaru as $artikel)
                    <div class="col-md-4 mb-3 artikel-item">
                        <div class="card" style="cursor: pointer;" onclick="window.location.href='{{ route('admin.artikel.detail', $artikel->id_artikel) }}'">
                            <img src="{{ $artikel->foto ? asset('storage/' . $artikel->foto) : 'https://via.placeholder.com/300x180?text=No+Image' }}" class="card-img-top" alt="{{ $artikel->judul }}" style="height: 180px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">{{ Str::limit($artikel->judul, 40) }}</h6>
                                <p class="card-text text-muted small">Oleh: {{ $artikel->penulis->nama ?? 'Admin' }}</p>
                                @if($artikel->kategori)
                                    <span class="badge bg-primary mb-2">{{ $artikel->kategori->nama_kategori }}</span>
                                @endif
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="text-danger small">
                                            <i class="fas fa-heart"></i> {{ $artikel->totalLikes() }}
                                        </span>
                                        <span class="text-primary ms-2 small">
                                            <i class="fas fa-comment"></i> {{ $artikel->totalKomentars() }}
                                        </span>
                                    </div>
                                    <small class="text-muted">{{ $artikel->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Konfirmasi Artikel Section -->
        <div id="konfirmasiSection" class="konfirmasi-section mb-5">
            <h5 class="mb-4"><i class="fas fa-check-circle text-warning me-2"></i>Konfirmasi Artikel</h5>
            <div class="card">
                <div class="card-body">
                    @php
                        $artikelPending = \App\Models\Artikel::with('penulis')->where('status', 'pending')->latest()->take(5)->get();
                    @endphp
                    @if($artikelPending->count() > 0)
                        @foreach($artikelPending as $artikel)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $artikel->judul }}</h6>
                                    <small class="text-muted">Oleh: {{ $artikel->penulis->nama }} - {{ $artikel->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="btn-group">
                                    <form method="POST" action="{{ route('artikel.approve', $artikel->id_artikel) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('artikel.reject', $artikel->id_artikel) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <p class="text-muted">Tidak ada artikel yang menunggu konfirmasi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Data User Section -->
        <div id="userSection" class="user-section mb-5">
            <h5 class="mb-4"><i class="fas fa-users text-info me-2"></i>Data User</h5>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Bergabung</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $semuaUser = \App\Models\User::latest()->take(10)->get();
                                @endphp
                                @foreach($semuaUser as $user)
                                    <tr>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>
                                            @if($user->role == 'admin')
                                                <span class="badge bg-danger">Admin</span>
                                            @elseif($user->role == 'guru')
                                                <span class="badge bg-success">Guru</span>
                                            @else
                                                <span class="badge bg-primary">Siswa</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Kategori Section -->
        <div id="kategoriSection" class="kategori-section mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0"><i class="fas fa-tags text-warning me-2"></i>Kelola Kategori</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                    <i class="fas fa-plus me-2"></i>Tambah Kategori
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @php
                            $kategoriList = \App\Models\Kategori::withCount('artikel')->get();
                        @endphp
                        @foreach($kategoriList as $kategori)
                            <div class="col-md-4 mb-3">
                                <div class="card border">
                                    <div class="card-body text-center">
                                        <i class="fas fa-tag fa-2x text-primary mb-2"></i>
                                        <h6>{{ $kategori->nama_kategori }}</h6>
                                        <small class="text-muted">{{ $kategori->artikel_count }} artikel</small>
                                        <div class="mt-2">
                                            <form method="POST" action="{{ route('admin.kategori.delete', $kategori->id_kategori) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" {{ $kategori->artikel_count > 0 ? 'disabled title=Kategori masih digunakan' : '' }}>
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Laporan Section -->
        <div id="laporanSection" class="laporan-section mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0"><i class="fas fa-file-alt text-danger me-2"></i>Laporan Sistem</h5>
                <button class="btn btn-success" onclick="printLaporan()">
                    <i class="fas fa-print me-2"></i>Print Laporan
                </button>
            </div>
            <div id="laporanContent">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">LAPORAN E-MADING BAKNUS</h5>
                        <small>Tanggal: {{ date('d F Y') }}</small>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <div class="card text-center border-primary">
                                    <div class="card-body">
                                        <div class="stat-number text-primary">{{ \App\Models\Artikel::count() }}</div>
                                        <div class="stat-label">Total Artikel</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card text-center border-success">
                                    <div class="card-body">
                                        <div class="stat-number text-success">{{ \App\Models\Artikel::where('status', 'publish')->count() }}</div>
                                        <div class="stat-label">Artikel Publish</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card text-center border-warning">
                                    <div class="card-body">
                                        <div class="stat-number text-warning">{{ \App\Models\Artikel::where('status', 'pending')->count() }}</div>
                                        <div class="stat-label">Artikel Pending</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card text-center border-info">
                                    <div class="card-body">
                                        <div class="stat-number text-info">{{ \App\Models\User::count() }}</div>
                                        <div class="stat-label">Total User</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Statistik User per Role:</h6>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Admin</span>
                                        <span class="badge bg-danger">{{ \App\Models\User::where('role', 'admin')->count() }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Guru</span>
                                        <span class="badge bg-success">{{ \App\Models\User::where('role', 'guru')->count() }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Siswa</span>
                                        <span class="badge bg-primary">{{ \App\Models\User::where('role', 'siswa')->count() }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Artikel per Kategori:</h6>
                                <ul class="list-group">
                                    @foreach($artikelPerKategori as $kategori)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>{{ $kategori->nama_kategori }}</span>
                                        <span class="badge bg-primary">{{ $kategori->artikel_count }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6>Artikel Hari Ini vs Kemarin:</h6>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Hari Ini</span>
                                        <span class="badge bg-success">{{ \App\Models\Artikel::whereDate('created_at', today())->where('status', 'publish')->count() }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Kemarin</span>
                                        <span class="badge bg-info">{{ \App\Models\Artikel::whereDate('created_at', today()->subDay())->where('status', 'publish')->count() }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Aktivitas Terbaru:</h6>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total Like</span>
                                        <span class="badge bg-danger">{{ \App\Models\Like::count() }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Total Komentar</span>
                                        <span class="badge bg-info">{{ \App\Models\Komentar::count() }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>Bulan Ini</span>
                                        <span class="badge bg-warning">{{ \App\Models\Artikel::whereMonth('created_at', now()->month)->where('status', 'publish')->count() }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center text-muted">
                        <small>Laporan digenerate otomatis oleh sistem E-Mading Baknus</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="tambahKategoriModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.kategori.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Form Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Publish', 'Pending', 'Ditolak'],
                datasets: [{
                    data: [
                        {{ \App\Models\Artikel::where('status', 'publish')->count() }},
                        {{ \App\Models\Artikel::where('status', 'pending')->count() }},
                        {{ \App\Models\Artikel::where('status', 'rejected')->count() }}
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Artikel per Hari Chart
        const hariCtx = document.getElementById('hariChart').getContext('2d');
        new Chart(hariCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($artikelPerHari, 'tanggal')) !!},
                datasets: [{
                    label: 'Artikel Published',
                    data: {!! json_encode(array_column($artikelPerHari, 'jumlah')) !!},
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Artikel per Kategori Chart
        const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');
        new Chart(kategoriCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($artikelPerKategori->pluck('nama_kategori')) !!},
                datasets: [{
                    label: 'Jumlah Artikel',
                    data: {!! json_encode($artikelPerKategori->pluck('artikel_count')) !!},
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // User Chart
        const userCtx = document.getElementById('userChart').getContext('2d');
        new Chart(userCtx, {
            type: 'bar',
            data: {
                labels: ['Admin', 'Guru', 'Siswa'],
                datasets: [{
                    label: 'Jumlah User',
                    data: [
                        {{ \App\Models\User::where('role', 'admin')->count() }},
                        {{ \App\Models\User::where('role', 'guru')->count() }},
                        {{ \App\Models\User::where('role', 'siswa')->count() }}
                    ],
                    backgroundColor: ['#007bff', '#28a745', '#ffc107']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Search functionality
        let searchTimeout;
        $('#searchInput').on('input', function() {
            clearTimeout(searchTimeout);
            var query = $(this).val();
            
            searchTimeout = setTimeout(function() {
                if (query.length >= 2) {
                    performSearch(query);
                } else if (query.length === 0) {
                    resetToOriginal();
                }
            }, 300);
        });
        
        $('#searchBtn').on('click', function() {
            var query = $('#searchInput').val();
            if (query.length >= 2) {
                performSearch(query);
            }
        });
        
        function performSearch(query) {
            $.ajax({
                url: '/dashboard/search',
                type: 'GET',
                data: { q: query, ajax: true },
                success: function(response) {
                    $('#artikelContainer').html(response);
                    $('.artikel-section h5').html('<i class="fas fa-search text-primary me-2"></i>Hasil Pencarian: "' + query + '"');
                },
                error: function() {
                    alert('Gagal melakukan pencarian');
                }
            });
        }
        
        function resetToOriginal() {
            location.reload();
        }
        
        // Function untuk print laporan
        function printLaporan() {
            var printContent = document.getElementById('laporanContent').innerHTML;
            var originalContent = document.body.innerHTML;
            
            document.body.innerHTML = `
                <html>
                <head>
                    <title>Laporan E-Mading Baknus</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        @media print {
                            body { margin: 0; }
                            .no-print { display: none; }
                        }
                        .stat-number { font-size: 2rem; font-weight: 700; }
                    </style>
                </head>
                <body>
                    ${printContent}
                </body>
                </html>
            `;
            
            window.print();
            document.body.innerHTML = originalContent;
            location.reload();
        }
    </script>
</body>
</html>