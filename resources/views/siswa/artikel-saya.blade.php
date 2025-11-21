<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel Saya - E-Mading Baknus</title>
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
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('siswa.dashboard') }}">
                <i class="fas fa-file-alt me-2"></i>
                <span>Artikel</span>
                <span style="color: #ffd700;">Saya</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('siswa.dashboard') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('siswa.artikel-saya') }}">Artikel Saya</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('artikel.create') }}">Buat Artikel</a></li>
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
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-outline-secondary me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h5 class="section-title mb-0">Artikel Saya</h5>
        </div>
        <div class="row mb-4">
            @forelse($articles as $article)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="{{ $article->foto ? asset('storage/' . $article->foto) : 'https://via.placeholder.com/300x180?text=No+Image' }}" class="card-img-top" alt="{{ $article->judul }}">
                        <div class="card-body">
                            <h6 class="card-title">{{ Str::limit($article->judul, 30) }}</h6>
                            <p class="card-text text-muted small">{{ Str::limit($article->konten, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    @if($article->status == 'pending')
                                        <span class="badge bg-warning">Menunggu Review</span>
                                    @elseif($article->status == 'publish')
                                        <span class="badge bg-success">Dipublikasi</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="d-flex gap-2">
                                @if($article->status == 'publish')
                                    <a href="{{ route('artikel.detail', $article->id_artikel) }}" class="btn btn-primary btn-sm flex-fill">
                                        <i class="fas fa-eye me-1"></i>Lihat
                                    </a>
                                @endif
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteArtikel({{ $article->id_artikel }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada artikel yang dibuat</h5>
                        <p class="text-muted">Mulai menulis artikel pertama Anda!</p>

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
    <!-- jQuery & Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function deleteArtikel(id) {
            if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
                fetch(`/artikel/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Gagal menghapus artikel');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan');
                });
            }
        }
    </script>
</body>
</html>