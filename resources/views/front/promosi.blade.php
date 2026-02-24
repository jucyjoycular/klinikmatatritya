@extends('layouts.app')

@section('title', 'Promo Pemeriksaan Dasar Glaukoma')

@section('styles')
<style>
/* ========= HERO STYLE ========= */
.promo-hero {
    background-color: #0A0033;
    padding: 60px 0 120px 0;
    color: #fff;
}

.promo-title {
    font-size: 2.4rem;
    font-weight: 700;
}

/* ========= CONTENT CARD ========= */
.promo-card {
    background: #fff;
    border-radius: 16px;
    padding: 40px;
    margin-top: -80px;
    margin-bottom: 80px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08);
}

/* ========= RIGHT SIDEBAR CARD ========= */
.sidebar-card {
    background: #fff;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.sidebar-img {
    width: 100%;
    height: 150px;
    border-radius: 12px;
    margin-bottom: 15px;
    object-fit: cover;
    background: #f8f9fa;
    display: block;
}

/* ========= TABLE ========= */
.promo-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 25px;
}

.promo-table th, .promo-table td {
    border: 1px solid #ccc;
    padding: 12px 15px;
    font-size: 0.95rem;
}

.promo-table th {
    background: #f7f7f7;
    font-weight: 600;
}

/* ========= BUTTON ========= */
.btn-promo {
    background: #2563eb;
    color: white;
    border-radius: 8px;
    padding: 12px 22px;
    font-weight: 600;
    width: 100%;
    text-align: center;
    display: block;
    margin-top: 15px;
    text-decoration: none;
}

.btn-promo:hover {
    background: #1e4fc9;
    color: #fff;
}

/* ========= WHATSAPP BUBBLE ========= */
.wa-btn {
    position: fixed;
    right: 25px;
    bottom: 25px;
    z-index: 99;
}

.wa-btn img {
    width: 60px;
}
</style>
@endsection

@section('content')

<div class="promo-hero">
    <div class="container">
        <h1 class="promo-title">{{ $section->title }}</h1>
        {{-- <p class="mt-3" style="max-width: 680px;">
            Dalam rangka memperingati Hari Glaukoma Sedunia pada 12 Maret 2025, Klinik Mata Tritya menghadirkan promo
            khusus pemeriksaan glaukoma sebagai bagian dari program kerja Marketing & Development.
        </p> --}}
    </div>
</div>

<div class="container">
    <div class="row">
        
        <!-- LEFT CONTENT -->
        <div class="col-lg-8">
            <div class="promo-card">

                {{-- <h4 class="fw-bold mb-3">Periode Promo</h4>
                <p>Maret – April 2025</p> --}}

                <p>{{ $section->content }}</p>

                <table class="promo-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pemeriksaan</th>
                        <th>Harga Normal</th>
                        <th>Harga Promo</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($section->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->pemeriksaan }}</td>
                            <td>Rp {{ number_format($item->harga_normal, 0, ',', '.') }}</td>
                            <td>
                                @if($item->harga_promo)
                                    Rp {{ number_format($item->harga_promo, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                </table>

                <br>

                {{-- <h4 class="fw-bold">Syarat dan Ketentuan Promo</h4>
                <ul>
                    <li>Berlaku untuk pasien umum (non-asuransi).</li>
                    <li>Jadwal pemeriksaan harus berada pada periode promo.</li>
                    <li>Promo hanya berlaku untuk paket yang ditentukan.</li>
                </ul>

                <h4 class="fw-bold mt-4">Cara Mendapatkan Promo</h4>
                <ul>
                    <li>Hubungi bagian pendaftaran Klinik Mata Tritya.</li>
                    <li>Pilih jadwal pemeriksaan selama Maret–April 2025.</li>
                    <li>Informasikan kepada petugas bahwa Anda ingin klaim promo saat administrasi.</li>
                </ul>

                <h4 class="fw-bold mt-4">Informasi & Reservasi</h4>
                <p>
                    Email: support@klinikmatatritya.co.id <br>
                    WhatsApp: 0821-1211-0048 <br>
                    Telp: 031-5020249 / 031-5020249 <br>
                    Lokasi: Ruko Bratara Plaza, Jl Barata Jaya No.58 Blok A3, Surabaya
                </p> --}}

            </div>
        </div>

        <!-- RIGHT SIDEBAR -->
        <div class="col-lg-4">
            <div class="sidebar-card">
                @php
                    $sidebarImage = (!empty($section->image) && Storage::disk('public')->exists($section->image))
                        ? asset('storage/' . $section->image)
                        : asset('img/background.jpg');
                @endphp
                <img src="{{ $sidebarImage }}" class="sidebar-img" alt="{{ $section->title }}">

                <h5 class="fw-bold">Paket Pemeriksaan Dasar Glaukoma</h5>
                <p class="text-primary fw-bold" style="font-size: 1.3rem;">Rp 250.000</p>

                <a href="#" class="btn-promo">Ambil Sekarang</a>
            </div>
        </div>

    </div>
</div>


@endsection
