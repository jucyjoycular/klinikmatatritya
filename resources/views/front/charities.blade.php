@extends('layouts.app')

@section('title', 'Klinik Mata Tritya - Berita')

@section('styles')
    <!-- [BARU] 1. Swiper CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
        .article-hero {
            position: relative;
            height: 420px;
            border-radius: 0;
            overflow: visible;
            margin-bottom: 160px;
            background: #000;
        }

        .article-hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            filter: blur(4px);
            transform: scale(1.1);
            opacity: 0.6;
        }

        .article-hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
        }

        .article-hero-title {
            position: relative;
            z-index: 3;
            padding: 130px 80px 0 80px;
            color: #fff;
            font-size: 2.2rem;
            font-weight: bold;
        }

        .article-hero-image {
            position: relative;
            z-index: 4;
            width: 90%;
            height: 90%;
            margin: 50px auto 0 auto;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
        }

        .article-hero-image img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            background: #fff;
        }

        .article-card {
            position: relative;
            z-index: 5;
            margin-top: -60px;
            background: #fff;
            border-radius: 16px;
            padding: 40px;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        /* Search & Hero Styles (Sama seperti sebelumnya) */
        .search-container {
            position: relative;
        }

        .search-input {
            border-radius: 5px;
            border: 1px solid #e5e7eb;
            padding-right: 40px;
        }

        .search-icon-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            background: none;
            border: none;
        }

        .hero-news-container {
            margin-top: 20px;
            margin-bottom: 60px;
        }

        .hero-card {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            height: 450px;
            width: 100%;
        }

        .hero-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .hero-card:hover img {
            transform: scale(1.05);
        }

        .hero-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;

            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            z-index: 1;
        }

        .hero-content {
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 30px;
            z-index: 2;
            color: white;
            width: 100%;
        }

        .date-badge {
            font-size: 0.8rem;
            opacity: 0.8;
            margin-bottom: 10px;
            display: block;
        }

        .btn-hero {
            background-color: var(--light-blue-bg);
            color: var(--primary-navy);
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-top: 15px;
            transition: all 0.3s;
        }

        .btn-hero:hover {
            background-color: white;
            color: var(--primary-navy);
        }

        .side-news-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            text-decoration: none;
            color: inherit;
        }

        .side-news-item:hover .side-news-title {
            color: var(--accent-blue);
        }

        .side-news-img {
            width: 120px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .side-news-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .side-news-date {
            font-size: 0.75rem;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .side-news-title {
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1.4;
            transition: color 0.2s;
        }

        /* --- Latest Posts (Modified for Swiper) --- */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .nav-arrows .btn-arrow {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 1px solid #eee;
            color: var(--primary-navy);
            margin-left: 10px;
            transition: all 0.2s;
            /* Penting untuk navigasi Swiper */
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .nav-arrows .btn-arrow:hover {
            background: var(--light-blue-bg);
            border-color: var(--light-blue-bg);
        }

        .nav-arrows .btn-arrow.swiper-button-disabled {
            opacity: 0.5;
            cursor: default;
        }

        .news-card {
            background: white;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            transition: transform 0.3s;
            /* Pastikan tinggi konsisten di dalam slider */
            height: 420px;
        }

        .news-card:hover {
            transform: translateY(-5px);
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

        .btn-full-width:hover {
            background-color: #bfdbfe;
        }

        /* Social Feed Styles (Sama) */
        .social-section {
            padding: 60px 0 100px 0;
        }

        .social-header-link {
            color: var(--primary-navy);
            text-decoration: none;
            font-weight: 500;
        }

        .social-card {
            background: white;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .social-img-wrapper {
            position: relative;
            padding-top: 100%;
            overflow: hidden;
        }

        .social-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .badge-type {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(255, 255, 255, 0.9);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.7rem;
            font-weight: 700;
            color: #c02626;
        }

        .social-body {
            padding: 15px;
            font-size: 0.9rem;
            color: #4b5563;
            line-height: 1.5;
        }

        @media (max-width: 992px) {
            .hero-card {
                height: 350px;
                margin-bottom: 30px;
            }
        }
    </style>
@endsection

@section('content')

    <div class="article-hero">

        <!-- Background Blur -->
        <div class="article-hero-bg" style="background-image: url('{{ asset('img/background.jpg') }}');">
        </div>

        <!-- Title -->
        <div class="article-hero-title">
            {{ $section->title }}
        </div>

        <!-- Foreground Image (gambar jabatan tangan) -->
        <div class="article-hero-image">
            <img src="{{ asset('img/' . $section->image) }}" alt="{{ $section->title }}">
        </div>






    </div>
    <br><br><br><br>
    <div class="article-card">
        <p>{!! $section->content !!}</p>
    </div>


    <div class="container pt-4">

        <!-- [BARU] 2. Modifikasi Struktur HTML Slider -->
        <div class="position-relative mb-5">
            <div class="section-header">
                <h2 class="fw-bold">Postingan Terbaru</h2>
                <!-- Navigasi Custom (diberi class unik untuk selector JS) -->
                <div class="nav-arrows">
                    <button class="btn-arrow news-prev"><i class="fas fa-chevron-left"></i></button>
                    <button class="btn-arrow news-next"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>

            <!-- Swiper Container -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @forelse($recent_articles as $recent)
                        <div class="swiper-slide">
                            <div class="news-card">
                                <img src="{{ $recent->image ? asset('storage/' . $recent->image) : 'https://via.placeholder.com/600x400' }}"
                                    class="news-card-img" alt="{{ $recent->title }}">
                                <div class="news-card-body">
                                    <span class="news-card-date">{{ $recent->created_at->format('d F Y') }}</span>
                                    <h5 class="news-card-title">{{ Str::limit($recent->title, 40) }}</h5>
                                    <a href="{{ route('fe.news.detail', $recent->slug) }}" class="btn-full-width">
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
                <!-- Pagination dots (Optional, disembunyikan jika tidak perlu) -->
                <!-- <div class="swiper-pagination"></div> -->
            </div>
        </div>

        <!-- Social Feed Section -->
        <div class="social-section">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

                <h2 class="fw-bold mb-0">@klinikmatatritya.official</h2>
                <a href="https://www.instagram.com/klinikmatatritya.official/" target="_blank"
                    class="social-header-link">Selengkapnya</a>
            </div>
            <div class="swiper instagramSwiper">
                <div class="swiper-wrapper" id="insta-feed-container">
                    <div class="swiper-slide">
                        <div class="py-5 text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- [BARU] 3. Script Swiper JS & Inisialisasi -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            // Tampilan per slide
            slidesPerView: 1,
            spaceBetween: 24, // Jarak antar card (sama dengan gap-4 bootstrap)

            // Loop agar tidak berhenti
            loop: true,

            // Autoplay (Otomatis jalan)
            autoplay: {
                delay: 3000, // 3 detik
                disableOnInteraction: false, // Tetap jalan setelah diklik
            },

            // Tombol Navigasi Custom
            navigation: {
                nextEl: ".news-next",
                prevEl: ".news-prev",
            },

            // Responsif
            breakpoints: {
                640: {
                    slidesPerView: 1, // HP: 1 slide
                },
                768: {
                    slidesPerView: 2, // Tablet: 2 slide
                },
                1024: {
                    slidesPerView: 4, // Desktop: 4 slide
                },
            },
        });
    </script>
@endsection
