<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - E-Mading Baknus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 15px;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ auth()->check() ? (auth()->user()->role == 'admin' ? route('admin.dashboard') : (auth()->user()->role == 'guru' ? route('guru.dashboard') : route('siswa.dashboard'))) : route('public.index') }}">
                <i class="fas fa-search me-2"></i>E-Mading Baknus
            </a>
            <div class="navbar-nav ms-auto">
                @auth
                    <a class="nav-link" href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : (auth()->user()->role == 'guru' ? route('guru.dashboard') : route('siswa.dashboard')) }}">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                @else
                    <a class="nav-link" href="{{ route('public.index') }}">
                        <i class="fas fa-home me-1"></i>Beranda
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="hero-section">
            <h1><i class="fas fa-search me-3"></i>Hasil Pencarian</h1>
            <p class="mb-0">Menampilkan hasil untuk: <strong>"{{ $query }}"</strong></p>
        </div>

        @if($articles->count() > 0)
            <div class="row">
                @foreach($articles as $article)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ $article->foto ? asset('storage/' . $article->foto) : 'https://via.placeholder.com/300x200?text=No+Image' }}" 
                                 class="card-img-top" alt="{{ $article->judul }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ Str::limit($article->judul, 50) }}</h5>
                                <p class="card-text text-muted flex-grow-1">{{ Str::limit(strip_tags($article->konten), 100) }}</p>
                                <div class="mb-3">
                                    @if($article->kategori)
                                        <span class="badge bg-primary">{{ $article->kategori->nama_kategori }}</span>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>{{ $article->penulis->nama ?? 'Admin' }}
                                    </small>
                                    <div>
                                        <span class="text-danger me-2">
                                            <i class="fas fa-heart"></i> {{ $article->likes_count }}
                                        </span>
                                        <span class="text-primary">
                                            <i class="fas fa-comment"></i> {{ $article->komentars_count }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    @auth
                                        <a href="{{ route('artikel.detail', $article->id_artikel) }}" class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-eye me-1"></i>Baca Selengkapnya
                                        </a>
                                    @else
                                        <a href="{{ route('public.artikel', $article->id_artikel) }}" class="btn btn-primary btn-sm w-100">
                                            <i class="fas fa-eye me-1"></i>Baca Selengkapnya
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $articles->appends(['q' => $query])->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-search fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Tidak ada hasil ditemukan</h4>
                <p class="text-muted">Coba gunakan kata kunci yang berbeda</p>
                <a href="{{ auth()->check() ? (auth()->user()->role == 'admin' ? route('admin.dashboard') : (auth()->user()->role == 'guru' ? route('guru.dashboard') : route('siswa.dashboard'))) : route('public.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>