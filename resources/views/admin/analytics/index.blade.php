@extends('layouts.Admin.app')

@section('content')
@can('admin-access')
<div class="head-title">
    <div class="left">
        <h1>Analytics</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Home
                </a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a href="{{ route('admin.analytics') }}" class="{{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                    Analytics
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Charts Section -->
<div class="table-data">
    <div class="order">
        <div class="row g-4">
            <p>Visual overview of system performance and usage statistics</p>
            <!-- Entries Chart -->
            <div class="col-lg-6 col-md-12">
                <div class="card dashboard-card shadow-sm border-0 rounded-4 hover-scale">
                    <div class="card-body">
                        <h5 class="text-center fw-semibold mb-3 text-dark">Entries Comparison</h5>
                        <canvas id="entriesChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- Visitors Chart -->
            <div class="col-lg-6 col-md-12">
                <div class="card dashboard-card shadow-sm border-0 rounded-4 hover-scale">
                    <div class="card-body">
                        <h5 class="text-center fw-semibold mb-3 text-dark">Monthly Visitors</h5>
                        <canvas id="visitorChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- Most Used Ybanag Words -->
            <div class="col-lg-6 col-md-12">
                <div class="card dashboard-card shadow-sm border-0 rounded-4 hover-scale">
                    <div class="card-body">
                        <h5 class="text-center fw-semibold mb-3 text-dark">Most Translated Ybanag Words</h5>
                        <canvas id="topYbanagChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- System Overview -->
            <div class="col-lg-6 col-md-12">
                <div class="card dashboard-card shadow-sm border-0 rounded-4 hover-scale">
                    <div class="card-body">
                        <h5 class="text-center fw-semibold mb-3 text-dark">System Overview</h5>
                        <canvas id="systemChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- Submission Status -->
            <div class="col-lg-6 col-md-12">
                <div class="card dashboard-card shadow-sm border-0 rounded-4 hover-scale">
                    <div class="card-body">
                        <h5 class="text-center fw-semibold mb-3 text-dark">Submission Status</h5>
                        <canvas id="submissionStatusChart" height="250"></canvas>
                    </div>
                </div>
            </div>

        </div> <!-- end row -->
    </div> <!-- end order -->
</div> <!-- end table-data -->
@endcan
@endsection

@push('styles')
<style>
/* ===== Dashboard Aesthetics ===== */
.dashboard-card {
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fc 100%);
    transition: all 0.3s ease;
    min-height: 380px;
}
.dashboard-card:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

/* Subtle hover lift */
.hover-scale {
    transition: transform 0.3s ease;
}
.hover-scale:hover {
    transform: translateY(-6px);
}

/* Chart entry animation */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
.card-body {
    animation: fadeUp 0.7s ease forwards;
}

/* Text Styles */
h5 {
    color: #343a40;
}
.text-primary {
    color: #4e73df !important;
}
.breadcrumb-item a:hover {
    text-decoration: underline;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const chartOptions = {
    responsive: true,
    plugins: {
        legend: { position: 'bottom', labels: { boxWidth: 15, padding: 15 } },
        tooltip: { mode: 'index', intersect: false }
    },
    interaction: { mode: 'nearest', axis: 'x', intersect: false },
    scales: { y: { beginAtZero: true, ticks: { color: '#6c757d' } } }
};

// Pie Chart – Entries
new Chart(document.getElementById('entriesChart'), {
    type: 'pie',
    data: {
        labels: ['Translations', 'Dictionary'],
        datasets: [{
            data: [{{ $translationCount }}, {{ $dictionaryCount }}],
            backgroundColor: ['#4e73df', '#1cc88a'],
            hoverOffset: 8
        }]
    },
    options: chartOptions
});

// Line Chart – Monthly Visitors
new Chart(document.getElementById('visitorChart'), {
    type: 'line',
    data: {
        labels: @json($months),
        datasets: [{
            label: 'Visitors',
            data: @json($visitorData),
            borderColor: '#f6c23e',
            backgroundColor: 'rgba(246,194,62,0.15)',
            fill: true,
            tension: 0.4,
            borderWidth: 2,
            pointRadius: 4
        }]
    },
    options: chartOptions
});

// Bar Chart – Top Ybanag Words
new Chart(document.getElementById('topYbanagChart'), {
    type: 'bar',
    data: {
        labels: @json($ybanagLabels),
        datasets: [{
            label: 'Times Used',
            data: @json($ybanagData),
            backgroundColor: '#36b9cc',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            y: { beginAtZero: true, ticks: { color: '#6c757d', precision:0 } },
            x: { ticks: { color: '#6c757d' } }
        }
    }
});

// Bar Chart – System Overview
new Chart(document.getElementById('systemChart'), {
    type: 'bar',
    data: {
        labels: ['Translations', 'Dictionary', 'Visitors'],
        datasets: [{
            label: 'Total Count',
            data: [{{ $translationCount }}, {{ $dictionaryCount }}, {{ $visitorLogCount }}],
            backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e'],
            borderRadius: 8
        }]
    },
    options: chartOptions
});

// Doughnut Chart – Submission Status
new Chart(document.getElementById('submissionStatusChart'), {
    type: 'doughnut',
    data: {
        labels: @json($submissionStatus->keys()),
        datasets: [{
            data: @json($submissionStatus->values()),
            backgroundColor: ['#f6c23e', '#1cc88a', '#e74a3b']
        }]
    },
    options: chartOptions
});
</script>
@endpush
