@extends('layouts.app')

@section('title', 'Klinik Mata Tritya - Beranda')
@php
    $hero = \App\Models\Hero::where('is_active', 1)->first();
@endphp
@section('styles')
    <style>
        .insurance-logo {
            height: 80px;
            /* Mobile default */
            object-fit: contain;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        @media (min-width: 768px) {
            .insurance-logo {
                height: 120px;
            }
        }

        @media (min-width: 992px) {
            .insurance-logo {
                height: 160px;
                /* Desktop larger */
                margin: 0 20px;
            }
        }
    </style>
@endsection

@section('content')

    @if ($popup && $popup->image)
        <div id="popupOverlay" class="popup-overlay">
            <div class="popup-box">

                <div class="popup-close" id="closePopup">×</div>

                <img src="{{ asset('storage/' . $popup->image) }}" class="popup-image" alt="Popup Info">
            </div>
        </div>
    @endif


    <!-- 1. HERO SECTION -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content container">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="hero-title">{!! nl2br(e($hero->title)) !!}</h1>
                    <p class="hero-desc">
                        {{ $hero->description }}
                    </p>
                    <a href="{{ $hero->button_link }}" class="btn-navy">{{ $hero->button_text }}</a>
                </div>
            </div>
        </div>
    </section>

    <div style=" padding-bottom: 80px;" id="detail-page">
        <div class="container" style="max-width:1000px;">
            <div class="search-box-wrapper">
                <div class="search-box">
                    <div class="mb-4 text-center">
                        <h4 class="search-title">Biarkan Kami Membantu Anda</h4>
                        <p class="text-muted small">Cukup beritahu kami siapa dan apa kebutuhan anda.</p>
                    </div>

                    <form onsubmit="return false;">
                        <div class="row g-3 align-items-end justify-content-center">
                            <div class="col-md-auto d-flex align-items-center mb-2">
                                <span class="fw-semibold me-2">Saya seorang</span>
                            </div>

                            <div class="col-md-3">
                                <select class="form-select form-select-custom" id="roleSelect">
                                    @foreach ($help_menu_roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-auto d-flex align-items-center mb-2">
                                <span class="fw-semibold mx-2">sedang mencari</span>
                            </div>

                            <div class="col-md-3">
                                <select class="form-select form-select-custom" id="searchSelect">
                                    @foreach ($help_menu_needs as $need)
                                        <option value="{{ $need }}">{{ $need }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="button" class="btn-search-blue" onclick="redirectToWhatsapp()">
                                    Cari
                                </button>
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
                                @foreach ($specializations as $specialization)
                                    <div class="swiper-slide">
                                        <div class="specialist-card" data-title="{{ $specialization->title }}"
                                            data-desc="{{ $specialization->description }}">
                                            <!-- Icon -->
                                            <div class="spec-icon">
                                                <i class="{{ $specialization->icon }}"></i>
                                            </div>

                                            <div class="mt-auto">
                                                <h4 class="spec-name">{{ $specialization->title }}</h4>
                                                <p class="spec-desc">{{ $specialization->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @foreach ($specializations as $specialization)
                                    <div class="swiper-slide">
                                        <div class="specialist-card" data-title="{{ $specialization->title }}"
                                            data-desc="{{ $specialization->description }}">
                                            <!-- Icon -->
                                            <div class="spec-icon">
                                                <i class="{{ $specialization->icon }}"></i>
                                            </div>

                                            <div class="mt-auto">
                                                <h4 class="spec-name">{{ $specialization->title }}</h4>
                                                <p class="spec-desc">{{ $specialization->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
                                    <img src="{{ asset('img/statis/ark.png') }}" class="equip-img" alt="ARK">
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
                                    <img src="{{ asset('img/statis/nct.png') }}" class="equip-img" alt="NCT">
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
                                    <img src="{{ asset('img/statis/slit-lamp.png') }}" class="equip-img"
                                        alt="Slit Lamp">
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
                                    <img src="{{ asset('img/statis/oct.png') }}" class="equip-img" alt="OCT">
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

                    <div class="position-relative px-4">
                        <div class="swiper promoSwiper">
                            <div class="swiper-wrapper">
                                @forelse($promos as $promo)
                                    <div class="swiper-slide">
                                        <div class="promo-card text-start">
                                            <img src="{{ asset('storage/' . $promo->image) }}" class="promo-img"
                                                alt="{{ $promo->title }}">
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

                        <button
                            class="nav-circle-btn promo-prev position-absolute top-50 translate-middle-y start-0 z-10 shadow"
                            style="z-index: 10; left: -10px !important;"><i class="fas fa-chevron-left"></i></button>
                        <button
                            class="nav-circle-btn promo-next position-absolute top-50 translate-middle-y end-0 z-10 shadow"
                            style="z-index: 10; right: -10px !important;"><i class="fas fa-chevron-right"></i></button>
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
                                    <img src="{{ asset('storage/' . $article->image) }}" class="news-img"
                                        alt="{{ $article->title }}">
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
        <section class="faq-section" id="faq">
            <div class="container">
                <h2 class="section-title mb-5">F.A.Q</h2>

                {{-- Search FAQ --}}
                <div class="faq-search" style="position: relative; max-width: 520px; margin-bottom: 20px;">
                    <span class="faq-search-icon-wrap"
                        style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); width: 34px; height: 34px; border-radius: 10px; background: #dbeafe; color: #2d4cc8; display: flex; align-items: center; justify-content: center; pointer-events: none;">
                        <i class="fas fa-search"></i>
                    </span>
                    <input id="faq-search-input" class="faq-search-input" type="text"
                        placeholder="Cari pertanyaan" autocomplete="off"
                        style="width: 100%; padding: 12px 14px 12px 54px; border-radius: 12px; border: 1px solid rgba(25, 34, 95, 0.15); background: #fff; outline: none;">
                    <div id="faq-search-results" class="faq-search-results"
                        style="position: absolute; top: calc(100% + 8px); left: 0; right: 0; background: #fff; border-radius: 8px; box-shadow: none; border: 0; outline: 0; overflow: hidden; z-index: 20; display: none; padding: 8px 10px;">
                    </div>
                </div>

                <div class="row">
                    <!-- Left Side - Topic Tabs -->
                    <div class="col-lg-5 mb-lg-0 mb-4">
                        @foreach ($faqCategories as $faqCategory)
                            <div class="faq-topic-item" data-topic="{{ $faqCategory->slug }}">
                                <span>{{ $faqCategory->name }}</span>
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        @endforeach
                    </div>

                    <!-- Right Side - Dynamic Content -->
                    <div class="col-lg-7">
                        <div class="faq-right-box">
                            @foreach ($faqCategories as $faqCategory)
                                <div class="faq-content-section {{ $loop->first ? 'active' : '' }}"
                                    id="faq-{{ $faqCategory->slug }}">
                                    <h5 class="fw-bold mb-4">{{ $faqCategory->name }}</h5>

                                    @foreach ($faqCategory->faqs as $faq)
                                        <div class="faq-accordion-item"
                                            id="faq-{{ $faqCategory->slug }}-{{ $faq->id }}">
                                            <button class="faq-accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#faq-{{ $faqCategory->slug }}-{{ $faq->id }}">
                                                <span>{{ $faq->question }}</span>
                                                <i class="fas fa-chevron-down faq-icon"></i>
                                            </button>
                                            <div id="faq-{{ $faqCategory->slug }}-{{ $faq->id }}" class="collapse">
                                                <div class="faq-accordion-body">
                                                    {{ $faq->answer }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
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
                    <div class="">
                        <div class="splide asuransiSwiper">
                            <div class="splide__track">
                                <ul class="splide__list">
                                    @foreach ($insurances as $item)
                                        <li class="splide__slide">
                                            <div class="text-center">
                                                <img src="{{ asset('storage/' . $item->logo) }}" class="insurance-logo"
                                                    alt="{{ $item->name }}">
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
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
                        <div class="swiper-wrapper" id="testimonial-swiper">


                        </div>
                    </div>
                </div>
            </section>


            <!-- 10. INSTAGRAM FEED -->
            <section class="insta-section">
                <div class="container">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

                        <h3 class="fw-bold">@klinikmatatritya.official</h3>

                        <a href="https://www.instagram.com/klinikmatatritya.official/" target="_blank"
                            class="">Selengkapnya</a>
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
            </section>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        function redirectToWhatsapp() {
            const role = document.getElementById('roleSelect').value;
            const search = document.getElementById('searchSelect').value;

            const message = `Halo, saya seorang ${role} sedang mencari informasi ${search}.`;

            const phoneNumber = '6282112110048';
            const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;

            window.open(whatsappURL, '_blank');
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('faq-search-input');
            const results = document.getElementById('faq-search-results');
            const endpoint = "{{ route('fe.faq-search') }}";
            let debounceId = null;

            if (!input || !results) return;

            function hideResults() {
                results.style.display = 'none';
                results.innerHTML = '';
            }

            function showResults() {
                results.style.display = 'block';
            }

            function renderItems(items) {
                if (!items.length) {
                    results.innerHTML = '<div class="faq-search-empty">Tidak ada hasil.</div>';
                    showResults();
                    return;
                }

                results.innerHTML = items.map(item => {
                    const label = item.category ? ` <small>(${item.category})</small>` : '';
                    return `
                        <button type="button" class="faq-search-item" data-target="${item.target}" data-topic="${item.category_slug}"
                            style="display: block; width: 100%; text-align: left; border: 0; outline: 0; box-shadow: none; background: transparent; padding: 6px 2px; margin: 0 0 6px 0; white-space: normal;">
                            ${item.question}${label}
                        </button>
                    `;
                }).join('');
                showResults();
            }

            async function performSearch(query) {
                try {
                    const response = await fetch(`${endpoint}?q=${encodeURIComponent(query)}`, {
                        headers: { 'Accept': 'application/json' },
                    });
                    const data = await response.json();
                    renderItems(data.items || []);
                } catch (error) {
                    hideResults();
                }
            }

            input.addEventListener('input', function() {
                const query = input.value.trim();

                if (debounceId) {
                    clearTimeout(debounceId);
                }

                if (query.length < 2) {
                    hideResults();
                    return;
                }

                debounceId = setTimeout(function() {
                    performSearch(query);
                }, 300);
            });

            document.addEventListener('click', function(event) {
                if (!results.contains(event.target) && event.target !== input) {
                    hideResults();
                }
            });

            results.addEventListener('click', function(event) {
            const button = event.target.closest('.faq-search-item');
            if (!button) return;

            const targetId = button.getAttribute('data-target');
            const topic = button.getAttribute('data-topic');
            const topicItem = document.querySelector(`.faq-topic-item[data-topic="${topic}"]`);
            const targetSection = document.getElementById(`faq-${topic}`);
            const selectedText = button.textContent ? button.textContent.trim() : '';

            if (selectedText) {
                input.value = selectedText;
                hideResults();
            }

            if (topicItem && !topicItem.classList.contains('active')) {
                topicItem.click();
            }

            if (targetId) {
                setTimeout(function() {
                    const collapseEl = document.querySelector(`.collapse#${targetId}`);
                    if (!collapseEl) return;

                    if (targetSection) {
                        const openAccordions = targetSection.querySelectorAll('.collapse.show');
                        openAccordions.forEach(accordion => {
                            if (accordion.id === targetId) return;
                            const bsCollapse = new bootstrap.Collapse(accordion, { toggle: false });
                            bsCollapse.hide();
                        });
                    }

                    const buttonEl = document.querySelector(`[data-bs-target="#${targetId}"]`);
                    const bsCollapse = new bootstrap.Collapse(collapseEl, { toggle: false });
                    bsCollapse.show();
                    if (buttonEl) {
                        buttonEl.classList.remove('collapsed');
                    }

                    const scrollTarget = buttonEl || collapseEl;
                    const offset = 80;
                    const top = scrollTarget.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top, behavior: 'smooth' });
                }, 100);
            }

            });
        });
    </script>


@endsection
