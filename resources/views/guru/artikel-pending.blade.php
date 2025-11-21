<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Artikel - E-Mading Baknus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
        }
        .section-title {
            color: #1a5276;
            border-bottom: 2px solid #1a5276;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }
        .btn-approve {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
        .btn-reject {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-user-graduate me-2"></i>
                <span>E-Mading</span>
                <span style="color: #ffd700;">Baknus</span>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('guru.dashboard') }}?v={{ time() }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('guru.artikel-saya') }}">Artikel Saya</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('artikel.create') }}">Buat Artikel</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('guru.artikel-pending') }}">Konfirmasi Artikel</a></li>
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
            <a href="{{ route('guru.dashboard') }}" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h5 class="section-title mb-0"><i class="fas fa-clock text-warning me-2"></i>Artikel Menunggu Review</h5>
        </div>
        
        <div class="row">
            @forelse($articles as $artikel)
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6 class="card-title">{{ $artikel->judul }}</h6>
                                    <p class="card-text">{{ Str::limit($artikel->konten, 150) }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>{{ $artikel->penulis->nama ?? 'Unknown' }} |
                                        <i class="fas fa-calendar me-1"></i>{{ $artikel->created_at->format('d M Y H:i') }}
                                    </small>
                                </div>
                                <div class="col-md-4 text-end">
                                    @if($artikel->foto)
                                        <img src="{{ asset('storage/' . $artikel->foto) }}" class="img-thumbnail mb-2" style="width: 120px; height: 80px; object-fit: cover;">
                                    @endif
                                    <div>
                                        <form method="POST" action="{{ route('guru.artikel.approve', $artikel->id_artikel) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-approve btn-sm">
                                                <i class="fas fa-check me-1"></i>Setujui
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('guru.artikel.reject', $artikel->id_artikel) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-reject btn-sm">
                                                <i class="fas fa-times me-1"></i>Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada artikel yang menunggu review</h5>
                        <p class="text-muted">Semua artikel sudah diproses</p>
                        <a href="{{ route('guru.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Form Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>