<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Dashboard</h1>
            <div class="text-muted">
                Overzicht van de verkopen
            </div>
        </div>

        <div class="text-muted">
            {{ now()->translatedFormat('l d F Y') }}
        </div>
    </div>


    {{-- Omzet --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">
                        Omzet vandaag
                    </div>

                    <div class="fs-3 fw-bold">
                        € {{ number_format($todayIncome, 2, ',', '.') }}
                    </div>

                    <div class="small text-muted mt-2">
                        {{ $todayCount }} {{ $todayCount == 1 ? 'bon' : 'bonnen' }}
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">
                        Omzet deze week
                    </div>

                    <div class="fs-3 fw-bold">
                        € {{ number_format($weekIncome, 2, ',', '.') }}
                    </div>

                    <div class="small text-muted mt-2">
                        {{ $weekCount }} {{ $weekCount == 1 ? 'bon' : 'bonnen' }}
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">
                        Omzet deze maand
                    </div>

                    <div class="fs-3 fw-bold">
                        € {{ number_format($monthIncome, 2, ',', '.') }}
                    </div>

                    <div class="small text-muted mt-2">
                        {{ $monthCount }} {{ $monthCount == 1 ? 'bon' : 'bonnen' }}
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- Extra statistieken --}}
    <div class="row g-3 mb-4">

        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <div class="text-muted small mb-2">
                        Gemiddelde bon deze maand
                    </div>

                    <div class="fs-3 fw-bold">
                        € {{ number_format($averageReceipt, 2, ',', '.') }}
                    </div>

                </div>
            </div>
        </div>


        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <div class="text-muted small mb-2">
                        Aantal verkopen deze maand
                    </div>

                    <div class="fs-3 fw-bold">
                        {{ number_format($monthCount, 0, ',', '.') }}
                    </div>

                </div>
            </div>
        </div>

    </div>


    {{-- Grafiek --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-1">Omzet</h5>
                    <div class="text-muted small">
                        Omzet van de afgelopen 30 dagen
                    </div>
                </div>
            </div>

            <div style="height: 350px;">
                <canvas id="dashboardRevenueChart"></canvas>
            </div>

        </div>
    </div>
</div>