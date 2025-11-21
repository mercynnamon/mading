<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kategori->nama_kategori }} - E-Mading Baknus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }
        .navbar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card { 
            border: none; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            border-radius: 15px;
            transition: transform 0.3s ease;
        }
        .card:hover { transform: translateY(-5px); }
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
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('public.index') }}">Beranda</a></li>
                <li class="breadcrumb-item active">{{ $kategori->nama_kategori }}</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="d-flex align-items-center mb-4">
            <i class="fas fa-tag fa-2x text-primary me-3"></i>
            <div>
                <h2 class="mb-0">{{ $kategori->nama_kategori }}</h2>
                <p class="text-muted mb-0">{{ $artikel->total() }} artikel ditemukan</p>
            </div>
        </div>

        <!-- Artikel Grid -->
        @if($artikel->count() > 0)
            <div class="row">
                @foreach($artikel as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ $item->foto ? asset('storage/' . $item->foto) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                                 class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ Str::limit($item->judul, 50) }}</h5>
                                <p class="card-text text-muted flex-grow-1">{{ Str::limit(strip_tags($item->konten), 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>{{ $item->penulis->nama ?? 'Admin' }}
                                    </small>
                                    <div>
                                        <span class="text-danger me-2">
                                            <i class="fas fa-heart"></i> {{ $item->likes_count }}
                                        </span>
                                        <span class="text-primary">
                                            <i class="fas fa-comment"></i> {{ $item->komentars_count }}
                                        </span>
                                    </div>
                                </div>
                                <small class="text-muted mb-3">{{ $item->created_at->diffForHumans() }}</small>
                                <a href="{{ route('public.artikel', $item->id_artikel) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $artikel->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada artikel</h4>
                <p class="text-muted">Kategori ini belum memiliki artikel yang dipublikasikan.</p>
                <a href="{{ route('public.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Beranda
                </a>
            </div>
        @endif
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