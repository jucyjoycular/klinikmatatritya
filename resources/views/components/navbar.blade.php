<style>
    /* Info Bar Styles */
    .top-info-bar {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
        padding: 8px 0;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .top-info-bar.hidden {
        transform: translateY(-100%);
        opacity: 0;
        height: 0;
        padding: 0;
        overflow: hidden;
    }

    .top-info-bar .info-item {
        display: inline-flex;
        align-items: center;
        margin-right: 20px;
        color: #333;
        text-decoration: none;
    }

    .top-info-bar .info-item svg {
        width: 16px;
        height: 16px;
        margin-right: 6px;
        fill: #182366;
    }

    .top-info-bar .social-icons a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #182366;
        color: white;
        margin-left: 8px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .top-info-bar .social-icons a:hover {
        background-color: #2a3eb1;
    }

    .top-info-bar .social-icons svg {
        width: 14px;
        height: 14px;
        fill: white;
    }

    /* Mobile Menu Styles */
    .mobile-menu {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: white;
        z-index: 9999;
        padding: 20px 12px;
        display: none;
        flex-direction: column;
    }

    .mobile-menu.show {
        display: flex;
        flex-direction: column;
        justify-content: start;
    }

    .mobile-menu-list {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }



    .mobile-menu a.menu-mobile {
        font-size: 24px;
        margin-bottom: 24px;
        text-decoration: none;
        display: block;
        color: #333;
    }

    .menu-close-btn {
        font-size: 90px;
        text-align: center;
        cursor: pointer;
        color: #333;
    }

    /* if tablet */
    @media (max-width: 768px) {
        .mobile-menu-link {
            margin-top: auto;
        }
    }

    @media (min-width: 768px) {
        .mobile-menu a.menu-mobile {
            text-align: center;
        }
    }

    /* Navbar sticky adjustment */
    .navbar.sticky-top {
        top: 0;
    }

    @media (max-width: 768px) {
        .top-info-bar .info-item {
            font-size: 0.75rem;
            margin-right: 10px;
        }

        .top-info-bar .social-icons {
            margin-top: 5px;
        }
    }

    /* Search Dropdown Styles */
    .search-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        max-height: 300px;
        overflow-y: auto;
        border-radius: 0 0 4px 4px;
        display: none;
        border: 1px solid #e0e0e0;
    }

    .search-result-item {
        padding: 10px 15px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        font-size: 0.9rem;
        transition: background-color 0.2s;
        text-decoration: none;
        display: block;
        color: #333;
    }

    .search-result-item:hover {
        background-color: #f8f9fa;
        color: var(--primary-navy, #202c85);
        /* Use primary color if available */
    }

    .search-result-type {
        font-size: 0.75rem;
        color: #888;
        text-transform: uppercase;
        display: block;
        margin-bottom: 2px;
        font-weight: 600;
    }
</style>

<!-- Top Info Bar (Hidden on Mobile) -->
<div class="top-info-bar d-none d-md-block" id="topInfoBar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-7">
                <div class="d-flex align-items-center flex-wrap">
                    <a href="https://maps.google.com/?q={{ urlencode($office_address) }}" class="info-item">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path
                                d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z" />
                        </svg>
                        <span class="d-none d-md-inline">{{ $office_address }}</span>
                        <span class="d-inline d-md-none">{{ $office_address }}</span>
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $office_wa) }}" class="info-item"
                        target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path
                                d="M224 122.8c-72.7 0-131.8 59.1-131.9 131.8 0 24.9 7 49.2 20.2 70.1l3.1 5-13.3 48.6 49.9-13.1 4.8 2.9c20.2 12 43.4 18.4 67.1 18.4h.1c72.6 0 133.3-59.1 133.3-131.8 0-35.2-15.2-68.3-40.1-93.2-25-25-58-38.7-93.2-38.7zm77.5 188.4c-3.3 9.3-19.1 17.7-26.7 18.8-12.6 1.9-22.4.9-47.5-9.9-39.7-17.2-65.7-57.2-67.7-59.8-2-2.6-16.2-21.5-16.2-41s10.2-29.1 13.9-33.1c3.6-4 7.9-5 10.6-5 2.6 0 5.3 0 7.6.1 2.4.1 5.7-.9 8.9 6.8 3.3 7.9 11.2 27.4 12.2 29.4s1.7 4.3.3 6.9c-7.6 15.2-15.7 14.6-11.6 21.6 15.3 26.3 30.6 35.4 53.9 47.1 4 2 6.3 1.7 8.6-1 2.3-2.6 9.9-11.6 12.5-15.5 2.6-4 5.3-3.3 8.9-2 3.6 1.3 23.1 10.9 27.1 12.9s6.6 3 7.6 4.6c.9 1.9.9 9.9-2.4 19.1zM400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM223.9 413.2c-26.6 0-52.7-6.7-75.8-19.3L64 416l22.5-82.2c-13.9-24-21.2-51.3-21.2-79.3C65.4 167.1 136.5 96 223.9 96c42.4 0 82.2 16.5 112.2 46.5 29.9 30 47.9 69.8 47.9 112.2 0 87.4-72.7 158.5-160.1 158.5z" />
                        </svg>
                        <span>{{ $office_wa }}</span>
                    </a>
                    <a href="mailto:{{ $office_email }}" class="info-item d-none d-lg-inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z" />
                        </svg>
                        <span>{{ $office_email }}</span>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-5">
                <div class="social-icons text-end">
                    <a href="https://facebook.com/klinikmatatrityasurabaya" target="_blank" title="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <path
                                d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z" />
                        </svg>
                    </a>
                    <a href="https://instagram.com/klinikmatatritya.official" target="_blank" title="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path
                                d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                        </svg>
                    </a>
                    <a href="https://youtube.com/@klinikmatatritya" target="_blank" title="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path
                                d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" />
                        </svg>
                    </a>
                    <a href="https://www.tiktok.com/@klinikmatatritya" target="_blank" title="Tiktok">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-tiktok" viewBox="0 0 16 16">
                            <path
                                d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top bg-white">
    <div class="d-flex justify-content-between align-items-center container">

        <a class="navbar-brand" href="/">
            <img src="{{ asset('img/logonew.jpeg') }}" width="80">
        </a>

        <!-- Mobile menu button -->
        <button class="navbar-toggler 5border-0" type="button" id="openMenu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.97461 5.97485H19.9746" stroke="#333333" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M3.97461 11.9749H19.9746" stroke="#333333" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M3.97461 17.9749H19.9746" stroke="#333333" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>

        </button>

        <!-- Normal Desktop Menu -->
        <div class="navbar-collapse d-none d-lg-flex collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="/">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="/doctors">Jadwal Dokter</a></li>
                <li class="nav-item"><a class="nav-link" href="/services">Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="/careers">Kemitraan dan Karir</a></li>
                <li class="nav-item"><a class="nav-link" href="/news">Berita</a></li>
                <li class="nav-item"><a class="nav-link" href="/about">Tentang Kami</a></li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                <div class="input-group input-group-sm d-none d-lg-flex position-relative" style="width: 200px;">
                    <input type="text" class="form-control" placeholder="Search" id="desktopSearchInput"
                        autocomplete="off">
                    <button class="btn btn-outline-secondary border-start-0 border" type="button"><i
                            class="fas fa-search"></i></button>
                    <div id="desktopSearchResults" class="search-dropdown"></div>
                </div>
                <button class="btn btn-janji btn-sm px-3 py-2"
                    onclick="window.location.href='{{ $booking_link ?: 'http://tritya.id/DaftarOnline' }}'">Buat
                    Janji</button>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('img/logo.png') }}" width="80">
            </a>

            <!-- Mobile menu button -->
            <button class="navbar-toggler border-0" type="button" id="closeMenu2"
                style="padding: 0.25rem 0.75rem;">
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.97461 5.97485H19.9746" stroke="#333333" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M8 11.9749H24" stroke="#333333" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M3.97461 17.9749H19.9746" stroke="#333333" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <div class="input-group position-relative mb-4" style="padding-inline: 20px;">
            <input type="text" class="form-control" placeholder="Search" id="mobileSearchInput"
                autocomplete="off">
            <button class="btn btn-outline-secondary" style="border-color: #dee2e6"><i
                    class="fas fa-search"></i></button>
            <div id="mobileSearchResults" class="search-dropdown" style="left: 20px; right: 20px;"></div>
        </div>
    </div>

    <div style="padding-inline: 20px;" class="mobile-menu-list">
        <div class="mobile-menu-link">
            <a class="menu-mobile" href="/">Beranda</a>
            <a class="menu-mobile" href="/doctors">Jadwal Dokter</a>
            <a class="menu-mobile" href="/services">Layanan</a>
            <a class="menu-mobile" href="/careers">Kemitraan dan Karir</a>
            <a class="menu-mobile" href="/news">Berita</a>
            <a class="menu-mobile" href="/about">Tentang Kami</a>
        </div>

        <div class="menu-close-btn" id="closeMenu">
            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor"
                class="bi bi-x-lg" viewBox="0 0 16 16">
                <path
                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
            </svg>
        </div>
    </div>
</div>

<!-- JavaScript for scroll behavior -->
<script>
    let lastScrollTop = 0;
    const infoBar = document.getElementById('topInfoBar');

    window.addEventListener('scroll', function() {
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop >= 50) {
            // User has scrolled down, hide the info bar
            infoBar.classList.add('hidden');
        } else {
            // User is at the top, show the info bar
            infoBar.classList.remove('hidden');
        }

        lastScrollTop = scrollTop;
    });


    document.getElementById('openMenu').addEventListener('click', function() {
        document.body.style.overflow = 'hidden';
        document.getElementById('mobileMenu').classList.add('show');
    });

    document.getElementById('closeMenu').addEventListener('click', function() {
        document.body.style.overflow = '';
        document.getElementById('mobileMenu').classList.remove('show');
    });
    document.getElementById('closeMenu2').addEventListener('click', function() {
        document.body.style.overflow = '';
        document.getElementById('mobileMenu').classList.remove('show');
    });

    // Search Logic
    function handleSearch(inputId, resultsId) {
        const input = document.getElementById(inputId);
        const results = document.getElementById(resultsId);

        if (!input || !results) return;

        let timeout = null;

        input.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value;

            if (query.length < 2) {
                results.style.display = 'none';
                return;
            }

            timeout = setTimeout(() => {
                fetch(`{{ route('fe.search') }}?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        results.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(item => {
                                const div = document.createElement('div');
                                div.className = 'search-result-item';
                                div.innerHTML =
                                    `<span class="search-result-type">${item.type}</span>${item.title}`;
                                div.onclick = () => window.location.href = item.url;
                                results.appendChild(div);
                            });
                            results.style.display = 'block';
                        } else {
                            results.innerHTML =
                                '<div class="search-result-item text-muted" style="cursor: default;">No results found</div>';
                            results.style.display = 'block';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }, 300);
        });

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !results.contains(e.target)) {
                results.style.display = 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        handleSearch('desktopSearchInput', 'desktopSearchResults');
        handleSearch('mobileSearchInput', 'mobileSearchResults');
    });
</script>
