@extends('layouts.app')

@section('title', 'Klinik Mata Tritya - Layanan')

@section('styles')
    <style>
        /* --- Section Promo --- */
        .promo-section {
            background-color: #eef2ff;
            /* Background biru muda halaman */
            padding: 60px 0;
        }

        .promo-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            background: white;
            transition: transform 0.3s;
        }

        .promo-card:hover {
            transform: translateY(-5px);
        }

        .promo-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .price-badge {
            background-color: #eff6ff;
            color: var(--primary-navy);
            font-weight: 600;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
            margin-top: 10px;
        }

        .btn-promo {
            background-color: #dbeafe;
            color: #2563eb;
            width: 100%;
            border: none;
            padding: 12px;
            font-weight: 600;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 10px;
            margin-top: 15px;
            text-decoration: none;
        }

        .btn-promo:hover {
            background-color: #bfdbfe;
        }

        /* --- Section Layanan (Accordion Custom) --- */
        .services-section {
            padding: 80px 0;
            background-color: #f1f5f9;
        }

        .service-img-container img {
            border-radius: 20px 0 0 20px;
            /* Lengkungan hanya kiri */
            height: 100%;
            min-height: 400px;
            object-fit: cover;
            width: 100%;
            transition: opacity 0.4s ease-in-out;
        }

        /* Style Accordion Bootstrap Custom */
        .accordion-item {
            border: none;
            background-color: transparent;
            border-bottom: 1px solid #e2e8f0;
        }

        .accordion-button {
            background-color: transparent;
            box-shadow: none;
            color: #64748b;
            /* Warna teks tidak aktif */
            font-weight: 600;
            font-size: 1.2rem;
            padding: 20px 0;
        }

        .accordion-button:not(.collapsed) {
            color: var(--primary-navy);
            background-color: transparent;
            box-shadow: none;
        }

        /* Mengganti icon panah default bootstrap dengan panah pink custom */
        .accordion-button::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ec4899'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            transform: rotate(-90deg);
            /* Panah ke samping saat tutup */
            transition: transform 0.3s;
        }

        .accordion-button:not(.collapsed)::after {
            transform: rotate(0deg);
            /* Panah ke bawah saat buka (atau bisa diset hidden jika desain meminta) */
            /* Sesuai gambar, panah hilang saat aktif diganti teks deskripsi.
                                               Tapi untuk UX yang baik, kita biarkan icon rotate atau kita hide.
                                               Di sini saya akan rotate agar user tau bisa ditutup. */
        }

        .accordion-body {
            padding: 0 0 20px 0;
            color: #475569;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* --- Section Perawatan (Complex Cards) --- */
        .care-section {
            padding: 60px 0 100px 0;
            background: #f8fafc;
        }

        /* Kartu Biru Tua */
        .care-card {
            background: linear-gradient(135deg, #1e2a78 0%, #11184a 100%);
            border-radius: 20px;
            color: white;
            height: 220px;
            position: relative;
            overflow: hidden;
            /* Penting agar gambar tidak keluar */
            /* box-shadow: 0 10px 30px rgba(24, 35, 102, 0.2); */
            transition: transform 0.3s;
        }

        .care-card:hover {
            transform: translateY(-5px);
        }

        /* Overlay gambar background tipis */
        .care-card-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.15;
            object-fit: cover;
            z-index: 0;
        }

        .care-content {
            position: relative;
            z-index: 1;
            padding: 25px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            /* Teks di bawah (sebelum dipotong white area) */
            padding-bottom: 50px;
            /* Space agar tidak tertutup area putih */
        }

        .care-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .care-desc {
            font-size: 0.8rem;
            opacity: 0.8;
            line-height: 1.4;
            max-width: 80%;
        }

        /* TEKNIK CSS UNTUK LEKUKAN KARTU (Inverted Corner) */
        .corner-cutout {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background-color: transparent;
            z-index: 2;
            pointer-events: none;
            /* Klik tembus ke tombol */
        }

        /* Tombol putih pembungkus */
        .white-corner {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 70px;
            /* Lebar area putih */
            height: 70px;
            /* Tinggi area putih */
            background-color: #f8fafc;
            /* Sama dengan background section agar terlihat bolong */
            border-top-left-radius: 30px;
            /* Radius dalam */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
        }

        /* Pseudo element untuk membuat efek melengkung menyatu (The Connector) */
        .white-corner::before {
            content: "";
            position: absolute;
            top: -30px;
            /* Sebesar radius */
            right: 0;
            width: 30px;
            height: 30px;
            background: transparent;
            border-bottom-right-radius: 50%;
            box-shadow: 10px 10px 0 #f8fafc;
            /* Bayangan warna background section */
        }

        .white-corner::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: -30px;
            /* Sebesar radius */
            width: 30px;
            height: 30px;
            background: transparent;
            border-bottom-right-radius: 50%;
            box-shadow: 10px 10px 0 #f8fafc;
        }

        /* Tombol Pink Bulat */
        .btn-pink-circle {
            width: 45px;
            height: 45px;
            background-color: var(--accent-pink);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            transition: background 0.3s, transform 0.3s;
            box-shadow: 0 4px 10px rgba(236, 72, 153, 0.4);
            pointer-events: auto;
            /* Aktifkan klik */
        }

        .btn-pink-circle:hover {
            background-color: var(--accent-pink-hover);
            color: white;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .service-img-container img {
                border-radius: 20px;
                min-height: 250px;
                margin-bottom: 20px;
            }

            .white-corner {
                /* Perbaikan warna background corner jika di mobile tumpuk */
                background-color: #f8fafc;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Header & Promo Section -->
    <section class="promo-section text-center">
        <div class="container">
            <h1 class="fw-bold mb-3" style="color: #333;">Promo</h1>
            <p class="text-muted mx-auto mb-5" style="max-width: 700px;">
                Temukan penawaran menarik untuk layanan pemeriksaan, perawatan, dan produk kesehatan mata yang dirancang
                khusus untuk kebutuhan Anda
            </p>

            <div class="row justify-content-center g-4">
                <div class="row justify-content-center g-4">
                    @forelse($promos as $promo)
                        <div class="col-md-6 col-lg-5">
                            <div class="promo-card h-100 p-3 text-start">
                                <img src="{{ $promo->image ? asset('storage/' . $promo->image) : 'https://via.placeholder.com/600x400' }}"
                                    class="promo-img rounded-3 mb-3" alt="{{ $promo->title }}">
                                <h5 class="fw-bold mb-2">{{ $promo->title }}</h5>
                                <span class="price-badge">
                                    @if ($promo->price)
                                        Rp {{ number_format($promo->price, 0, ',', '.') }}
                                    @else
                                        Gratis / TBD
                                    @endif
                                </span>
                                <a href="{{ route('fe.detail-promo', $promo->slug) }}" class="btn btn-promo">
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

    <!-- Services Section (Accordion + Dynamic Image) -->
    <section class="services-section">
        <div class="container">
            <h1 class="fw-bold mb-5 text-start" style="color: #111;">Layanan</h1>

            <div class="row align-items-start">
                <!-- Left: Dynamic Image -->
                <div class="col-lg-6 mb-lg-0 service-img-container mb-4">
                    <img id="serviceImage"
                        src="{{ $services->first() && $services->first()->image ? asset('storage/' . $services->first()->image) : 'https://via.placeholder.com/600x400' }}"
                        alt="Layanan" class="shadow-sm">
                </div>

                <!-- Right: Accordion Menu -->
                <div class="col-lg-6 ps-lg-5">
                    <div class="accordion" id="accordionServices">

                        @forelse($services as $index => $service)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $service->id }}"
                                        aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                        onclick="changeImage('{{ $service->image ? asset('storage/' . $service->image) : 'https://via.placeholder.com/600x400' }}')">
                                        {{ $service->title }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $service->id }}"
                                    class="accordion-collapse {{ $index == 0 ? 'show' : '' }} collapse"
                                    data-bs-parent="#accordionServices">
                                    <div class="accordion-body">
                                        {{ $service->excerpt }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">Belum ada layanan yang tersedia.</p>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comprehensive Care Section (Cards with unique cutout) -->
    <section class="care-section">
        <div class="container">
            <h2 class="fw-bold mb-5" style="color: #222;">Perawatan Mata Komprehensif di Klinik Kami</h2>

            <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-md-6">
                    <div class="care-card">
                        <img src="https://img.freepik.com/free-photo/close-up-doctor-holding-glasses_23-2148847825.jpg"
                            class="care-card-bg" alt="Bg">
                        <div class="care-content">
                            <h4 class="care-title">Operasi Besar</h4>
                            <p class="care-desc">Katarak, Glaukoma dalam one day care sehingga pasien dapat nyaman
                                serta langsung pulang</p>
                        </div>
                        <!-- Area Tombol Putih dengan Lekukan -->
                        <div class="white-corner">
                            <a href="/microskop" class="btn-pink-circle"><i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-6">
                    <div class="care-card">
                        <img src="https://img.freepik.com/free-photo/ophthalmology-microscope_23-2148847835.jpg"
                            class="care-card-bg" alt="Bg">
                        <div class="care-content">
                            <h4 class="care-title">Operasi Kecil</h4>
                            <p class="care-desc">Operasi untuk Hoerdeolum Peterygium, dan Rekonstruksi</p>
                        </div>
                        <div class="white-corner">
                            <a href="/green-laser" class="btn-pink-circle"><i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-6">
                    <div class="care-card">
                        <img src="https://img.freepik.com/free-photo/laser-surgery-eye_23-2148847840.jpg"
                            class="care-card-bg" alt="Bg">
                        <div class="care-content">
                            <h4 class="care-title">Laser</h4>
                            <p class="care-desc">Glaukoma, retina, dan kekeruhan pasca operasi, dengan teknologi modern
                                dan minim invasif.</p>
                        </div>
                        <div class="white-corner">
                            <a href="/yag-laser" class="btn-pink-circle"><i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-6">
                    <div class="care-card">
                        <img src="https://img.freepik.com/free-photo/eye-drops-bottle_23-2148847845.jpg"
                            class="care-card-bg" alt="Bg">
                        <div class="care-content">
                            <h4 class="care-title">Pemeriksaan Mata</h4>
                            <p class="care-desc">Untuk penderita kelainan refraksi, glaukoma, dan retina</p>
                        </div>
                        <div class="white-corner">
                            <a href="/biometry" class="btn-pink-circle"><i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <!-- JS untuk mengganti Gambar Layanan -->
    <script>
        function changeImage(imageUrl) {
            const imgElement = document.getElementById('serviceImage');
            // Efek fade out sedikit sebelum ganti
            imgElement.style.opacity = 0;

            setTimeout(() => {
                imgElement.src = imageUrl;
                imgElement.style.opacity = 1;
            }, 300);
        }
    </script>
@endsection
