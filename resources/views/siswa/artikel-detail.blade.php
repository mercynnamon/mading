<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artikel->judul }} - E-Mading Baknus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: #1a5276;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .article-header {
            padding: 20px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .article-image {
            max-height: 400px;
            object-fit: cover;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
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
        .comment-box {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }
        .comment-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        .btn-send {
            background-color: #1a5276;
            color: white;
            border: none;
        }
        .btn-send:hover {
            background-color: #154360;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-newspaper me-2"></i>e-Mading Skolal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('siswa.dashboard') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Artikel Saya</a></li>
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
        <div class="row">
            <div class="col-md-8">
                <!-- Artikel Utama -->
                <div class="article-header">
                    <h1 class="mb-3">{{ $artikel->judul }}</h1>
                    <p class="text-muted mb-3">
                        Oleh: <strong>{{ $artikel->penulis->nama ?? 'Admin' }}</strong> | 
                        {{ $artikel->created_at->format('d M Y H:i') }}
                    </p>
                </div>

                @if ($artikel->foto)
                    <img src="{{ asset('storage/' . $artikel->foto) }}" class="article-image" alt="{{ $artikel->judul }}">
                @endif

                <div class="mt-4">
                    {!! nl2br(e($artikel->isi)) !!}
                </div>

                <!-- Like Section -->
                <div class="mt-4 d-flex align-items-center">
                    <span class="like-btn {{ $isLiked ? 'liked' : '' }}"
                          data-artikel-id="{{ $artikel->id_artikel }}">
                        <i class="far fa-heart"></i> <span class="like-count">{{ $artikel->totalLikes() }}</span>
                    </span>
                </div>

                <!-- Komentar Section -->
                <div class="mt-5">
                    <h5>Komentar ({{ $artikel->totalKomentar() }})</h5>
                    
                    <!-- Form Komentar -->
                    <form method="POST" action="{{ route('artikel.komentar.store', $artikel->id_artikel) }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="isi" class="form-control" placeholder="Tulis komentar Anda..." required>
                            <button class="btn btn-send" type="submit">Kirim</button>
                        </div>
                    </form>

                    <!-- Daftar Komentar -->
                    <div class="comment-box">
                        @if ($artikel->komentar->isEmpty())
                            <p class="text-muted text-center">Belum ada komentar. Jadilah yang pertama!</p>
                        @else
                            @foreach ($artikel->komentar as $komentar)
                                <div class="comment-item">
                                    <div class="d-flex">
                                        <img src="https://via.placeholder.com/40?text={{ substr($komentar->user->nama, 0, 1) }}" 
                                             class="avatar" alt="{{ $komentar->user->nama }}">
                                        <div>
                                            <strong>{{ $komentar->user->nama }}</strong>
                                            <small class="text-muted d-block">{{ $komentar->created_at->diffForHumans() }}</small>
                                            <p class="mb-0">{{ $komentar->isi }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar - Artikel Terkait -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Artikel Terkait</h6>
                        @foreach (Artikel::where('id_kategori', $artikel->id_kategori)
                                    ->where('id_artikel', '!=', $artikel->id_artikel)
                                    ->take(3)
                                    ->get() as $related)
                            <div class="d-flex mb-3">
                                <img src="{{ $related->foto ? asset('storage/' . $related->foto) : 'https://via.placeholder.com/60x60?text=No+Img' }}" 
                                     class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                <div>
                                    <h6 class="card-title mb-1">{{ Str::limit($related->judul, 25) }}</h6>
                                    <p class="card-text text-muted small mb-0">Oleh: {{ $related->penulis->nama ?? 'Admin' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- jQuery & Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Like -->
    <script>
        $(document).ready(function() {
            $('.like-btn').on('click', function() {
                var btn = $(this);
                var artikelId = btn.data('artikel-id');
                
                $.ajax({
                    url: '{{ route("siswa.like", ["id" => ":id"]) }}'.replace(':id', artikelId),
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update tampilan
                            btn.toggleClass('liked');
                            btn.find('.far').toggleClass('fas');
                            btn.find('.like-count').text(response.total_likes);
                            
                            // Tampilkan notifikasi
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Gagal melakukan like. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>
</body>
</html>