<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel Disukai - Admin E-Mading</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
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
            border-radius: 15px;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-img-top {
            height: 180px;
            object-fit: cover;
        }
        .section-title {
            color: #667eea;
            border-bottom: 2px solid #667eea;
            padding-bottom: 5px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
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
        @keyframes float {
            0% { transform: translateX(-100px); }
            100% { transform: translateX(100px); }
        }
        .hero-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }
        .hero-subtitle {
            opacity: 0.9;
            margin-bottom: 0;
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-heart me-2"></i>
                <span>Artikel</span>
                <span style="color: #ff6b9d;">Disukai</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.users') }}">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.artikel') }}">Artikel</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.artikel-disukai') }}">Artikel Disukai</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->nama }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                        </ul>
                    </li>
                </ul>
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
        
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h4 class="mb-0"><i class="fas fa-heart me-2"></i>Artikel Disukai</h4>
        </div>
        
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="hero-title"><i class="fas fa-heart me-3"></i>Artikel yang Disukai</h1>
                    <p class="hero-subtitle">Kumpulan artikel favorit yang telah Anda sukai</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="hero-stats">
                        <span class="badge bg-light text-dark fs-6 px-3 py-2">
                            <i class="fas fa-heart text-danger me-2"></i>{{ $likedArticles->count() }} Artikel
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            @forelse($likedArticles as $article)
                <div class="col-md-4 mb-3">
                    <div class="card" style="cursor: pointer;" onclick="window.location.href='{{ route('artikel.detail', $article->id_artikel) }}'">
                        <img src="{{ $article->foto ? asset('storage/' . $article->foto) : 'https://via.placeholder.com/300x180?text=No+Image' }}" class="card-img-top" alt="{{ $article->judul }}">
                        <div class="card-body">
                            <h6 class="card-title">{{ Str::limit($article->judul, 30) }}</h6>
                            <p class="card-text text-muted small">Oleh: {{ $article->penulis->nama ?? 'Admin' }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-danger">
                                        <i class="fas fa-heart"></i> {{ $article->totalLikes() }}
                                    </span>
                                    <span class="text-primary ms-2">
                                        <i class="fas fa-comment"></i> {{ $article->totalKomentars() }}
                                    </span>
                                </div>
                                <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="far fa-heart fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada artikel yang disukai</h5>
                        <p class="text-muted">Mulai menyukai artikel yang menarik!</p>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            @endforelse
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>