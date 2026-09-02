<!doctype html>
<html lang="nl">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Statistics</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @livewireStyles

    <style>
        body {
            background: #f1f5f9;
            font-family: system-ui, -apple-system, sans-serif;
            padding-bottom: 0;
        }

        /* =========================
           HEADER
        ========================= */

        .stock-header {
            height: 64px;
            background: #EBB618;
            color: white;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
            position: relative;
            z-index: 1030;
        }

        .stock-header .logo {
            font-size: 1.4rem;
            font-weight: 700;
        }

        .stock-header i {
            font-size: 1.6rem;
        }


        /* =========================
           DESKTOP LAYOUT
        ========================= */

        .statistics-layout {
            display: flex;
            align-items: flex-start;
            max-width: 1800px;
            margin: 0 auto;
        }

        .statistics-sidebar {
            width: 240px;
            flex-shrink: 0;
            padding: 20px 0 20px 15px;
            position: sticky;
            top: 0;
            height: calc(100vh - 64px);
        }

        .statistics-sidebar .list-group {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }

        .statistics-sidebar .list-group-item {
            border-left: 0;
            border-right: 0;
        }

        .statistics-sidebar .list-group-item:first-child {
            border-top: 0;
        }

        .statistics-sidebar .list-group-item:last-child {
            border-bottom: 0;
        }


        /* =========================
           CONTENT
        ========================= */

        .statistics-content {
            flex: 1;
            min-width: 0;
            padding: 20px;
        }

        .stock-container {
            width: 100%;
        }


        /* =========================
           CARDS
        ========================= */

        .stock-card {
            background: white;
            border-radius: 16px;
            padding: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .08);
        }


        /* =========================
           MOBILE MENU BUTTON
        ========================= */

        .mobile-statistics-menu {
            display: none;
        }


        /* =========================
           MOBILE BOTTOM NAVIGATION
        ========================= */

        .stock-footer {
            display: none;
        }


        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 991.98px) {

            body {
                padding-bottom: 70px;
            }

            .stock-header {
                height: 60px;
                padding: 0 15px;
            }

            .stock-header .logo {
                font-size: 1.2rem;
            }

            .stock-header i {
                font-size: 1.4rem;
            }


            .statistics-layout {
                display: block;
            }

            .statistics-sidebar {
                display: none;
            }

            .statistics-content {
                padding: 10px 12px 20px;
            }


            /* Mobiele menuknop */

            .mobile-statistics-menu {
                display: block;
                padding: 10px 12px 0;
            }

            .mobile-statistics-menu .btn {
                background: white;
                border: 1px solid #dee2e6;
                border-radius: 12px;
                min-height: 48px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, .05);
            }

            .mobile-statistics-menu .btn:active,
            .mobile-statistics-menu .btn:focus {
                box-shadow: 0 2px 6px rgba(0, 0, 0, .08);
            }


            /* Offcanvas */

            .statistics-offcanvas {
                width: 290px !important;
            }

            .statistics-offcanvas .offcanvas-header {
                background: #EBB618;
                color: white;
                min-height: 64px;
            }

            .statistics-offcanvas .btn-close {
                filter: brightness(0) invert(1);
            }

            .statistics-offcanvas .list-group-item {
                padding: 13px 18px;
            }

            .statistics-offcanvas .list-group-item.active {
                background: #EBB618;
                border-color: #EBB618;
            }


            /* Bottom navigation */

            .stock-footer {
                position: fixed;
                display: flex;
                bottom: 0;
                left: 0;
                right: 0;
                height: 64px;
                background: white;
                border-top: 1px solid #dee2e6;
                justify-content: space-around;
                align-items: stretch;
                z-index: 1040;
                box-shadow: 0 -2px 10px rgba(0, 0, 0, .08);
                padding-bottom: env(safe-area-inset-bottom);
            }

            .stock-footer a {
                flex: 1;
                color: #6c757d;
                text-decoration: none;
                font-size: .72rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 2px;
            }

            .stock-footer a.active {
                color: #EBB618;
                font-weight: 600;
            }

            .stock-footer i {
                display: block;
                text-align: center;
                font-size: 1.35rem;
                line-height: 1;
            }

        }

    </style>

    @stack('styles')

</head>


<body>


{{-- =========================
     HEADER
========================= --}}

<header class="stock-header">

    <div class="d-flex align-items-center">

        <i class="bi bi-bar-chart-line me-3"></i>

        <div class="logo">
            {{ _('Statistics') }}
        </div>

    </div>

</header>


{{-- =========================
     MOBILE MENU BUTTON
========================= --}}

<div class="mobile-statistics-menu">

    <button class="btn w-100 text-start d-flex align-items-center"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#statisticsMenu"
            aria-controls="statisticsMenu">

        <i class="bi bi-list fs-4 me-2"></i>

        <span class="flex-grow-1">
            Statistieken
        </span>

        <i class="bi bi-chevron-right"></i>

    </button>

</div>


{{-- =========================
     MOBILE OFFCANVAS
========================= --}}

<div class="offcanvas offcanvas-start statistics-offcanvas"
     tabindex="-1"
     id="statisticsMenu"
     aria-labelledby="statisticsMenuLabel">

    <div class="offcanvas-header">

        <h5 class="offcanvas-title" id="statisticsMenuLabel">
            <i class="bi bi-bar-chart-line me-2"></i>
            Statistieken
        </h5>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Sluiten">
        </button>

    </div>


    <div class="offcanvas-body p-0">

        <div class="list-group list-group-flush">


            {{-- Dashboard --}}

            <a href="{{ route('statistics.home') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.home') ? 'active' : '' }}">

                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard

            </a>


            {{-- Analyse --}}

            <div class="list-group-item bg-light fw-bold text-uppercase small">
                Analyse
            </div>


            <a href="{{ route('statistics.revenue') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.revenue') ? 'active' : '' }}">

                <i class="bi bi-graph-up me-2"></i>
                Omzet

            </a>


            <a href="{{ route('statistics.products') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.products') ? 'active' : '' }}">

                <i class="bi bi-box-seam me-2"></i>
                Producten

            </a>


            <a href="{{ route('statistics.suppliers') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.suppliers') ? 'active' : '' }}">

                <i class="bi bi-building me-2"></i>
                Leveranciers

            </a>


            <a href="{{ route('statistics.payments') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.payments') ? 'active' : '' }}">

                <i class="bi bi-credit-card me-2"></i>
                Betalingen

            </a>


            <a href="{{ route('statistics.sales-times') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.sales-times') ? 'active' : '' }}">

                <i class="bi bi-clock-history me-2"></i>
                Verkoopmomenten

            </a>


            {{-- Administratie --}}

            <div class="list-group-item bg-light fw-bold text-uppercase small">
                Administratie
            </div>


            <a href="{{ route('statistics.vat') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.vat') ? 'active' : '' }}">

                <i class="bi bi-percent me-2"></i>
                BTW

            </a>


            <a href="{{ route('statistics.receipts') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.receipts') ? 'active' : '' }}">

                <i class="bi bi-receipt me-2"></i>
                Bonnen

            </a>


            <a href="{{ route('statistics.refunds') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.refunds') ? 'active' : '' }}">

                <i class="bi bi-arrow-return-left me-2"></i>
                Retouren

            </a>


            <a href="{{ route('statistics.reports') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.reports') ? 'active' : '' }}">

                <i class="bi bi-file-earmark-bar-graph me-2"></i>
                Rapportages

            </a>


        </div>
        <div class="border-top mt-2">

    <a href="/stock/app/logout"
       class="list-group-item list-group-item-action text-danger">

        <i class="bi bi-power me-2"></i>
        Uitloggen

    </a>

</div>

    </div>

</div>


{{-- =========================
     MAIN LAYOUT
========================= --}}

<div class="statistics-layout">


    {{-- =========================
         DESKTOP SIDEBAR
    ========================= --}}

    <aside class="statistics-sidebar d-none d-lg-block">

        <div class="list-group">


            {{-- Dashboard --}}

            <a href="{{ route('statistics.home') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.home') ? 'active' : '' }}">

                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard

            </a>


            {{-- Analyse --}}

            <div class="list-group-item bg-light fw-bold text-uppercase small">
                Analyse
            </div>


            <a href="{{ route('statistics.revenue') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.revenue') ? 'active' : '' }}">

                <i class="bi bi-graph-up me-2"></i>
                Omzet

            </a>


            <a href="{{ route('statistics.products') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.products') ? 'active' : '' }}">

                <i class="bi bi-box-seam me-2"></i>
                Producten

            </a>


            <a href="{{ route('statistics.suppliers') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.suppliers') ? 'active' : '' }}">

                <i class="bi bi-building me-2"></i>
                Leveranciers

            </a>


            <a href="{{ route('statistics.payments') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.payments') ? 'active' : '' }}">

                <i class="bi bi-credit-card me-2"></i>
                Betalingen

            </a>


            <a href="{{ route('statistics.sales-times') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.sales-times') ? 'active' : '' }}">

                <i class="bi bi-clock-history me-2"></i>
                Verkoopmomenten

            </a>


            {{-- Administratie --}}

            <div class="list-group-item bg-light fw-bold text-uppercase small">
                Administratie
            </div>


            <a href="{{ route('statistics.vat') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.vat') ? 'active' : '' }}">

                <i class="bi bi-percent me-2"></i>
                BTW

            </a>


            <a href="{{ route('statistics.receipts') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.receipts') ? 'active' : '' }}">

                <i class="bi bi-receipt me-2"></i>
                Bonnen

            </a>


            <a href="{{ route('statistics.refunds') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.refunds') ? 'active' : '' }}">

                <i class="bi bi-arrow-return-left me-2"></i>
                Retouren

            </a>


            <a href="{{ route('statistics.reports') }}"
               class="list-group-item list-group-item-action {{ request()->routeIs('statistics.reports') ? 'active' : '' }}">

                <i class="bi bi-file-earmark-bar-graph me-2"></i>
                Rapportages

            </a>


        </div>
        <div class="border-top mt-2">

    <a href="/stock/app/logout"
       class="list-group-item list-group-item-action text-danger">

        <i class="bi bi-power me-2"></i>
        Uitloggen

    </a>

</div>

    </aside>


    {{-- =========================
         CONTENT
    ========================= --}}

    <main class="statistics-content">

        <div class="stock-container">

            {{ $slot }}

        </div>

    </main>


</div>


{{-- =========================
     MOBILE BOTTOM NAVIGATION
========================= --}}

{{-- =========================
     MOBILE BOTTOM NAVIGATION
========================= --}}

<footer class="stock-footer">

    <a href="{{ route('statistics.home') }}"
       class="{{ request()->routeIs('statistics.home') ? 'active' : '' }}">

        <i class="bi bi-speedometer2"></i>

        <span>
            Dashboard
        </span>

    </a>


    <a href="{{ route('statistics.revenue') }}"
       class="{{ request()->routeIs('statistics.revenue') ? 'active' : '' }}">

        <i class="bi bi-graph-up"></i>

        <span>
            Omzet
        </span>

    </a>


    <a href="{{ route('statistics.products') }}"
       class="{{ request()->routeIs('statistics.products') ? 'active' : '' }}">

        <i class="bi bi-box-seam"></i>

        <span>
            Producten
        </span>

    </a>


    <a href="{{ route('statistics.payments') }}"
       class="{{ request()->routeIs('statistics.payments') ? 'active' : '' }}">

        <i class="bi bi-credit-card"></i>

        <span>
            Betalingen
        </span>

    </a>

</footer>


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@livewireScripts

@stack('scripts')


</body>
</html>