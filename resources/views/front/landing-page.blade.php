@extends('layouts.app')

@section('title', 'Klinik Mata Tritya - Beranda')

@section('styles')
    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --tritya-navy: #19225f;
            /* Warna Biru Gelap Logo */
            --tritya-blue: #2d4cc8;
            --tritya-light-blue: #dbeafe;
            --text-dark: #222;
            --text-grey: #666;
            --section-gap: 80px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            background-color: #fff;
            overflow-x: hidden;
            background-image: url("{{ asset('img/bg-landing-pattern.png') }}");
            /* image position: center top */
            background-position: center top;
            /* background-repeat: no-repeat; */

            /* background: linear-gradient(180deg, #C4E2FF 0%, #87A7DF 50%, #2C50B0 100%); */
        }

        /* --- 1. HERO SECTION (REVISI TOTAL) --- */
        .hero-section {
            position: relative;
            height: 650px;
            /* Gambar Background Wanita dengan Phoropter */
            background-image: url("{{ asset('img/hero-background.jpg') }}");
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
        }

        /* Gradient Overlay: Putih di kiri, Transparan di kanan */
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(360deg, #C4DCF9 0%, rgba(255, 255, 255, 0) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding-top: 50px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            color: #000;
            margin-bottom: 20px;
        }

        .hero-desc {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 40px;
            max-width: 500px;
        }

        .btn-navy {
            background-color: var(--tritya-navy);
            color: white;
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-navy:hover {
            background-color: #2d4cc8;
            color: white;
        }

        /* --- 2. FLOATING SEARCH BOX --- */
        .search-box-wrapper {
            position: relative;
            z-index: 10;
            margin-top: -40px;
            /* Overlap ke atas */
            margin-bottom: var(--section-gap);
        }

        .search-box {
            background: white;
            border-radius: 20px;
            padding: 30px 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        .search-title {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 5px;
            color: #000;
        }

        .form-select-custom {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px 15px;
            background-color: #fff;
            font-size: 0.95rem;
            color: #444;
        }

        .btn-search-blue {
            background-color: #dbeafe;
            color: var(--tritya-blue);
            font-weight: 700;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            width: 100%;
        }

        .bg-sky-blue {
            background-color: #bcd5f4;
        }

        /* --- 3. SPESIALISASI KAMI (KARTU BIRU TINGGI) --- */
        .section-header {
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 20px;
        }

        /* Swiper slide harus fleksibel mengikuti lebar card */
        .specSwiper .swiper-slide {
            width: auto !important;
        }

        /* Kartu Spesialisasi - Default State (Tidak Aktif) */
        .specialist-card {
            background-color: var(--tritya-navy);
            color: white;
            border-radius: 20px;
            /* Tinggi tetap, lebar lebih sempit */
            height: 420px;
            width: 260px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            cursor: pointer;
        }

        .specialist-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }

        /* Active State Card (Lebar untuk deskripsi) */
        .specialist-card.active {
            background-color: white;
            color: #222;
            /* Tinggi tetap sama, tapi lebar lebih besar */
            height: 420px;
            width: 370px !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .spec-icon {
            position: absolute;
            top: 30px;
            left: 30px;
            font-size: 3rem;
            opacity: 1;
            transition: all 0.3s ease;
        }

        .specialist-card.active .spec-icon {
            color: var(--tritya-navy);
        }

        .spec-name {
            font-size: 1.3rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 0;
            transition: all 0.3s ease;
        }

        .spec-desc {
            font-size: 0.88rem;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            line-height: 1.6;
            transition: all 0.4s ease;
            color: #555;
            margin-top: 0;
        }

        /* Show description only on active card */
        .specialist-card.active .spec-desc {
            opacity: 1;
            max-height: 150px;
            margin-top: 12px;
        }

        /* Navigasi Bulat Biru Muda */
        .nav-circle-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #dbeafe;
            color: var(--tritya-navy);
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            font-size: 1.2rem;
            transition: 0.3s;
        }

        .nav-circle-btn:hover {
            background-color: var(--tritya-navy);
            color: white;
        }

        .end-container {
            /* background-color: #dbeafe; */
            /* padding-bottom: 320px; */
        }

        /* jika mode tablet, padding bottom 630px */
        @media (max-width: 1024px) {
            .end-container {
                /* padding-bottom: 630px; */
            }
        }

        .end-wrapper {
            max-width: 1400px;
            margin: 180px auto 0 auto;
            padding: 40px 20px;
            /* background color gradient Y : from blue to sky blue */
            background: linear-gradient(180deg, #93C8FA 0%, #0F2F9B 100%);
            border-radius: 20px;
            /* color: white; */
        }

        /* --- 4. PERALATAN MEDIS --- */

        /* Swiper slide untuk equipment harus fleksibel */
        .equipSwiper .swiper-slide {
            width: auto !important;
        }

        /* Equipment Card - Semua Ukuran Sama */
        .equip-card {
            border: none;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 300px;
            border-radius: 15px;
        }

        .equip-card:hover {
            transform: translateY(-5px);
        }

        .equip-img-wrapper {
            width: 100%;
            height: 300px;
            overflow: hidden;
            border-radius: 15px;
            background: #f5f5f5;
        }

        .equip-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .equip-card:hover .equip-img {
            transform: scale(1.05);
        }

        .equip-body {
            margin-top: 15px;
        }

        .equip-title {
            font-weight: 600;
            font-size: 1.1rem;
            line-height: 1.4;
            margin-bottom: 15px;
            color: #1a1a1a;
        }

        .btn-selengkapnya-navy {
            background-color: var(--tritya-navy);
            color: white;
            border-radius: 25px;
            padding: 10px 30px;
            width: auto;
            display: inline-block;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
            margin-top: auto;
            text-decoration: none;
        }

        .btn-selengkapnya-navy:hover {
            background-color: #1a237e;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 42, 120, 0.3);
        }

        /* --- MID WRAPPER --- */
        .mid-container {
            /* background-image: url('/img/bg-footer.png');
                                                                                                                background-size: cover;
                                                                                                                background-position: center;
                                                                                                                background-repeat: no-repeat;
                                                                                                                background-blend-mode: multiply;
                                                                                                                background-color: rgba(255, 255, 255, 0.5);
                                                                                                                background-blend-mode: overlay; */
            /* background-color: #dbeafe; */
            padding-top: 100px;
        }

        .mid-wrapper {
            margin: auto;
            width: auto;
            max-width: 1400px;
            padding: 20px 70px;
            padding-top: 60px;
            border-radius: 20px;
            /* gradient bg Y */
            background: linear-gradient(180deg, #B8DAFB 0%, #0F2F9B 100%);
        }

        @media (max-width: 768px) {
            .mid-wrapper {
                padding: 20px 30px;
            }
        }

        /* --- 5. PROMO --- */
        .promo-section {
            border-radius: 20px;
            background-color: #edf4fd;
            padding: var(--section-gap) 0;
        }

        .promo-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            height: 100%;
        }

        .promo-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .promo-price-tag {
            background-color: #e0e7ff;
            color: var(--tritya-navy);
            font-weight: 700;
            font-size: 0.85rem;
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 15px;
        }

        .btn-promo {
            background-color: #dbeafe;
            color: var(--tritya-blue);
            width: 100%;
            border-radius: 10px;
            padding: 10px 20px;
            border: none;
            font-weight: 600;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* --- 6. BERITA --- */
        .news-img {
            border-radius: 15px;
            height: 200px;
            width: 100%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .news-date {
            font-size: 0.75rem;
            color: #888;
        }

        /* --- 7. FAQ --- */
        .faq-section {
            padding: var(--section-gap) 0;
        }

        /* FAQ Left Side - Clickable Tabs */
        .faq-topic-item {
            background: rgba(255, 255, 255, 0.6);
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-topic-item:hover {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .faq-topic-item.active {
            background-color: white;
            color: var(--tritya-blue);
            border-color: var(--tritya-blue);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        /* FAQ Right Side - Content Box */
        .faq-right-box {
            background-color: rgba(255, 255, 255, 0.6);
            border-radius: 20px;
            padding: 30px;
            min-height: 400px;
        }

        /* FAQ Accordion Items in Right Side */
        .faq-accordion-item {
            border: none;
            margin-bottom: 15px;
            background: transparent;
        }

        .faq-accordion-button {
            border-radius: 10px !important;
            padding: 15px 20px;
            font-weight: 500;
            color: #444;
            background: rgba(255, 255, 255, 0.7);
            border: none;
            width: 100%;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .faq-accordion-button:hover {
            background-color: rgba(255, 255, 255, 0.9);
        }

        .faq-accordion-button.collapsed .faq-icon {
            transform: rotate(0deg);
        }

        .faq-accordion-button:not(.collapsed) .faq-icon {
            transform: rotate(180deg);
        }

        .faq-icon {
            font-size: 12px;
            transition: transform 0.3s ease;
        }

        .faq-accordion-body {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 0 0 10px 10px;
            padding: 15px 20px;
            margin-top: -5px;
        }

        .faq-content-section {
            display: none;
        }

        .faq-content-section.active {
            display: block;
        }

        .asuransi-section {
            border-radius: 20px;
            /* color:  white; */
            background-color: white;
            margin-top: -220px;
            padding: 60px 0;
            max-width: 1300px;
        }


        /* --- ADS SECTION --- */
        .ads-section {
            margin-top: 70px;
            padding: 40px 0 80px 0;
        }

        .ads-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        .ads-left {
            height: 500px;
        }

        .ads-right-top,
        .ads-right-bottom {
            height: 240px;
        }

        /* --- 8. TESTIMONI (Speech Bubble) --- */
        .testi-section {
            /* background-color: #1e2a78; */
            /* Dark Navy Background */
            padding: var(--section-gap) 0;
            /* position: relative; */
        }

        .testimonialSwiper .swiper-slide {
            height: auto !important;
            display: flex;
            flex-direction: column;
        }

        /* Background Image Overlay (Optional, based on reference) */
        /* .testi-section::before {
                                                                                                                                                                                                                                                                                                                                                                            content: "";
                                                                                                                                                                                                                                                                                                                                                                            position: absolute;
                                                                                                                                                                                                                                                                                                                                                                            top: 0;
                                                                                                                                                                                                                                                                                                                                                                            left: 0;
                                                                                                                                                                                                                                                                                                                                                                            right: 0;
                                                                                                                                                                                                                                                                                                                                                                            bottom: 0;
                                                                                                                                                                                                                                                                                                                                                                            background-image: url('https://img.freepik.com/free-photo/doctor-nurses-special-equipment_23-2148980721.jpg');
                                                                                                                                                                                                                                                                                                                                                                            background-size: cover;
                                                                                                                                                                                                                                                                                                                                                                            background-position: center;
                                                                                                                                                                                                                                                                                                                                                                            opacity: 0.1;
                                                                                                                                                                                                                                                                                                                                                                            pointer-events: none;
                                                                                                                                                                                                                                                                                                                                                                        } */

        .testi-bubble {
            background: white;
            border-radius: 10px;
            padding: 25px;
            position: relative;
            min-height: 150px;
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            /* Space for the arrow */
            color: #333;
            font-size: 0.95rem;
            line-height: 1.6;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* The Triangle Arrow */
        .testi-bubble::after {
            content: '';
            position: absolute;
            bottom: -13px;
            /* Position below the bubble */
            left: 50%;
            /* Adjust horizontal position */
            border-width: 15px 15px 0;
            border-style: solid;
            border-color: white transparent transparent transparent;
        }

        .testi-user {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-left: 10px;
        }

        .testi-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        .testi-info h6 {
            color: white;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .testi-info small {
            color: #ccc;
        }

        /* --- 9. INSTAGRAM --- */
        .insta-section {
            /* background-color: #1e2a78; */
            /* Deep Navy */
            padding: 60px 0;
            color: white;
        }

        .insta-img-wrapper {
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            aspect-ratio: 1/1;
        }

        .insta-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 99999;
        }

        .popup-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 90%;
            max-height: 90%;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .popup-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .popup-close {
            position: absolute;
            top: -15px;
            right: -15px;
            background: #fff;
            color: #333;
            font-size: 35px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            text-align: center;
            line-height: 38px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            font-weight: bold;
        }
    </style>
@endsection

@section('content')

    @if($popup && $popup->image)
    <div id="popupOverlay" class="popup-overlay">
        <div class="popup-box">

            <div class="popup-close" id="closePopup">×</div>

            <img src="{{ asset('storage/'.$popup->image) }}"
                class="popup-image"
                alt="Popup Info">
        </div>
    </div>
    @endif


    <!-- 1. HERO SECTION -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content container">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="hero-title">Lihat Dunia dengan <br>Lebih Jelas</h1>
                    <p class="hero-desc">
                        Kami percaya setiap orang berhak melihat dunia dengan pandangan yang jernih.
                        Tim dokter spesialis mata dan optometris kami siap memberikan perawatan mata terbaik.
                    </p>
                    <a href="#" class="btn-navy">Selengkapnya</a>
                </div>
            </div>
        </div>
    </section>

    <!-- BG SKY BLUE -->
    <div style=" padding-bottom: 80px;">
        <!-- 2. FLOATING SEARCH BOX -->
        <div class="container" style="max-width:1000px;">
            <div class="search-box-wrapper">
                <div class="search-box">
                    <div class="mb-4 text-center">
                        <h4 class="search-title">Biarkan Kami Membantu Anda</h4>
                        <p class="text-muted small">Cukup beritahu kami siapa dan apa kebutuhan anda.</p>
                    </div>

                    <form>
                        <div class="row g-3 align-items-end justify-content-center">
                            <div class="col-md-auto d-flex align-items-center mb-2">
                                <span class="fw-semibold me-2">Saya seorang</span>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-custom">
                                    <option selected>Pasien</option>
                                    <option>Keluarga Pasien</option>
                                </select>
                            </div>
                            <div class="col-md-auto d-flex align-items-center mb-2">
                                <span class="fw-semibold mx-2">sedang mencari</span>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-custom">
                                    <option selected>Dokter</option>
                                    <option>Layanan</option>
                                    <option>Jadwal</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn-search-blue"
                                    onclick="window.location.href='http://tritya.id/DaftarOnline'">Buat Janji</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- 3. SPESIALISASI KAMI -->
        <section style="padding-bottom: 80px; ">
            <div class="container">
                <div class="row align-items-start">
                    <!-- Info Box Kiri (Dinamis berdasarkan kartu aktif) -->
                    <div class="col-lg-5 mb-lg-0 mb-4">
                        <div id="specInfoBox">
                            <h2 class="section-title">Spesialisasi Kami</h2>
                            <p class="text-muted pe-lg-4 mb-4" id="specDefaultDesc">
                                Solusi kesehatan mata terpercaya untuk Anda dan keluarga, dari pemeriksaan rutin hingga
                                penanganan
                                gangguan penglihatan
                            </p>
                        </div>
                        <!-- Navigasi -->
                        <div class="d-flex mt-4 gap-3">
                            <button class="nav-circle-btn spec-prev"><i class="fas fa-chevron-left"></i></button>
                            <button class="nav-circle-btn spec-next"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>

                    <!-- Slider Kanan -->
                    <div class="col-lg-7">
                        <div class="swiper specSwiper" style="padding-bottom: 20px;">
                            <div class="swiper-wrapper">
                                @forelse($services as $service)
                                    <div class="swiper-slide">
                                       
                                        <div class="specialist-card" data-title="{{ $service->title }}"
                                            data-desc="{{ $service->excerpt }}">
                                            <!-- Icon -->
                                            <div class="spec-icon">
                                                @if ($loop->iteration % 4 == 1)
                                                   <i class="far fa-eye"></i>
                                                @elseif($loop->iteration % 4 == 2)
                                                    <i class="fas fa-glasses"></i>
                                                @elseif($loop->iteration % 4 == 3)
                                                    <i class="fas fa-low-vision"></i>
                                                @else
                                                    <i class="fas fa-user-md"></i>
                                                @endif
                                            </div>

                                            <div class="mt-auto">
                                                <h4 class="spec-name">{{ $service->title }}</h4>
                                                <p class="spec-desc">{{ $service->excerpt }}</p>
                                            </div>
                                        </div>
                                       

                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <div class="specialist-card active" data-title="Belum ada layanan"
                                            data-desc="Silakan tambahkan layanan di admin panel.">
                                            <div class="spec-icon"><i class="far fa-eye"></i></div>
                                            <div class="mt-auto">
                                                <h4 class="spec-name">Belum ada layanan</h4>
                                                <p class="spec-desc">Silakan tambahkan layanan di admin panel.</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. PERALATAN MEDIS KAMI -->
        <section style="padding: 80px 0;">
            <div class="container">
                <div class="row align-items-end mb-5">
                    <div class="col-lg-7">
                        <h2 class="section-title mb-0">Peralatan Medis Kami</h2>
                    </div>
                    <div class="col-lg-5 text-lg-end">
                        <p class="text-muted mb-0">
                            Klinik Mata Tritya menggunakan teknologi medis terkini untuk mendukung diagnosis dan perawatan
                            gangguan penglihatan secara akurat dan efisien
                        </p>
                    </div>
                </div>

                <div class="swiper equipSwiper">
                    <div class="swiper-wrapper">
                        <!-- Card 1 -->
                        <div class="swiper-slide">
                            <div class="equip-card">
                                <div class="equip-img-wrapper">
                                    <img src="{{asset('img/statis/ark.png')}}"
                                        class="equip-img" alt="ARK">
                                </div>
                                <div class="equip-body">
                                    <h5 class="equip-title">Auto Refractometer Keratometer (ARK)</h5>
                                    <a href="/ark" class="btn-selengkapnya-navy">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 2 -->
                        <div class="swiper-slide">
                            <div class="equip-card">
                                <div class="equip-img-wrapper">
                                    <img src="{{asset('img/statis/nct.png')}}"
                                        class="equip-img" alt="NCT">
                                </div>
                                <div class="equip-body">
                                    <h5 class="equip-title">Non-Contact Tonometry (NCT)</h5>
                                    <a href="/nct" class="btn-selengkapnya-navy">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="swiper-slide">
                            <div class="equip-card">
                                <div class="equip-img-wrapper">
                                    <img src="{{asset('img/statis/slit-lamp.png')}}"
                                        class="equip-img" alt="Slit Lamp">
                                </div>
                                <div class="equip-body">
                                    <h5 class="equip-title">Slit Lamp</h5>
                                    <a href="/slit-lamp" class="btn-selengkapnya-navy">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                        <!-- Card 4 -->
                        <div class="swiper-slide">
                            <div class="equip-card">
                                <div class="equip-img-wrapper">
                                    <img src="{{asset('img/statis/oct.png')}}"
                                        class="equip-img" alt="OCT">
                                </div>
                                <div class="equip-body">
                                    <h5 class="equip-title">Optical Coherence Tomography (OCT)</h5>
                                    <a href="/oct" class="btn-selengkapnya-navy">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="d-flex justify-content-end mt-4 gap-2">
                       <!--  <button class="nav-circle-btn equip-prev bg-white shadow-sm" style="width:40px;height:40px;"><i
                                class="fas fa-chevron-left"></i></button>
                        <button class="nav-circle-btn equip-next bg-white shadow-sm" style="width:40px;height:40px;"><i
                                class="fas fa-chevron-right"></i></button> -->
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="mid-container">
        <div class="mid-wrapper">
            <!-- 5. PROMO -->
            <section class="promo-section container text-center">
                <div class="">
                    <h2 class="section-title mb-3">Promo</h2>
                    <p class="text-muted mx-auto mb-5" style="max-width: 700px;">
                        Temukan penawaran menarik untuk layanan pemeriksaan, perawatan, dan produk kesehatan mata yang
                        dirancang
                        khusus untuk kebutuhan Anda
                    </p>

                    <div class="row justify-content-center g-4">
                        <div class="row justify-content-center g-4">
                            @forelse($promos as $promo)
                                <div class="col-md-6 col-lg-5">
                                    <div class="promo-card text-start">
                                        <img src="{{ $promo->image ? asset('storage/' . $promo->image) : 'https://via.placeholder.com/600x400' }}"
                                            class="promo-img" alt="{{ $promo->title }}">
                                        <h5 class="fw-bold mb-2">{{ $promo->title }}</h5>
                                        <div class="promo-price-tag">
                                            @if ($promo->price)
                                                Rp {{ number_format($promo->price, 0, ',', '.') }}
                                            @else
                                                Gratis / TBD
                                            @endif
                                        </div>
                                        <a href="{{ route('fe.detail-promo', $promo->slug) }}" class="btn-promo">
                                            Ambil Sekarang <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted">Belum ada promo saat ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            <!-- 6. BERITA -->
            <section style="padding: 80px 0;">
                <div class="container">
                    <div class="row mb-5" style="color:white !important;">
                        <div class="col-md-3">
                            <h2 class="section-title" style="color:white !important;">Berita</h2>
                        </div>
                        <div class="col-md-9">
                            <p class="pt-2">Temukan informasi terbaru seputar kesehatan mata, gangguan
                                penglihatan, dan
                                tips perawatan visual yang relevan dan terpercaya</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        @forelse($articles->take(3) as $article)
                            <div class="col-lg-4">
                                <div class="card h-100 border-0">
                                    <img src="{{ $article->image ? asset('storage/' . $article->image) : 'https://via.placeholder.com/600x400' }}"
                                        class="news-img" alt="{{ $article->title }}">
                                    <div class="card-body">
                                        <span class="news-date">{{ $article->created_at->format('d F Y') }}</span>
                                        <h5 class="fw-bold mb-3 mt-2">{{ Str::limit($article->title, 50) }}</h5>
                                        <a href="{{ route('fe.news.detail', $article->slug) }}" class="btn-promo">
                                            Baca selengkapnya <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <p class="text-muted">Belum ada berita terbaru.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-5 text-center">
                        <button class="btn-navy" onclick="window.location.href='/news'">Selengkapnya</button>
                    </div>
                </div>
            </section>

        </div>
    </div>





    <div class="end-container" style="position: relative;">


        <!-- 7. F.A.Q -->
        <section class="faq-section">
            <div class="container">
                <h2 class="section-title mb-5">F.A.Q</h2>
                <div class="row">
                    <!-- Left Side - Topic Tabs -->
                    <div class="col-lg-5 mb-lg-0 mb-4">
                        <div class="faq-topic-item active" data-topic="layanan">
                            <span>Layanan & Pemeriksaan Mata</span>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="faq-topic-item" data-topic="pembiayaan">
                            <span>Pembiayaan & Asuransi</span>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="faq-topic-item" data-topic="tindakan">
                            <span>Tindakan Medis & Operasi</span>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="faq-topic-item" data-topic="reservasi">
                            <span>Reservasi & Jadwal</span>
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>

                    <!-- Right Side - Dynamic Content -->
                    <div class="col-lg-7">
                        <div class="faq-right-box">
                            <!-- Content for "Layanan & Pemeriksaan Mata" -->
                            <div class="faq-content-section active" id="content-layanan">
                                <h5 class="fw-bold mb-4">Layanan & Pemeriksaan Mata</h5>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#layanan1">
                                        <span>Apa saja jenis pemeriksaan mata yang tersedia di Klinik Mata Tritya?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="layanan1" class="collapse">
                                        <div class="faq-accordion-body">
                                            Kami menyediakan berbagai jenis pemeriksaan mata seperti pemeriksaan refraksi,
                                            tonometri (tekanan bola mata), pemeriksaan retina, dan pemeriksaan komprehensif
                                            untuk mendeteksi berbagai gangguan mata.
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#layanan2">
                                        <span>Apa itu EMC dan siapa yang perlu melakukannya?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="layanan2" class="collapse">
                                        <div class="faq-accordion-body">
                                            EMC (Eye Medical Check-up) adalah pemeriksaan mata menyeluruh yang
                                            direkomendasikan untuk semua usia, terutama bagi yang mengalami gangguan
                                            penglihatan atau memiliki riwayat penyakit mata dalam keluarga.
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#layanan3">
                                        <span>Apakah tersedia layanan pemeriksaan mata untuk anak-anak?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="layanan3" class="collapse">
                                        <div class="faq-accordion-body">
                                            Ya, kami memiliki layanan khusus untuk pemeriksaan mata anak dengan dokter
                                            spesialis mata anak dan peralatan yang ramah anak.
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#layanan4">
                                        <span>Berapa frekuensi ideal untuk melakukan pemeriksaan mata rutin?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="layanan4" class="collapse">
                                        <div class="faq-accordion-body">
                                            Untuk orang dewasa normal, disarankan setiap 1-2 tahun sekali. Namun bagi yang
                                            memiliki gangguan mata atau menggunakan kacamata/lensa kontak, sebaiknya 6 bulan
                                            - 1 tahun sekali.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Content for "Pembiayaan & Asuransi" -->
                            <div class="faq-content-section" id="content-pembiayaan">
                                <h5 class="fw-bold mb-4">Pembiayaan & Asuransi</h5>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#pembiayaan1">
                                        <span>Metode pembayaran apa saja yang diterima?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="pembiayaan1" class="collapse">
                                        <div class="faq-accordion-body">
                                            Kami menerima pembayaran tunai, debit, kartu kredit, dan transfer bank. Tersedia
                                            juga opsi cicilan untuk tindakan tertentu.
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#pembiayaan2">
                                        <span>Asuransi apa saja yang bekerja sama dengan klinik?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="pembiayaan2" class="collapse">
                                        <div class="faq-accordion-body">
                                            Kami bekerja sama dengan BPJS Kesehatan, BRI Life, BNI Life, AdMedika,
                                            Pertamina, BPJS Ketenagakerjaan, dan berbagai asuransi swasta lainnya.
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#pembiayaan3">
                                        <span>Apakah bisa menggunakan BPJS untuk semua layanan?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="pembiayaan3" class="collapse">
                                        <div class="faq-accordion-body">
                                            Ya, BPJS dapat digunakan untuk berbagai layanan pemeriksaan dan tindakan mata
                                            yang termasuk dalam cakupan BPJS. Silakan konfirmasi terlebih dahulu untuk
                                            layanan tertentu.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Content for "Tindakan Medis & Operasi" -->
                            <div class="faq-content-section" id="content-tindakan">
                                <h5 class="fw-bold mb-4">Tindakan Medis & Operasi</h5>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#tindakan1">
                                        <span>Apakah klinik melayani operasi katarak?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="tindakan1" class="collapse">
                                        <div class="faq-accordion-body">
                                            Ya, kami melayani operasi katarak dengan teknologi phacoemulsification modern
                                            dan dokter spesialis mata yang berpengalaman.
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#tindakan2">
                                        <span>Berapa lama waktu pemulihan setelah operasi LASIK?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="tindakan2" class="collapse">
                                        <div class="faq-accordion-body">
                                            Pemulihan LASIK umumnya cepat. Penglihatan mulai membaik dalam 24-48 jam, dan
                                            aktivitas normal dapat dilakukan dalam 1-2 minggu dengan instruksi dokter.
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#tindakan3">
                                        <span>Apakah operasi mata aman untuk lansia?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="tindakan3" class="collapse">
                                        <div class="faq-accordion-body">
                                            Ya, operasi mata seperti katarak sangat aman untuk lansia. Dokter akan melakukan
                                            pemeriksaan menyeluruh terlebih dahulu untuk memastikan kondisi pasien.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Content for "Reservasi & Jadwal" -->
                            <div class="faq-content-section" id="content-reservasi">
                                <h5 class="fw-bold mb-4">Reservasi & Jadwal</h5>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#reservasi1">
                                        <span>Bagaimana cara membuat janji temu?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="reservasi1" class="collapse">
                                        <div class="faq-accordion-body">
                                            Anda dapat membuat janji melalui website kami, telepon, WhatsApp, atau datang
                                            langsung ke klinik. Reservasi online dapat dilakukan 24/7.
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#reservasi2">
                                        <span>Berapa lama waktu tunggu untuk pemeriksaan?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="reservasi2" class="collapse">
                                        <div class="faq-accordion-body">
                                            Dengan sistem reservasi, waktu tunggu minimal. Untuk pasien walk-in, waktu
                                            tunggu tergantung antrian, biasanya 30-60 menit.
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-accordion-item">
                                    <button class="faq-accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#reservasi3">
                                        <span>Apakah bisa reschedule atau membatalkan janji?</span>
                                        <i class="fas fa-chevron-down faq-icon"></i>
                                    </button>
                                    <div id="reservasi3" class="collapse">
                                        <div class="faq-accordion-body">
                                            Ya, Anda dapat melakukan reschedule atau pembatalan maksimal 24 jam sebelum
                                            jadwal janji temu melalui telepon atau WhatsApp.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="end-wrapper">

            <!-- 8. PILIHAN ASURANSI -->
            <section class="asuransi-section container" style="">
                <div class="container text-center">
                    <h3 class="fw-bold mb-5">Pilihan Asuransi</h3>
                    <div class="d-flex justify-content-center align-items-center flex-wrap gap-5">
                        <!-- Ganti dengan logo asuransi sebenarnya jika ada -->
                        <img src="{{ asset('img/pilihan-asuransi/bpjs-kesehatan.png') }}" height="120" alt="BPJS">
                        <img src="{{ asset('img/pilihan-asuransi/bri-life.png') }}" height="120" alt="BRI Life">
                        <img src="{{ asset('img/pilihan-asuransi/bni-life.png') }}" height="120" alt="BNI Life">
                        <img src="{{ asset('img/pilihan-asuransi/admedika.png') }}" height="115" alt="AdMedika">
                        <img src="{{ asset('img/pilihan-asuransi/pertamina.png') }}" height="125" alt="Pertamina">
                        <img src="{{ asset('img/pilihan-asuransi/bpjs-ketenagakerjaan.png') }}" height="120"
                            alt="BPJS TK">
                    </div>
                </div>
            </section>

            <!-- 9. TESTIMONI (4 CARD VISIBLE) -->
            <section class="testi-section">
                    <div class="container">
                        <h2 class="fw-bold mb-5 text-center text-white">
                            Dipercaya Banyak Orang
                        </h2>

                        <div class="swiper testimonialSwiper">
                            <div class="swiper-wrapper">

                                @foreach($testimonials as $t)
                                <div class="swiper-slide">
                                    <div class="testi-bubble">
                                        "{{ $t->content }}"
                                    </div>

                                    <div class="testi-user">
                                        <img src="{{ $t->avatar 
                                            ? asset('storage/'.$t->avatar)
                                            : asset('images/default-avatar.png') }}"
                                            class="testi-avatar me-3" alt="{{ $t->name }}">

                                        <div class="testi-info">
                                            <h6>{{ $t->name }}</h6>
                                            <small>{{ $t->title }}</small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </section>


            <!-- 10. INSTAGRAM FEED -->
            <section class="insta-section">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold">@klinikmatatritya.official</h3>
                    </div>

                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <div class="insta-img-wrapper">
                                <img src="https://img.freepik.com/free-photo/female-doctor-holding-glasses_23-2148847823.jpg"
                                    class="insta-img" alt="Insta">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="insta-img-wrapper">
                                <img src="https://img.freepik.com/free-photo/muslim-doctor-talking-patient_23-2148847863.jpg"
                                    class="insta-img" alt="Insta">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="insta-img-wrapper">
                                <img src="https://img.freepik.com/free-photo/portrait-female-doctor_23-2148847822.jpg"
                                    class="insta-img" alt="Insta">
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="insta-img-wrapper">
                                <img src="https://img.freepik.com/free-photo/woman-looking-phone-car_23-2149026938.jpg"
                                    class="insta-img" alt="Insta">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        

    </div>




@endsection

@section('scripts')
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>


   <script>
        const specSwiper = new Swiper('.specSwiper', {
            slidesPerView: 'auto',   // ⬅️ PENTING
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: '.spec-next',
                prevEl: '.spec-prev',
            },
            on: {
                init(swiper) {
                    updateActiveSpecCard(swiper);
                },
                slideChange(swiper) {
                    updateActiveSpecCard(swiper);
                }
            }
        });

        function updateActiveSpecCard(swiper) {
            document.querySelectorAll('.specialist-card').forEach(card => {
                card.classList.remove('active');
            });

            const activeSlide = swiper.slides[swiper.activeIndex];
            if (activeSlide) {
                const card = activeSlide.querySelector('.specialist-card');
                if (card) card.classList.add('active');
            }
        }
        </script>


    <script>
        // Init Swiper Peralatan
        const equipSwiper = new Swiper('.equipSwiper', {
            slidesPerView: 'auto',
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: '.equip-next',
                prevEl: '.equip-prev',
            },
            breakpoints: {
                640: {
                    spaceBetween: 20
                },
                768: {
                    spaceBetween: 25
                },
                1024: {
                    spaceBetween: 30
                }
            }
        });
    </script>

    <script>
        // Init Swiper Testimoni (Menampilkan 4 Card)
        const testimonialSwiper = new Swiper('.testimonialSwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            breakpoints: {
                640: {
                    slidesPerView: 1
                },
                992: {
                    slidesPerView: 1
                },
                1200: {
                    slidesPerView: 2.5
                }, // Desktop Besar 4 Card
            }
        });
    </script>

    <script>
        window.addEventListener("load", function() {

            document.getElementById("popupOverlay").style.display = "flex";


        });

        document.getElementById("closePopup").onclick = function() {
            document.getElementById("popupOverlay").style.display = "none";
        };

        document.getElementById("popupOverlay").onclick = function(e) {
            if (e.target === this) {
                this.style.display = "none";
            }
        };
    </script>
@endsection
