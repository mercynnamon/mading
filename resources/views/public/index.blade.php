<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Mading Baknus - Digital Magazine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .hero-section { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }
        .card { 
            border: none; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            border-radius: 15px;
            transition: transform 0.3s ease;
        }
        .card:hover { transform: translateY(-5px); }
        .kategori-badge { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('public.index') }}">
                <i class="fas fa-newspaper me-2"></i>E-Mading Baknus
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('public.index') }}">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Kategori
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($kategoris as $kat)
                                <li><a class="dropdown-item" href="{{ route('public.kategori', $kat->id_kategori) }}">{{ $kat->nama_kategori }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                <div class="navbar-nav">
                    @auth
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ auth()->user()->nama }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Selamat Datang di E-Mading Baknus</h1>
            <p class="lead mb-4">Platform Digital Magazine SMK Bakti Nusantara 666</p>
            <p class="mb-4">Temukan artikel menarik dari guru dan siswa</p>
        </div>
    </section>

    <!-- Kategori Section -->
    <div class="container mt-5">
        <h4 class="mb-4"><i class="fas fa-tags me-2"></i>Kategori Artikel</h4>
        <div class="row mb-5">
            @foreach($kategoris as $kategori)
                <div class="col-md-3 mb-3">
                    <a href="{{ route('public.kategori', $kategori->id_kategori) }}" class="text-decoration-none">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fas fa-tag fa-2x text-primary mb-3"></i>
                                <h6>{{ $kategori->nama_kategori }}</h6>
                                <small class="text-muted">{{ $kategori->artikel_count }} artikel</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Artikel Terbaru -->
        <h4 class="mb-4"><i class="fas fa-newspaper me-2"></i>Artikel Terbaru</h4>
        <div class="row">
            @foreach($artikelTerbaru as $artikel)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ $artikel->foto ? asset('storage/' . $artikel->foto) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                             class="card-img-top" alt="{{ $artikel->judul }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ Str::limit($artikel->judul, 50) }}</h5>
                            <p class="card-text text-muted flex-grow-1">{{ Str::limit(strip_tags($artikel->konten), 100) }}</p>
                            <div class="mb-3">
                                @if($artikel->kategori)
                                    <span class="badge kategori-badge">{{ $artikel->kategori->nama_kategori }}</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>{{ $artikel->penulis->nama ?? 'Admin' }}
                                </small>
                                <div>
                                    <span class="text-danger me-2">
                                        <i class="fas fa-heart"></i> {{ $artikel->likes_count }}
                                    </span>
                                    <span class="text-primary">
                                        <i class="fas fa-comment"></i> {{ $artikel->komentars_count }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('public.artikel', $artikel->id_artikel) }}" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-eye me-1"></i>Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $artikelTerbaru->links() }}
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2024 E-Mading Baknus. SMK Bakti Nusantara 666</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>