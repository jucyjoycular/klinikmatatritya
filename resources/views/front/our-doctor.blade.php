@extends('layouts.app')

@section('title', 'Klinik Mata Tritya - Temui Dokter Kami')

@section('styles')
    <style>
        :root {
            --primary-blue: #182366;
            /* Biru tua footer */
            --accent-blue: #2a3eb1;
            /* Biru tombol */
            --light-bg: #f4f7fc;
            --text-dark: #333;
        }

        /* Schedule Section */
        .schedule-header {
            background-color: #f1f5f9;
            font-weight: 600;
        }

        .table-custom th,
        .table-custom td {
            text-align: center;
            vertical-align: middle;
            padding: 15px;
            border: none;
            font-size: 0.9rem;
        }

        .table-custom tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Doctor Cards */
        .doctor-card {
            border: none;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s;
            height: 100%;
            /* box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05); */
        }

        .doctor-card:hover {
            transform: translateY(-5px);
        }

        .doctor-img {
            height: 250px;
            object-fit: cover;
            object-position: top;
            width: 100%;
            background-color: #e9ecef;
        }

        .card-body {
            position: relative;
            padding: 20px;
        }

        .doctor-name {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .doctor-role {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.4;
        }

        /* --- Logika Lekukan (Inverted Corner) --- */
        .white-corner {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 70px;
            height: 70px;
            background-color: var(--light-bg);
            /* Warna background halaman */
            border-top-left-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        /* Konektor Lekukan Atas */
        .white-corner::before {
            content: "";
            position: absolute;
            top: -30px;
            right: 0;
            width: 30px;
            height: 30px;
            background: transparent;
            border-bottom-right-radius: 50%;
            box-shadow: 10px 10px 0 var(--light-bg);
        }

        /* Konektor Lekukan Kiri */
        .white-corner::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: -30px;
            width: 30px;
            height: 30px;
            background: transparent;
            border-bottom-right-radius: 50%;
            box-shadow: 10px 10px 0 var(--light-bg);
        }

        /* Tombol Pink */
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
        }

        .btn-pink-circle:hover {
            background-color: var(--accent-pink-hover);
            color: white;
            transform: scale(1.1);
        }

        .btn-arrow {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary-blue);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: background 0.3s;
        }

        .btn-arrow:hover {
            background-color: var(--accent-blue);
            color: white;
        }

        .btn-arrow-light {
            background-color: #fff;
            color: var(--primary-blue);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Anatomy Section */
        .anatomy-section {
            background-color: white;
            padding: 60px 0;
            margin-top: 50px;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.03);
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
            cursor: pointer;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        /* Search Inputs */
        .search-input {
            border-radius: 5px 0 0 5px;
            border: 1px solid #ced4da;
        }

        .search-btn {
            border-radius: 0 5px 5px 0;
            background: white;
            border: 1px solid #ced4da;
            border-left: none;
        }
    </style>
@endsection

@section('content')
    <div class="container pt-5">
        
        <section style="background: linear-gradient(to bottom, #e6f1ff, #bcd9ff, #6298df, #1c4dab); padding: 60px 0 80px 0;">
            <div class="container">

                <div class="d-flex align-items-center justify-content-between mb-5" style="color:#1c4dab;">
    
                    <div>
                        <img src="{{ asset('img/logo.png') }}" 
                            style="width:500px;height:70px; width:auto; filter:drop-shadow(0 2px 5px rgba(0,0,0,0.15));">
                    </div>

                    <div class="text-end">
                        <h1 style="font-weight: 800; font-size: 44px; margin:0;">
                            Jadwal Praktek Dokter
                        </h1>
                        <div style="font-size: 20px; margin-top: -8px;">
                            Klinik Mata Tritya | Periode: <span style="font-weight: 700;">Desember 2025</span>
                        </div>
                    </div>

                </div>
                <br>
                <div class="row" style="row-gap: 55px;">

                    @forelse($doctors as $doctor)
                    <div class="col-lg-3 col-md-4 col-sm-6 d-flex justify-content-center">
                       @include('components.doctor-card', [
                        'name' => $doctor->name,
                        'photo' => $doctor->photo ? asset('storage/'.$doctor->photo) : null,
                        'spec' => $doctor->specialty,
                        'schedule' => $doctor->schedules
                            ->pluck('hours','day')
                            ->toArray()
                    ])
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Belum ada data dokter yang tersedia.</p>
                    </div>
                @endforelse

                    


                </div>

                <!-- FOOTER -->
                <div class="text-center text-white mt-5" style="font-size:17px; font-weight:600;">
                    LAYANAN PASIEN: 08211-211-0048 (WhatsApp) &nbsp; | &nbsp;
                    LAYANAN DARURAT: 08211-7777-048 (WhatsApp)
                </div>

            </div>
        </section>

        <!-- Anatomy Section -->
        <div class="anatomy-section">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-lg-0 mb-4 text-center">
                    <!-- Placeholder for Eye Anatomy Illustration -->
                    <img src="{{ asset('img/anatomi-mata.png') }}" class="img-fluid" style="max-height: 400px;"
                        alt="Anatomi Mata">
                </div>
                <div class="col-lg-5">
                    <h2 class="fw-bold mb-3">Tidak tahu mulai dari mana?</h2>
                    <p class="text-muted mb-4">Cukup klik bagian mata mana yang menjadi permasalahan anda atau cari di
                        bawah ini</p>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Conjunctiva</li>
                        <li class="list-group-item">Cornea</li>
                        <li class="list-group-item">Vitreous</li>
                        <li class="list-group-item">Cornea</li>
                        <li class="list-group-item">Vitreous</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
