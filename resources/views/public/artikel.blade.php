<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artikel->judul }} - E-Mading Baknus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card { border: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 15px; }
        .artikel-content { line-height: 1.8; font-size: 1.1rem; }
        .artikel-content img { max-width: 100%; height: auto; border-radius: 10px; margin: 20px 0; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('public.index') }}">
                <i class="fas fa-newspaper me-2"></i>E-Mading Baknus
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('public.index') }}">
                    <i class="fas fa-home me-1"></i>Beranda
                </a>
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
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="row">
            <!-- Artikel Content -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('public.index') }}">Beranda</a></li>
                                @if($artikel->kategori)
                                    <li class="breadcrumb-item"><a href="{{ route('public.kategori', $artikel->kategori->id_kategori) }}">{{ $artikel->kategori->nama_kategori }}</a></li>
                                @endif
                                <li class="breadcrumb-item active">{{ Str::limit($artikel->judul, 30) }}</li>
                            </ol>
                        </nav>

                        <!-- Artikel Header -->
                        <h1 class="mb-3">{{ $artikel->judul }}</h1>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <span class="text-muted">
                                    <i class="fas fa-user me-1"></i>{{ $artikel->penulis->nama ?? 'Admin' }}
                                </span>
                                <span class="text-muted ms-3">
                                    <i class="fas fa-calendar me-1"></i>{{ $artikel->created_at->format('d F Y') }}
                                </span>
                                @if($artikel->kategori)
                                    <span class="badge bg-primary ms-3">{{ $artikel->kategori->nama_kategori }}</span>
                                @endif
                            </div>
                            <div>
                                <span class="text-danger me-2">
                                    <i class="fas fa-heart"></i> {{ $artikel->totalLikes() }}
                                </span>
                                <span class="text-primary">
                                    <i class="fas fa-comment"></i> {{ $artikel->totalKomentars() }}
                                </span>
                            </div>
                        </div>

                        <!-- Artikel Image -->
                        @if($artikel->foto)
                            <img src="{{ asset('storage/' . $artikel->foto) }}" class="img-fluid rounded mb-4" alt="{{ $artikel->judul }}">
                        @endif

                        <!-- Artikel Content -->
                        <div class="artikel-content">
                            {!! nl2br(e($artikel->konten)) !!}
                        </div>

                        <!-- Like & Share Section -->
                        <div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-light rounded">
                            @auth
                                <div>
                                    <form method="POST" action="{{ route('public.like', $artikel->id_artikel) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            @if($artikel->isLikedBy(auth()->user()))
                                                <i class="fas fa-heart"></i>
                                            @else
                                                <i class="far fa-heart"></i>
                                            @endif
                                            {{ $artikel->totalLikes() }} Like
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Ingin berinteraksi?</strong> 
                                    <a href="{{ route('login') }}" class="alert-link">Login</a> untuk memberikan like dan komentar.
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Komentar Section -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-comments me-2"></i>Komentar ({{ $artikel->komentars->count() }})</h5>
                    </div>
                    <div class="card-body">
                        @auth
                            <!-- Form Komentar -->
                            <form method="POST" action="{{ route('public.komentar.store', $artikel->id_artikel) }}" class="mb-4">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="isi" class="form-control" rows="3" placeholder="Tulis komentar Anda..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-paper-plane me-1"></i>Kirim Komentar
                                </button>
                            </form>
                            <hr>
                        @endauth
                        
                        @if($artikel->komentars->count() > 0)
                            @foreach($artikel->komentars as $komentar)
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ $komentar->user->nama }}</h6>
                                        <p class="mb-1">{{ $komentar->isi }}</p>
                                        <small class="text-muted">{{ $komentar->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted text-center">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Artikel Terkait -->
                @if($artikelTerkait->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h6><i class="fas fa-newspaper me-2"></i>Artikel Terkait</h6>
                        </div>
                        <div class="card-body">
                            @foreach($artikelTerkait as $terkait)
                                <div class="d-flex mb-3">
                                    <img src="{{ $terkait->foto ? asset('storage/' . $terkait->foto) : 'https://via.placeholder.com/80x60?text=No+Image' }}" 
                                         class="rounded me-3" style="width: 80px; height: 60px; object-fit: cover;" alt="{{ $terkait->judul }}">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('public.artikel', $terkait->id_artikel) }}" class="text-decoration-none">
                                                {{ Str::limit($terkait->judul, 40) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">{{ $terkait->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
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