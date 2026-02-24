<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Klinik Mata Tritya')</title>

    <link rel="icon" type="image/png" href="{{ asset('img/favicon/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/favicon/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('img/favicon/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-94NDTFH6KV"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-94NDTFH6KV');
    </script>


    <style>
        :root {
            --primary-navy: #1D2088;
            --accent-blue: #3b82f6;
            --light-blue-bg: #dbeafe;
            --light-bg: #f8fafc;
            --text-dark: #1f2937;
            --sidebar-width: 260px;
            --header-height: 70px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            height: var(--header-height);
            display: flex;
            align-items: center;
            padding: 0 24px;
            border-bottom: 1px solid #f1f5f9;
        }

        .sidebar-menu {
            padding: 20px 0;
            flex-grow: 1;
            overflow-y: auto;
        }

        .menu-item {
            padding: 12px 24px;
            display: flex;
            align-items: center;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .menu-item:hover,
        .menu-item.active {
            background-color: var(--light-blue-bg);
            color: var(--primary-navy);
            border-left-color: var(--primary-navy);
        }

        .menu-item i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Header */
        .top-header {
            height: var(--header-height);
            background-color: white;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-wrapper {
            padding: 30px;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            /* Overlay */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .sidebar-overlay.show {
                display: block;
                opacity: 1;
            }
        }
    </style>
    @yield('styles')



</head>

<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="40">
                <span class="fw-bold text-dark fs-5">Admin Panel</span>
            </div>
        </div>

        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item @if (request()->routeIs('admin.dashboard')) active @endif">
                <i class="fas fa-th-large"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.hero.edit') }}" class="menu-item @if (request()->routeIs('admin.hero.*')) active @endif">
                <i class="fas fa-user-md"></i>
                <span>Hero</span>
            </a>

            <a href="{{ route('popup.edit') }}" class="menu-item @if (request()->routeIs('admin.popup.*')) active @endif">
                <i class="fas fa-user-md"></i>
                <span>Main Popup Home</span>
            </a>

            <a href="{{ route('admin.doctors.index') }}"
                class="menu-item @if (request()->routeIs('admin.doctors.*')) active @endif">
                <i class="fas fa-user-md"></i>
                <span>Dokter</span>
            </a>

            <a href="{{ route('admin.services.index') }}"
                class="menu-item @if (request()->routeIs('admin.services.*')) active @endif">
                <i class="fas fa-hand-holding-medical"></i>
                <span>Layanan</span>
            </a>

            <a href="{{ route('admin.faqs.index') }}"
                class="menu-item @if (request()->routeIs('admin.faqs.*')) active @endif">
                <i class="fas fa-question-circle"></i>
                <span>FAQ</span>
            </a>

            <a href="{{ route('admin.promos.index') }}"
                class="menu-item @if (request()->routeIs('admin.promos.*')) active @endif">
                <i class="fas fa-tags"></i>
                <span>Promo</span>
            </a>

            <a href="{{ route('admin.review-settings.index') }}"
                class="menu-item @if (request()->routeIs('admin.review-settings.*')) active @endif">
                <i class="fas fa-star"></i>
                <span>Review Settings</span>
            </a>

            <a href="{{ route('admin.insurances.index') }}"
                class="menu-item @if (request()->routeIs('admin.insurances.*')) active @endif">
                <i class="fas fa-hand-holding-heart"></i>
                <span>Pilihan Asuransi</span>
            </a>

            <a href="{{ route('admin.specializations.index') }}"
                class="menu-item @if (request()->routeIs('admin.specializations.*')) active @endif">
                <i class="fas fa-stethoscope"></i>
                <span>Spesialisasi</span>
            </a>

            <a href="{{ route('admin.instagram-settings.index') }}"
                class="menu-item @if (request()->routeIs('admin.instagram-settings.*')) active @endif">
                <i class="fab fa-instagram"></i>
                <span>Instagram Settings</span>
            </a>

            <a href="{{ route('admin.articles.index') }}"
                class="menu-item @if (request()->routeIs('admin.articles.*')) active @endif">
                <i class="fas fa-newspaper"></i>
                <span>Artikel</span>
            </a>


            {{-- <a href="{{ route('admin.testimonials.index') }}" class="menu-item @if (request()->routeIs('admin.testimonials.*')) active @endif">
                <i class="fas fa-newspaper"></i>
                <span>Testimonials</span>
            </a> --}}

            <a href="{{ route('admin.careers.index') }}"
                class="menu-item @if (request()->routeIs('admin.careers.*')) active @endif">
                <i class="fas fa-briefcase"></i>
                <span>Karir</span>
            </a>

            <a href="{{ route('admin.job-applications.index') }}"
                class="menu-item @if (request()->routeIs('admin.job-applications.*')) active @endif">
                <i class="fas fa-file-alt"></i>
                <span>Lamaran Masuk</span>
            </a>

            <a href="{{ route('admin.settings.analytics') }}"
                class="menu-item @if (request()->routeIs('admin.analytics.*')) active @endif">
                <i class="fas fa-newspaper"></i>
                <span>Analytics</span>
            </a>

            <a href="{{ route('admin.settings.mail') }}"
                class="menu-item @if (request()->routeIs('admin.settings.mail')) active @endif">
                <i class="fas fa-envelope"></i>
                <span>Mail Settings</span>
            </a>
            <a href="{{ route('admin.settings.general') }}"
                class="menu-item @if (request()->routeIs('admin.settings.general')) active @endif">
                <i class="fas fa-cogs"></i>
                <span>General Settings</span>
            </a>
            <a href="{{ route('admin.settings.footer') }}"
                class="menu-item @if (request()->routeIs('admin.settings.footer')) active @endif">
                <i class="fa-solid fa-gear"></i>
                <span>Footer Settings</span>
            </a>
        </nav>

        <div class="border-top p-3">
            <a href="{{ route('admin.logout') }}"
                class="d-flex align-items-center text-decoration-none text-danger hover-bg-light rounded px-3 py-2">
                <i class="fas fa-sign-out-alt me-2"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <button class="btn btn-link text-dark d-lg-none" id="sidebarToggle">
                <i class="fas fa-bars fs-4"></i>
            </button>

            <h5 class="fw-bold d-none d-lg-block mb-0">@yield('header_title', 'Dashboard')</h5>

            <div class="dropdown">
                <button class="btn d-flex align-items-center gap-2 border-0 bg-transparent" type="button"
                    data-bs-toggle="dropdown">
                    <div class="d-none d-md-block text-end">
                        <div class="fw-bold small">Admin User</div>
                        <div class="text-muted" style="font-size: 0.75rem;">admin@tritya.com</div>
                    </div>
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold"
                        style="width: 40px; height: 40px;">
                        A
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm">
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">Logout</a></li>
                </ul>
            </div>
        </header>

        <!-- Page Content -->
        <div class="content-wrapper">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);
    </script>
    @yield('scripts')
    @stack('scripts')
</body>

</html>
