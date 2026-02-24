@extends('layouts.app')

@section('title', 'Klinik Mata Tritya - Detail Dokter')

@section('styles')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
        :root {
            --primary-navy: #182366;
            --light-blue-bg: #dbeafe;
            --light-bg: #f8fafc;
            --text-dark: #333;
            --calendar-active: #182366;
            /* Warna tanggal aktif */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
        }

        /* --- Navbar --- */
        .navbar {
            background: white;
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
            font-weight: 700;
        }

        .btn-janji {
            background-color: var(--light-blue-bg);
            color: #2563eb;
            font-weight: 600;
            border: none;
        }

        /* --- Header Profile --- */
        .back-link {
            text-decoration: none;
            color: var(--primary-navy);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .doctor-img-detail {
            width: 100%;
            border-radius: 20px;
            object-fit: cover;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .profile-list li {
            margin-bottom: 8px;
            line-height: 1.5;
            color: #444;
        }

        /* --- Content Cards --- */
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
            margin-bottom: 30px;
            border: none;
        }

        .section-title {
            font-weight: 700;
            color: #111;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        /* --- JADWAL SECTION (Custom Styling) --- */
        /* 1. Calendar Mini */
        .calendar-wrapper {
            padding: 10px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            text-align: center;
        }

        .calendar-day-name {
            font-size: 0.8rem;
            color: #888;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .calendar-date {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 0.9rem;
            color: #555;
            cursor: default;
        }

        /* State untuk tanggal */
        .calendar-date.active {
            background-color: var(--calendar-active);
            color: white;
            font-weight: 600;
        }

        .calendar-date.has-schedule {
            border: 1px solid var(--calendar-active);
            color: var(--calendar-active);
        }

        .calendar-date.faded {
            color: #ccc;
        }

        /* 2. Schedule Table */
        .table-schedule thead th {
            background-color: #f1f5f9;
            color: var(--primary-navy);
            border: none;
            padding: 15px;
            text-align: center;
            font-weight: 600;
        }

        .table-schedule tbody td {
            text-align: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
            color: #555;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .table-schedule tbody tr:last-child td {
            border-bottom: none;
        }

        .btn-janji-small {
            background-color: var(--light-blue-bg);
            color: var(--primary-navy);
            font-weight: 600;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
        }

        /* --- Slider News --- */
        .nav-arrows .btn-arrow {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 1px solid #eee;
            color: var(--primary-navy);
            margin-left: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .news-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            height: 100%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        }

        .news-card img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .news-body {
            padding: 20px;
        }

        .btn-full-width {
            background-color: var(--light-blue-bg);
            color: #2563eb;
            width: 100%;
            text-align: left;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-decoration: none;
        }

        /* Footer & Float */
        .footer-wrapper {
            position: relative;
            margin-top: 50px;
        }

        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #FFF;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            z-index: 100;
            box-shadow: 2px 2px 3px #999;
        }

        @media (max-width: 768px) {
            .calendar-grid {
                gap: 2px;
            }

            .calendar-date {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
        }
    </style>
@endsection


@section('content')

    <div class="container py-5">
        <!-- Back Button -->
        <a href="/doctors" class="back-link"><i class="fas fa-chevron-left me-2"></i> Kembali</a>

        <!-- Header Profile -->
        <div class="mb-5">
            <h1 class="fw-bold mb-1">{{ $doctor->name }}</h1>
            <p class="text-muted fs-5 mb-4">{{ $doctor->specialty }}</p>

            <div class="row g-5">
                <!-- Image -->
                <div class="col-lg-4">
                    <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : 'https://placehold.co/400' }}"
                        alt="{{ $doctor->name }}" class="doctor-img-detail">
                </div>
                <!-- Education & Training -->
                <div class="col-lg-8">

                    @if ($doctor->education_history)
                        <h3 class="fw-bold mb-3">Riwayat Pendidikan</h3>
                        <ul class="profile-list">
                            @foreach (explode(PHP_EOL, $doctor->education_history) as $item)
                                @if (trim($item))
                                    <li>{{ $item }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif

                    @if ($doctor->special_training)
                        <h3 class="fw-bold mb-3 mt-4">Pendidikan/Pelatihan Khusus</h3>
                        <ul class="profile-list">
                            @foreach (explode(PHP_EOL, $doctor->special_training) as $item)
                                @if (trim($item))
                                    <li>{{ $item }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Section: Kompetensi -->
        <!-- Section: Kompetensi -->
        @if ($doctor->competence)
            <div class="content-card">
                <h3 class="section-title">Kompetensi dan Keahlian Bidang</h3>
                <p style="line-height: 1.8; color: #555;">
                    {!! nl2br(e($doctor->competence)) !!}
                </p>
            </div>
        @endif

        <!-- Section: Penelitian -->
        <!-- Section: Penelitian -->
        @if ($doctor->research_publications)
            <div class="content-card">
                <h3 class="section-title">Penelitian dan Publikasi</h3>
                <ul class="list-unstyled">
                    @foreach (explode(PHP_EOL, $doctor->research_publications) as $item)
                        @if (trim($item))
                            <li class="mb-3">
                                {{ $item }}
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Section: Jadwal Praktek Lengkap -->
        <div class="content-card">
            <h3 class="section-title">Jadwal Praktek Lengkap</h3>
            @if ($doctor->schedules && $doctor->schedules->count())
                <div class="table-responsive">
                    <table class="table-schedule table-hover table">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doctor->schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->day }}</td>
                                    <td>{{ $schedule->hours }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Jadwal belum tersedia.</p>
            @endif
        </div>

        {{-- <!-- Section: JADWAL DOKTER (Dynamic Ready) -->
        <div class="content-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="section-title mb-0">Jadwal Dokter</h3>
                <button class="btn-janji-small">Buat Janji <i class="fas fa-chevron-right ms-2"></i></button>
            </div>

            <div class="row">
                <!-- 1. Calendar View (Left) -->
                <div class="col-lg-4 border-end">
                    <div class="calendar-wrapper">
                        <!-- Header Calendar -->
                        <div class="calendar-header">
                            <span>January 2025</span>
                            <div>
                                <i class="fas fa-chevron-left me-3 cursor-pointer"></i>
                                <i class="fas fa-chevron-right cursor-pointer"></i>
                            </div>
                        </div>

                        <!-- Days Header -->
                        <div class="calendar-grid">
                            <div class="calendar-day-name">Su</div>
                            <div class="calendar-day-name">Mo</div>
                            <div class="calendar-day-name">Tu</div>
                            <div class="calendar-day-name">We</div>
                            <div class="calendar-day-name">Th</div>
                            <div class="calendar-day-name">Fr</div>
                            <div class="calendar-day-name">Sa</div>
                        </div>

                        <!-- Dates Grid (Dynamic Logic Idea) -->
                        <!-- Logic Backend: Loop tgl 1-31. Cek jika hari ini ada jadwal, beri class 'active' atau 'has-schedule' -->
                        <div class="calendar-grid mt-2">
                            <div class="calendar-date faded">30</div>
                            <div class="calendar-date faded">31</div>
                            <div class="calendar-date">1</div>
                            <div class="calendar-date">2</div>
                            <div class="calendar-date">3</div>
                            <div class="calendar-date">4</div>
                            <div class="calendar-date">5</div>

                            <!-- Contoh Tanggal Aktif (Praktek) -->
                            <div class="calendar-date active">6</div>
                            <div class="calendar-date active">7</div>
                            <div class="calendar-date active">8</div>
                            <div class="calendar-date active">9</div>
                            <div class="calendar-date active">10</div>
                            <div class="calendar-date active">11</div>
                            <div class="calendar-date">12</div>

                            <div class="calendar-date active">13</div>
                            <div class="calendar-date active">14</div>
                            <div class="calendar-date">15</div>
                            <div class="calendar-date active">16</div>
                            <div class="calendar-date active">17</div>
                            <div class="calendar-date active">18</div>
                            <div class="calendar-date">19</div>

                            <div class="calendar-date active">20</div>
                            <div class="calendar-date active">21</div>
                            <div class="calendar-date">22</div>
                            <div class="calendar-date active">23</div>
                            <div class="calendar-date active">24</div>
                            <div class="calendar-date active">25</div>
                            <div class="calendar-date">26</div>

                            <div class="calendar-date">27</div>
                            <div class="calendar-date">28</div>
                            <div class="calendar-date">29</div>
                            <div class="calendar-date">30</div>
                            <div class="calendar-date">31</div>
                        </div>
                    </div>
                </div>

                <!-- 2. Weekly Schedule Table (Right) -->
                <!-- Struktur Tabel ini mudah di-looping di Laravel -->
                <div class="col-lg-8">
                    <div class="table-responsive">
                        <table class="table-schedule table-hover table">
                            <thead>
                                <tr>
                                    <th>Senin</th>
                                    <th>Selasa</th>
                                    <th>Rabu</th>
                                    <th>Kamis</th>
                                    <th>Jumat</th>
                                    <th>Minggu & Holiday</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Baris Shift 1 -->
                                <tr>
                                    <!-- Logic Backend: foreach ($days as $day) -->
                                    <td>08.00–11.00 WIB</td>
                                    <td>08.00–11.00 WIB</td>
                                    <td>08.00–11.00 WIB</td>
                                    <td>08.00–11.00 WIB</td>
                                    <td>08.00–11.00 WIB</td>
                                    <td>08.00–11.00 WIB</td>
                                </tr>
                                <!-- Baris Shift 2 (Jika Ada) -->
                                <tr>
                                    <td>13.00–15.00 WIB</td> <!-- Contoh data kosong bisa dihandle backend -->
                                    <td>-</td>
                                    <td>13.00–15.00 WIB</td>
                                    <td>-</td>
                                    <td>13.00–15.00 WIB</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Section: Postingan Terbaru (Slider) -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
            <h2 class="fw-bold">Postingan Terbaru</h2>
            <div class="nav-arrows">
                <button class="btn-arrow news-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="btn-arrow news-next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>

        <div class="swiper newsSwiper">
            <div class="swiper-wrapper">
                @foreach ($articles as $article)
                    <div class="swiper-slide">
                        <div class="news-card">
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}"
                                style="height: 200px; object-fit: cover; width: 100%;">
                            <div class="news-body">
                                <small
                                    class="text-muted d-block mb-2">{{ $article->created_at->isoFormat('D MMMM Y') }}</small>
                                <h5 class="fw-bold mb-3"
                                    style="min-height: 48px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $article->title }}</h5>
                                <a href="{{ route('fe.news.detail', $article->slug) }}" class="btn-full-width">Baca
                                    selengkapnya <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection


@section('scripts')
    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".newsSwiper", {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
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
