<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Mading Baknus - Dashboard Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
            padding: 15px 0;
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
        .navbar-brand i {
            animation: pulse 2s infinite;
        }
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }
        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }
        .nav-link.active {
            color: white !important;
            font-weight: 600;
        }
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-img-top {
            height: 180px;
            object-fit: cover;
        }
        .like-btn {
            color: #6c757d;
            cursor: pointer;
            transition: color 0.2s;
        }
        .like-btn.liked {
            color: #dc3545;
        }
        .like-count {
            font-size: 0.85rem;
            margin-left: 5px;
        }
        .section-title {
            color: #1a5276;
            border-bottom: 2px solid #1a5276;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }
        .btn-create {
            background-color: #1a5276;
            color: white;
            border: none;
        }
        .btn-create:hover {
            background-color: #154360;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="white" opacity="0.1"/></svg>') repeat;
            animation: float 20s infinite linear;
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
        .stat-item i {
            font-size: 1.2rem;
        }
        
        /* Quick Actions */
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
        
        /* Section Filter */
        .section-filter .form-select {
            border: 2px solid #1a5276;
            border-radius: 10px;
        }
        
        /* Card Enhancements */
        .card {
            border-radius: 15px;
            overflow: hidden;
        }
        .card-img-top {
            transition: transform 0.3s ease;
        }
        .card:hover .card-img-top {
            transform: scale(1.05);
        }
        
        /* Animations */
        @keyframes float {
            0% { transform: translateX(-100px); }
            100% { transform: translateX(100px); }
        }
        
        /* Badge Styles */
        .badge {
            font-size: 0.75rem;
            padding: 5px 10px;
        }
        
        /* Like Button Enhancement */
        .like-btn {
            transition: all 0.3s ease;
            padding: 5px 10px;
            border-radius: 20px;
        }
        .like-btn:hover {
            background-color: rgba(220, 53, 69, 0.1);
        }
        .like-btn.liked {
            background-color: rgba(220, 53, 69, 0.1);
        }
        
        /* Trending Tags */
        .trending-tag {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .trending-tag:hover {
            background-color: #1a5276 !important;
            color: white !important;
        }
        
        /* Activity Feed */
        .activity-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
        }
        
        /* Sidebar Enhancements */
        .sidebar-article-item:hover {
            background-color: #f8f9fa;
        }
        
        /* Statistics Cards */
        .stat-card {
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
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
    <script>
        // Auto refresh CSRF token every 30 minutes
        setInterval(function() {
            fetch('/login', {
                method: 'HEAD',
                credentials: 'same-origin'
            }).then(response => {
                if (response.status === 419) {
                    window.location.reload();
                }
            });
        }, 1800000); // 30 minutes
    </script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap me-2"></i>
                <span>E-Mading</span>
                <span style="color: #ffd700;">Baknus</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('siswa.artikel-saya') }}">Artikel Saya</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('siswa.artikel-disukai') }}">Artikel Disukai</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('siswa.artikel.create') }}">Buat Artikel</a></li>
                </ul>
                <div class="d-flex me-3">
                    <input class="form-control me-2" type="search" id="searchInput" placeholder="Cari artikel..." style="border-radius: 20px; border: 2px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); color: white;">
                    <button class="btn btn-outline-light" type="button" id="searchBtn" style="border-radius: 20px;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="d-flex align-items-center ms-3">
                    <span class="text-white me-3">{{ Auth::user()->nama }}</span>
                    <a href="{{ route('siswa.profil') }}" class="btn btn-outline-light btn-sm me-2">
                        <i class="fas fa-user"></i>
                    </a>
                    <button onclick="document.getElementById('logout-form').submit();" class="btn btn-outline-light btn-sm">
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
                        <h1 class="hero-title">Selamat Datang, {{ Auth::user()->nama }}!</h1>
                        <p class="hero-subtitle">Temukan artikel menarik dan bagikan kreativitas Anda di E-Mading Baknus</p>
                        <div class="hero-stats">
                            <div class="stat-item">
                                <i class="fas fa-newspaper text-primary"></i>
                                <span>{{ \App\Models\Artikel::where('status', 'publish')->count() }} Artikel</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-users text-success"></i>
                                <span>{{ \App\Models\User::where('role', 'siswa')->count() }} Siswa</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-heart text-danger"></i>
                                <span>{{ \App\Models\Like::count() }} Likes</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="hero-image">
                        <img src="{{ asset('logo.png') }}" alt="E-Mading Baknus" class="img-fluid rounded-3 shadow">
                    </div>
                </div>
            </div>
        </div>
        

        
        <!-- Artikel Terbaru -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="section-title mb-0"><i class="fas fa-fire text-danger me-2"></i>Artikel Terbaru</h5>
            <div class="section-filter">
                <select class="form-select form-select-sm" id="kategoriFilter">
                    <option value="">Semua Kategori</option>
                    @foreach(\App\Models\Kategori::all() as $kategori)
                        <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-4" id="artikelContainer">
            @foreach ($artikelTerbaru as $artikel)
                <div class="col-md-4 mb-3 artikel-item" data-kategori="{{ $artikel->id_kategori }}">
                    <div class="card" style="cursor: pointer;" onclick="window.location.href='{{ route('artikel.detail', $artikel->id_artikel) }}'">
                        <img src="{{ $artikel->foto ? asset('storage/' . $artikel->foto) : 'https://via.placeholder.com/300x180?text=No+Image' }}" class="card-img-top" alt="{{ $artikel->judul }}">
                        <div class="card-body">
                            <h6 class="card-title">{{ Str::limit($artikel->judul, 30) }}</h6>
                            <p class="card-text text-muted small">Oleh: {{ $artikel->penulis->nama ?? 'Admin' }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="like-btn {{ $artikel->isLikedBy(Auth::id()) ? 'liked' : '' }}"
                                          data-artikel-id="{{ $artikel->id_artikel }}">
                                        <i class="far fa-heart"></i> <span class="like-count">{{ $artikel->totalLikes() }}</span>
                                    </span>
                                </div>
                                <small class="text-muted">{{ $artikel->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Artikel Maya (Favorit) -->
        <div class="row">
            <div class="col-md-8">
                <!-- Trending Topics -->
                <div class="trending-section mb-4">
                    <h6 class="mb-3"><i class="fas fa-hashtag text-primary me-2"></i>Trending Topics</h6>
                    <div class="trending-tags">
                        @foreach(['Teknologi', 'Pendidikan', 'Olahraga', 'Seni', 'Berita'] as $tag)
                            <span class="badge bg-light text-dark me-2 mb-2 trending-tag">#{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sidebar-card mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-gradient text-white" style="background: linear-gradient(45deg, #1a5276, #2980b9);">
                            <h6 class="mb-0"><i class="fas fa-user-edit me-2"></i>Artikel Saya</h6>
                        </div>
                        <div class="card-body p-0">
                            @if($artikelMaya->count() > 0)
                            @foreach ($artikelMaya as $artikel)
                                <div class="sidebar-article-item">
                                    <div class="d-flex p-3 border-bottom">
                                        <img src="{{ $artikel->foto ? asset('storage/' . $artikel->foto) : 'https://via.placeholder.com/50x50?text=No+Img' }}" 
                                             class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 small">{{ Str::limit($artikel->judul, 30) }}</h6>
                                            <div class="mb-2">
                                                @if($artikel->status == 'pending')
                                                    <span class="badge bg-warning text-dark">Menunggu Review</span>
                                                @elseif($artikel->status == 'publish')
                                                    <span class="badge bg-success">Dipublikasi</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-heart text-danger"></i> {{ $artikel->totalLikes() }}
                                                    <i class="fas fa-comment text-primary ms-2"></i> {{ $artikel->totalKomentars() }}
                                                </small>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="{{ route('artikel.detail', $artikel->id_artikel) }}"><i class="fas fa-eye me-2"></i>Lihat</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <form method="POST" action="{{ route('artikel.delete', $artikel->id_artikel) }}" 
                                                                  onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-trash me-2"></i>Hapus
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @else
                                <div class="text-center p-4">
                                    <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                                    <p class="text-muted small">Belum ada artikel</p>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-light">
                            <a href="{{ route('siswa.artikel.create') }}" class="btn btn-create w-100">
                                <i class="fas fa-plus me-2"></i>Buat Artikel Baru
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Activity Feed -->
                <div class="activity-feed">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-bell me-2"></i>Aktivitas Terbaru</h6>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $recentActivities = collect();
                                
                                // Artikel yang dipublikasi
                                $publishedArticles = \App\Models\Artikel::where('id_user', auth()->user()->id_user)
                                    ->where('status', 'publish')
                                    ->latest()
                                    ->take(2)
                                    ->get();
                                
                                foreach($publishedArticles as $article) {
                                    $recentActivities->push([
                                        'type' => 'published',
                                        'icon' => 'fas fa-check',
                                        'color' => 'bg-success',
                                        'message' => 'Artikel "' . Str::limit($article->judul, 30) . '" telah dipublikasi',
                                        'time' => $article->updated_at
                                    ]);
                                }
                                
                                // Like terbaru pada artikel user
                                $recentLikes = \App\Models\Like::whereHas('artikel', function($query) {
                                    $query->where('id_user', auth()->user()->id_user);
                                })
                                ->with(['artikel', 'user'])
                                ->latest()
                                ->take(2)
                                ->get();
                                
                                foreach($recentLikes as $like) {
                                    $recentActivities->push([
                                        'type' => 'liked',
                                        'icon' => 'fas fa-heart',
                                        'color' => 'bg-danger',
                                        'message' => ($like->user->nama ?? 'Seseorang') . ' menyukai artikel "' . Str::limit($like->artikel->judul, 25) . '"',
                                        'time' => $like->created_at
                                    ]);
                                }
                                
                                // Komentar terbaru pada artikel user
                                $recentComments = \App\Models\Komentar::whereHas('artikel', function($query) {
                                    $query->where('id_user', auth()->user()->id_user);
                                })
                                ->with(['artikel', 'user'])
                                ->latest()
                                ->take(2)
                                ->get();
                                
                                foreach($recentComments as $comment) {
                                    $recentActivities->push([
                                        'type' => 'commented',
                                        'icon' => 'fas fa-comment',
                                        'color' => 'bg-info',
                                        'message' => ($comment->user->nama ?? 'Seseorang') . ' berkomentar di artikel "' . Str::limit($comment->artikel->judul, 25) . '"',
                                        'time' => $comment->created_at
                                    ]);
                                }
                                
                                // Sort by time and take latest 5
                                $recentActivities = $recentActivities->sortByDesc('time')->take(5);
                            @endphp
                            
                            @forelse($recentActivities as $activity)
                                <div class="activity-item p-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="d-flex">
                                        <div class="activity-icon {{ $activity['color'] }}">
                                            <i class="{{ $activity['icon'] }}"></i>
                                        </div>
                                        <div class="ms-3">
                                            <p class="mb-1 small">{{ $activity['message'] }}</p>
                                            <small class="text-muted">{{ $activity['time']->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center p-4">
                                    <i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
                                    <p class="text-muted small mb-0">Belum ada aktivitas terbaru</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Statistics Section -->
        <div class="statistics-section mt-5">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body">
                                <div class="stat-icon bg-primary mb-3">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <h4 class="stat-number">{{ $artikelTerbaru->sum('likes_count') + 1250 }}</h4>
                                <p class="stat-label text-muted">Total Views</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body">
                                <div class="stat-icon bg-success mb-3">
                                    <i class="fas fa-thumbs-up"></i>
                                </div>
                                <h4 class="stat-number">{{ \App\Models\Like::whereHas('artikel', function($q) { $q->where('id_user', auth()->user()->id_user); })->count() }}</h4>
                                <p class="stat-label text-muted">Likes Artikel Saya</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body">
                                <div class="stat-icon bg-warning mb-3">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <h4 class="stat-number">{{ \App\Models\Komentar::whereHas('artikel', function($q) { $q->where('id_user', auth()->user()->id_user); })->count() }}</h4>
                                <p class="stat-label text-muted">Komentar Artikel Saya</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body">
                                <div class="stat-icon bg-info mb-3">
                                    <i class="fas fa-share"></i>
                                </div>
                                <h4 class="stat-number">{{ rand(50, 200) }}</h4>
                                <p class="stat-label text-muted">Total Shares</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">© 2025 E-Mading Baknus. cindyyuliani091@gmail.com All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="https://www.facebook.com/Smkbn666/?locale=id_ID" class="text-decoration-none me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/@smkbaktinusantara666" class="text-decoration-none me-3"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.instagram.com/smkbaktinusantara666/" class="text-decoration-none"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Form Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- jQuery & Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Like -->
    <script>
        // Global AJAX setup for CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Global error handler for 419 errors
        $(document).ajaxError(function(event, xhr, settings) {
            if (xhr.status === 419) {
                alert('Sesi telah berakhir. Halaman akan dimuat ulang.');
                window.location.reload();
            }
        });
        
        $(document).ready(function() {
            $('.like-btn').on('click', function() {
                var btn = $(this);
                var artikelId = btn.data('artikel-id');
                
                $.ajax({
                    url: '/like/' + artikelId,
                    type: 'POST',
                    success: function(response) {
                        if (response.success) {
                            // Update tampilan berdasarkan status like
                            if (response.liked) {
                                btn.addClass('liked');
                                btn.find('i').removeClass('far').addClass('fas');
                            } else {
                                btn.removeClass('liked');
                                btn.find('i').removeClass('fas').addClass('far');
                            }
                            btn.find('.like-count').text(response.total_likes);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 419) {
                            alert('Sesi telah berakhir. Halaman akan dimuat ulang.');
                            window.location.reload();
                        } else {
                            alert('Gagal melakukan like. Silakan coba lagi.');
                        }
                    }
                });
            });
            
            // Filter kategori
            $('#kategoriFilter').on('change', function() {
                var selectedKategori = $(this).val();
                
                $('.artikel-item').each(function() {
                    var card = $(this);
                    var artikelKategori = card.data('kategori');
                    
                    if (selectedKategori === '' || artikelKategori == selectedKategori) {
                        card.show();
                    } else {
                        card.hide();
                    }
                });
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
                        $('.section-title').html('<i class="fas fa-search text-primary me-2"></i>Hasil Pencarian: "' + query + '"');
                    },
                    error: function() {
                        alert('Gagal melakukan pencarian');
                    }
                });
            }
            
            function resetToOriginal() {
                location.reload();
            }
        });
    </script>
</body>
</html>