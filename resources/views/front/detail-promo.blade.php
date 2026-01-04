@extends('layouts.app')

@section('title', 'Detail Promo - Klinik Alan')

@section('styles')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
        /* --- Hero Section --- */
        .promo-detail-hero {
            position: relative;
            background-image: url('https://img.freepik.com/free-photo/beautiful-girl-white-t-shirt-covering-her-face-with-white-cloth_144627-72445.jpg');
            /* Gambar wanita promo */
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: flex-end;
            padding-bottom: 80px;
        }

        /* Overlay Gradient agar teks putih terbaca */
        .promo-hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8));
        }

        .promo-hero-content {
            position: relative;
            z-index: 2;
            color: white;
            padding-bottom: 20px;
        }

        /* --- Layout Content & Sidebar --- */
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
            margin-top: -80px;
            /* Overlap effect */
            position: relative;
            z-index: 10;
        }

        .sidebar-promo-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 100px;
            /* Sticky sidebar */
            margin-top: -80px;
            /* Overlap effect sidebar */
            z-index: 10;
        }

        .promo-sidebar-img {
            width: 100%;
            border-radius: 10px;
            height: 180px;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .price-tag {
            background-color: #eff6ff;
            color: var(--primary-navy);
            font-weight: 700;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .btn-ambil-promo {
            background-color: var(--light-blue-bg);
            color: #2563eb;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            display: block;
            text-align: center;
            text-decoration: none;
        }

        .btn-ambil-promo:hover {
            background-color: #bfdbfe;
            color: #1d4ed8;
        }

        /* Typography Content */
        .promo-content h3 {
            font-weight: 700;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 1.25rem;
        }

        .promo-content ul {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        .promo-content li {
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .table-promo {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .table-promo th,
        .table-promo td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }

        .table-promo th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        /* --- Slider News (Reused) --- */
        .nav-arrows .btn-arrow {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 1px solid #eee;
            color: var(--primary-navy);
            margin-left: 10px;
            transition: all 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .nav-arrows .btn-arrow:hover {
            background: var(--light-blue-bg);
            border-color: var(--light-blue-bg);
        }

        .news-card {
            background: white;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            height: 420px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        }

        .news-card-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .news-card-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .news-card-date {
            font-size: 0.8rem;
            color: #9ca3af;
            margin-bottom: 10px;
        }

        .news-card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            line-height: 1.4;
            flex-grow: 1;
        }

        .btn-full-width {
            background-color: var(--light-blue-bg);
            color: #2563eb;
            width: 100%;
            text-align: left;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: none;
        }
    </style>

@endsection

@section('content')
    <!-- Hero Section -->
    <div class="promo-detail-hero"
        style="background-image: url('{{ $promo->image ? asset('storage/' . $promo->image) : 'https://via.placeholder.com/1200x600' }}');">
        <div class="promo-hero-overlay"></div>
        <div class="promo-hero-content container">
            <h1 class="fw-bold display-5">{{ $promo->title }}</h1>
        </div>
    </div>

    <!-- Main Content & Sidebar -->
    <div class="container pb-5">
        <div class="row">
            <!-- Left: Main Content Detail -->
            <div class="col-lg-8">
                <div class="content-card promo-content">
                    {!! $promo->content !!}
                </div>
            </div>

            <!-- Right: Sidebar Action -->
            <div class="col-lg-4">
                <div class="sidebar-promo-card">
                    <img src="{{ $promo->image ? asset('storage/' . $promo->image) : 'https://via.placeholder.com/600x400' }}"
                        alt="Promo Thumbnail" class="promo-sidebar-img">
                    <h5 class="fw-bold mb-2">{{ $promo->title }}</h5>
                    <span class="price-tag">
                        @if ($promo->price)
                            Rp {{ number_format($promo->price, 0, ',', '.') }}
                        @else
                            Gratis / TBD
                        @endif
                    </span>
                    <a href="https://wa.me/6282112110048?text=Halo%20saya%20ingin%20mendaftar%20paket%20*{{ $promo->title }}*%20seharga%20*{{ $promo->price ? 'Rp ' . number_format($promo->price, 0, ',', '.') : 'Gratis' }}*"
                        class="btn-ambil-promo">Ambil Sekarang <i class="fas fa-chevron-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Postingan Terbaru (Slider) -->
    <div class="container py-5">
        <div class="section-header d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Postingan Terbaru</h2>
            <div class="nav-arrows">
                <button class="btn-arrow news-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="btn-arrow news-next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>

        <!-- Swiper Container -->
        <div class="swiper newsSwiper">
            <div class="swiper-wrapper">
                @forelse($recent_articles as $article)
                    <div class="swiper-slide">
                        <div class="news-card">
                            <img src="{{ $article->image ? asset('storage/' . $article->image) : 'https://via.placeholder.com/600x400' }}"
                                class="news-card-img" alt="{{ $article->title }}">
                            <div class="news-card-body">
                                <span class="news-card-date">{{ $article->created_at->format('d F Y') }}</span>
                                <h5 class="news-card-title">{{ Str::limit($article->title, 40) }}</h5>
                                <a href="{{ route('fe.news.detail', $article->slug) }}" class="btn-full-width">
                                    Baca selengkapnya <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="p-4 text-center">Belum ada postingan terbaru.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        // Swiper for News Slider
        new Swiper('.newsSwiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".news-next",
                prevEl: ".news-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 4
                },
            },
        });
    </script>
@endsection
