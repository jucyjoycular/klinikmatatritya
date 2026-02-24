@php
    $instagramSetting = \App\Models\InstagramSetting::first();
    $reviewSetting = \App\Models\ReviewSetting::first();

    $websiteFont = \App\Models\Settings::where('key', 'website_font')->value('value') ?? 'Poppins';
    $googleFonts = config('fonts.google');
    $isGoogleFont = in_array($websiteFont, $googleFonts);
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Klinik Mata Tritya')</title>

    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('img/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    @if ($isGoogleFont)
        <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $websiteFont) }}:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    @endif

    <!-- Preload Images -->
    <link rel="preload" as="image" href="{{ asset('img/bg-footer.webp') }}" type="image/webp">

    <style>
        :root {
            /* --primary-navy: #1D2088; */
            --primary-navy: #19225f;
            --accent-blue: #3b82f6;
            --light-blue-bg: #dbeafe;
            --light-bg: #f8fafc;
            --text-dark: #1f2937;
            --accent-pink: #ec4899;
            --accent-pink-hover: #db2777;
            --card-blue-bg: #2e3b8f;
            --text-gray-1: #6d7179;
            --tritya-navy: #19225f;
            --tritya-blue: #2d4cc8;
        }

        body {
            font-family: '{{ $websiteFont }}', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
        }

        a {
            text-decoration: none;
            color: inherit;
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

        /* --- Navbar --- */
        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
        }

        .nav-link {
            color: #333;
            font-weight: 500;
            margin-right: 15px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-navy);
            font-weight: 600;
        }

        .btn-janji {
            background-color: var(--light-blue-bg);
            color: #2563eb;
            font-weight: 600;
            border: none;
        }

        /* --- Footer (Reused) --- */
        .footer-wrapper {
            /* background-color transparent */
            background-color: transparent;
            position: relative;
            margin-top: -280px;
        }

        /* jika mode tablet margin top 590 */
        @media (max-width: 1024px) {
            .footer-wrapper {
                margin-top: -590px;
            }
        }

        .map-card {
            background-color: var(--primary-navy);
            color: white;
            border-radius: 0 15px 15px 0;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .map-iframe {
            border: 0;
            border-radius: 15px 0 0 15px;
            min-height: 350px;
        }

        @media (max-width: 990px) {
            .map-card {
                border-radius: 0 0 15px 15px;
            }

            .map-iframe {
                border-radius: 15px 15px 0 0;
            }
        }


        .main-footer {
            background-color: var(--primary-navy);
            color: white;
            padding-top: 140px;
            padding-bottom: 30px;
            margin-top: -80px;
            background-image: url('{{ asset('img/bg-footer.webp') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-blend-mode: multiply;
        }


        .overlay-ornament {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/img/ornament.png');
            background-size: contain;
            background-repeat: repeat;
            background-position: center;
            opacity: 0.8;
            pointer-events: none;
            z-index: 0;
        }



        .footer-link {
            color: #d1d5db;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }


        .footer-link:hover {
            color: white;
        }

        /* Floating Whatsapp */
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .whatsapp-float:hover {
            background-color: #128c7e;
            color: white;
        }

        .text-muted {
            color: var(--text-gray-1) !important;
        }
    </style>

    <!-- Google Fonts (Poppins) -->
    @if ($isGoogleFont)
        <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $websiteFont) }}:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">
    @endif

        <!-- Preload Images -->
    <link rel="preload" as="image" href="{{ asset('img/bg-landing-pattern.webp') }}" type="image/webp">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">

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
            font-family: '{{ $websiteFont }}', sans-serif;
            color: var(--text-dark);
            background-color: #fff;
            overflow-x: hidden;
            background-image: url("{{ asset('img/bg-landing-pattern.webp') }}");
            /* image position: center top */
            background-position: center top;
            /* background-repeat: no-repeat; */

            /* background: linear-gradient(180deg, #C4E2FF 0%, #87A7DF 50%, #2C50B0 100%); */
        }

        /* --- 1. HERO SECTION (REVISI TOTAL) --- */
        @php $hero =\App\Models\Hero::where('is_active', 1)->first();
        @endphp

        .hero-section {
            position: relative;
            height: 650px;
            /* Gambar Background Wanita dengan Phoropter */
            background-image: url("{{ asset('storage/' . $hero->background) }}");
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
            text-decoration: none;
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

    <style>
        .insta-card {
            display: block;
            text-decoration: none;
            color: inherit;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .insta-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            color: inherit;
        }

        .insta-media-wrapper {
            position: relative;
            padding-top: 100%;
            /* 1:1 Aspect Ratio */
            background-color: #f8f9fa;
        }

        .insta-media-wrapper img,
        .insta-media-wrapper video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .insta-card-body {
            padding: 15px;
        }

        .insta-caption {
            font-size: 0.9rem;
            color: #555;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5;
            margin-bottom: 0;
        }

        .insta-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            color: white;
            font-size: 1.2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            z-index: 2;
        }
    </style>
    @yield('styles')
</head>

<body>

    @include('components.navbar')

    @yield('content')

    @include('components.footer')

    <!-- Floating Whatsapp -->
    <a href="https://wa.me/6282112110048" class="whatsapp-float" target="_blank"><i class="fab fa-whatsapp"></i></a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Adjust padding-bottom of the element before footer-wrapper to accommodate the negative margin footer
        document.addEventListener('DOMContentLoaded', function() {
            var footerWrapper = document.querySelector('.footer-wrapper');
            var target = footerWrapper ? footerWrapper.previousElementSibling : null;

            function adjustPadding() {
                if (!target) return;
                if (window.innerWidth <= 1024) {
                    target.style.paddingBottom = '650px';
                } else {
                    target.style.paddingBottom = '350px';
                }
            }

            // Run on load and resize
            adjustPadding();
            window.addEventListener('resize', adjustPadding);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('insta-feed-container');
            const apiUrl =
                "https://widget-data.service.elfsight.com/api/posts?sources[]=%7B%22pid%22%3A%22d29c8da0-df70-4b1e-9561-4ee1157bd84d%22%2C%22filters%22%3A%5B%5D%7D&sort={{ $instagramSetting?->sort ?? 'date'}}&limit={{ $instagramSetting?->limit ?? 8 }}&offset=0";

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    container.innerHTML = ''; // Clear loading spinner

                    if (data.code === 200 && data.payload && data.payload.length > 0) {
                        data.payload.forEach(post => {
                            // Extract Media (Prioritize thumbnail for videos)
                            let mediaUrl = '';
                            let isVideo = false;

                            if (post.media && post.media.length > 0) {
                                const mediaItem = post.media[0];
                                if (mediaItem.type === 'video' || mediaItem.type === 'reel') {
                                    isVideo = true;
                                    mediaUrl = mediaItem.cover?.thumbnail?.url || mediaItem.url;
                                } else {
                                    mediaUrl = mediaItem.thumbnail.url;
                                }
                            }

                            // Truncate Caption
                            const caption = post.caption ? post.caption : '';

                            // Build HTML
                            const slide = document.createElement('div');
                            slide.className = 'swiper-slide h-auto'; // h-auto for equal height cards
                            slide.innerHTML = `
                                <a href="${post.link}" target="_blank" class="insta-card h-100">
                                    <div class="insta-media-wrapper">
                                        <img src="https://phosphor.utils.elfsightcdn.com/?url=${mediaUrl}" alt="Instagram Post" loading="lazy">
                                        ${isVideo ? '<i class="fas fa-play insta-icon"></i>' : ''}
                                    </div>
                                    <div class="insta-card-body">
                                        <p class="insta-caption">${caption}</p>
                                    </div>
                                </a>
                            `;
                            container.appendChild(slide);
                        });

                        // Initialize Swiper after content is loaded
                        initInstagramSwiper();

                    } else {
                        container.innerHTML =
                            '<div class="col-12 text-center text-muted">Gagal memuat feed instagram.</div>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching Instagram feed:', error);
                    container.innerHTML =
                        '<div class="col-12 text-center text-muted">Belum ada feed terbaru.</div>';
                });
        });

        function initInstagramSwiper() {
            new Swiper('.instagramSwiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                observer: true,
                observeParents: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 25,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    }
                }
            });
        }
    </script>


    <script src="https://elfsightcdn.com/platform.js" async></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.js">
    </script>

    <script>
        const specSwiper = new Swiper('.specSwiper', {
            slidesPerView: 'auto',
            spaceBetween: 20,
            loop: true,
            observer: true,
            observeParents: true,
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
            setTimeout(() => {
                const activeSlide = swiper.slides[swiper.activeIndex];
                const card = activeSlide.querySelector('.specialist-card');
                card.classList.add('active');
                swiper.update();
                swiper.slideTo(swiper.activeIndex, 0);
            }, 300);
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
        var swiper = new Swiper(".promoSwiper", {
            slidesPerView: 1.2,
            spaceBetween: 20,
            loop: true,
            grabCursor: true,
            navigation: {
                nextEl: '.promo-next',
                prevEl: '.promo-prev',
            },

            breakpoints: {
                768: {
                    slidesPerView: 2.2
                },
                992: {
                    slidesPerView: 3
                }
            }
        });

        const splide = new Splide('.asuransiSwiper', {
            type: 'loop',
            drag: 'free',
            focus: 'center',
            pagination: false,
            perPage: 4,
            autoScroll: {
                speed: 1,
            },
            breakpoints: {
                640: {
                    perPage: 2,
                },
            }
        });

        splide.mount(window.splide.Extensions);

        // Init Swiper Testimoni (Menampilkan 4 Card)
        const testimonialSwiper = new Swiper('.testimonialSwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const topicItems = document.querySelectorAll('.faq-topic-item');
            const contentSections = document.querySelectorAll('.faq-content-section');

            topicItems.forEach(item => {
                item.addEventListener('click', function() {

                    topicItems.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const topic = this.getAttribute('data-topic');

                    // hide all sections
                    contentSections.forEach(section => {
                        section.classList.remove('active');
                    });

                    // 🔥 FIX ID
                    const targetSection = document.getElementById('faq-' + topic);
                    if (!targetSection) return;

                    targetSection.classList.add('active');

                    // close open accordions
                    const openAccordions = targetSection.querySelectorAll('.collapse.show');
                    openAccordions.forEach(accordion => {
                        const bsCollapse = new bootstrap.Collapse(accordion, {
                            toggle: false
                        });
                        bsCollapse.hide();
                    });
                });
            });

            // Accordion toggle
            const accordionButtons = document.querySelectorAll('.faq-accordion-button');
            accordionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const target = this.getAttribute('data-bs-target');
                    const collapseElement = document.querySelector(target);

                    if (collapseElement) {
                        new bootstrap.Collapse(collapseElement, {
                            toggle: true
                        });
                    }

                    this.classList.toggle('collapsed');
                });
            });
        });
    </script>

    <script>
        let googleReviews = [];

        const getGoogleReviews = async () => {
            try {
                const response = await fetch(
                    `https://service-reviews-ultimate.elfsight.com/data/reviews?uris%5B%5D=ChIJm1WZ_6z71y0RkrGZmLPTBZM&filter_content=text_required&min_rating={{ $reviewSetting?->min_rating ?? 0 }}&page_length={{ $reviewSetting?->limit ?? 10 }}&order={{ $reviewSetting?->sort_order ?? 'newest' }}&order_seed=1767543630397`, {
                        "headers": {
                            "accept": "application/json",
                        },
                    });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                googleReviews = data.result.data;
            } catch (error) {
                console.error("Gagal mengambil data:", error);
            }

            const testimonialSwiper = document.getElementById('testimonial-swiper');
            testimonialSwiper.innerHTML = googleReviews.map(review => {
                return `
                    <div class="swiper-slide">
                        <div class="testi-bubble d-flex flex-column justify-content-center text-center">
                            <p class="mb-3">${review.text}</p>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <div class="testimonial-info">
                            <div class="testi-user">
                                <img src="${review.reviewer_picture_url}"  class="testi-avatar me-3" alt="User">
                                <div class="testi-info">
                                    <h6>${review.reviewer_name}</h6>
                                    <small>${review.supplier} review</small>
                                </div>
                            </div> 
                        </div>
                    </div>
                `;
            }).join('');
        }

        getGoogleReviews();
    </script>


    @yield('scripts')


</body>

</html>
