<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artikel->judul }} - E-Mading Baknus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        .btn-outline-light {
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }
        .btn-outline-light:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.5);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        .article-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-top: 20px;
        }
        .article-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .article-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            line-height: 1.3;
        }
        .article-meta {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            opacity: 0.9;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
        }
        .article-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .article-content {
            padding: 30px;
            font-size: 1rem;
            line-height: 1.7;
            color: #444;
            text-align: justify;
        }
        .article-stats {
            background: #f8f9fa;
            padding: 20px 30px;
            border-top: 1px solid #e9ecef;
        }
        .stat-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-right: 12px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        .stat-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .like-btn {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .like-btn.liked {
            color: #e74c3c !important;
        }
        .comment-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            margin-top: 25px;
            overflow: hidden;
        }
        .comment-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 25px;
        }
        .comment-form {
            padding: 25px;
            background: #f8f9fa;
        }
        .comment-list {
            padding: 25px;
        }
        .comment-item {
            background: #fafafa;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
            transition: all 0.3s ease;
        }
        .comment-item:hover {
            background: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 20px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 15px rgba(102, 126, 234, 0.3);
        }
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.15rem rgba(102, 126, 234, 0.2);
        }
        @media (max-width: 768px) {
            .article-title {
                font-size: 1.5rem;
            }
            .article-content {
                padding: 20px;
                font-size: 0.95rem;
            }
            .article-stats {
                padding: 15px 20px;
            }
            .meta-item {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="@if(Auth::user()->role == 'admin'){{ route('admin.dashboard') }}@elseif(Auth::user()->role == 'guru'){{ route('guru.dashboard') }}@else{{ route('siswa.dashboard') }}@endif">
                <i class="fas fa-book-open me-2"></i>
                <span>E-Mading</span>
                <span style="color: #ffd700;">Baknus</span>
            </a>
            <div class="ms-auto">
                <a href="{{ $backUrl ?? (Auth::user()->role == 'admin' ? route('admin.dashboard') : (Auth::user()->role == 'guru' ? route('guru.dashboard') : route('siswa.dashboard'))) }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article class="article-container">
                    <div class="article-header">
                        <h1 class="article-title">{{ $artikel->judul }}</h1>
                        <div class="article-meta">
                            <div class="meta-item">
                                <i class="fas fa-user"></i>
                                <span>{{ $artikel->penulis->nama ?? 'Admin' }}</span>
                            </div>
                            @if($artikel->kategori)
                            <div class="meta-item">
                                <i class="fas fa-tag"></i>
                                <span>{{ $artikel->kategori->nama_kategori }}</span>
                            </div>
                            @endif
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $artikel->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ $artikel->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    
                    @if($artikel->foto)
                        <img src="{{ asset('storage/' . $artikel->foto) }}" class="article-image" alt="{{ $artikel->judul }}">
                    @endif
                    
                    <div class="article-content">
                        {!! nl2br(e($artikel->konten)) !!}
                    </div>
                    
                    <div class="article-stats">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex flex-wrap">
                                <span class="stat-item like-btn {{ $artikel->isLikedBy(Auth::user()->id_user ?? 0) ? 'liked' : '' }}" 
                                      data-artikel-id="{{ $artikel->id_artikel }}" style="cursor: pointer;">
                                    <i class="fas fa-heart text-danger"></i> 
                                    <span class="like-count">{{ $artikel->totalLikes() }}</span>
                                </span>
                                <span class="stat-item">
                                    <i class="fas fa-comment text-primary"></i> 
                                    {{ $artikel->totalKomentars() }}
                                </span>
                                <span class="stat-item">
                                    <i class="fas fa-eye text-success"></i> 
                                    {{ rand(100, 500) }}
                                </span>
                                <span class="stat-item">
                                    <i class="fas fa-share text-info"></i> 
                                    Share
                                </span>
                            </div>
                            <div class="mt-2 mt-md-0">
                                <button class="btn btn-outline-primary btn-sm" onclick="window.print()">
                                    <i class="fas fa-print me-1"></i>Print
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
                
                <!-- Section Komentar -->
                <div class="comment-section">
                    <div class="comment-header">
                        <h5 class="mb-0"><i class="fas fa-comments me-2"></i>Diskusi & Komentar ({{ $artikel->totalKomentars() }})</h5>
                    </div>
                    
                    <!-- Form Komentar -->
                    @auth
                    <div class="comment-form">
                        <form method="POST" action="{{ route('komentar.store', $artikel->id_artikel) }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Tulis Komentar</label>
                                <textarea name="isi" class="form-control" rows="3" placeholder="Bagikan pendapat Anda..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-paper-plane me-1"></i>Kirim
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="comment-form">
                        <div class="alert alert-info text-center mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Login</a> untuk berkomentar
                        </div>
                    </div>
                    @endauth
                    
                    <!-- Daftar Komentar -->
                    <div class="comment-list">
                        @forelse($artikel->komentars()->with('user')->latest()->get() as $komentar)
                            <div class="comment-item">
                                <div class="d-flex align-items-start">
                                    <div class="comment-avatar me-3">
                                        {{ strtoupper(substr($komentar->user->nama ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="mb-0 fw-bold small">{{ $komentar->user->nama ?? 'User' }}</h6>
                                            <small class="text-muted">
                                                {{ $komentar->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <p class="mb-0 small">{{ $komentar->isi }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-comments fa-2x text-muted mb-2"></i>
                                <h6 class="text-muted small">Belum ada komentar</h6>
                                <p class="text-muted small mb-0">Jadilah yang pertama berkomentar!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('.like-btn').on('click', function() {
                var btn = $(this);
                var artikelId = btn.data('artikel-id');
                
                $.ajax({
                    url: '/like/' + artikelId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            btn.toggleClass('liked');
                            btn.find('.far').toggleClass('fas');
                            btn.find('.like-count').text(response.total_likes);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>