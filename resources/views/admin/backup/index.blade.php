@extends('layouts.Admin.app')

@section('content')
@can('admin-access')

<div class="head-title mb-4">
    <div class="left">
        <h1>Backup & Maintenance</h1>
        <ul class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li><a class="active" href="{{ route('admin.backup.index') }}">Backup & Maintenance</a></li>
        </ul>
    </div>
</div>

{{-- Alerts --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif


{{-- Action Buttons --}}
<div class="mb-4 d-flex flex-wrap gap-3">
    <form action="{{ route('admin.backup.run') }}" method="POST" class="flex-fill">
        @csrf
        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
            <i class="bi bi-arrow-clockwise me-2"></i> Create Backup Now
        </button>
    </form>

    <!-- <form action="{{ route('admin.backup.clean') }}" method="POST" class="flex-fill">
        @csrf
        <button type="submit" class="btn btn-danger w-100 fw-bold py-2">
            <i class="bi bi-trash me-2"></i> Delete All Backups
        </button>
    </form> -->
</div>

{{-- Backup List --}}
<div class="card shadow-sm mb-5">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-folder2-open me-2"></i>Available Backups</h5>
        <span class="badge bg-light text-dark">{{ count($backups) }} file(s)</span>
    </div>

    <div class="card-body p-0">
        @if(count($backups) == 0)
        <p class="text-center text-muted py-4 mb-0">No backups found.</p>
        @else
        <ul class="list-group list-group-flush">
            @foreach($backups as $file)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-file-earmark-text me-2"></i>{{ basename($file) }}
                </div>
                <a href="{{ route('admin.backup.download', basename($file)) }}" download class="btn btn-sm btn-success"
                    onclick="setTimeout(() => location.reload(), 1500)">
                    <i class="bi bi-download me-1"></i> Download
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
</div>



{{-- ===================== --}}
{{-- 🔧 MAINTENANCE PANEL --}}
{{-- ===================== --}}

<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="bi bi-gear-wide-connected me-2"></i>System Maintenance</h5>
    </div>

    <div class="card-body">

        {{-- Maintenance Metrics --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4 flex-fill">
                <div class="border rounded p-3">
                    <h6 class="fw-bold">Storage Usage</h6>
                    <p class="text-muted">Used: <span id="storage-used">Loading...</span></p>
                </div>
            </div>

            <div class="col-md-4 flex-fill">
                <div class="border rounded p-3">
                    <h6 class="fw-bold">Database Health</h6>
                    <p class="text-muted" id="db-status">Checking...</p>
                </div>
            </div>
        </div>

        {{-- Maintenance Buttons --}}
        <div class="d-flex flex-column gap-3 mb-3">

            <div class="d-flex flex-wrap gap-2">
                <form action="{{ route('admin.maintenance.clearLogs') }}" method="POST" class="flex-fill">
                    @csrf
                    <button class="btn btn-danger fw-bold w-100">
                        <i class="bi bi-journal-x me-1"></i> Clear Logs
                    </button>
                </form>

                <form action="{{ route('admin.maintenance.clearCache') }}" method="POST" class="flex-fill">
                    @csrf
                    <button class="btn btn-warning fw-bold w-100">
                        <i class="bi bi-lightning-charge me-1"></i> Clear Cache
                    </button>
                </form>

                <form action="{{ route('admin.maintenance.optimize') }}" method="POST" class="flex-fill">
                    @csrf
                    <button class="btn btn-primary fw-bold w-100">
                        <i class="bi bi-cpu me-1"></i> Optimize System
                    </button>
                </form>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-secondary fw-bold flex-fill" onclick="checkStorage()">
                    <i class="bi bi-hdd-stack me-1"></i> Check Storage
                </button>

                <button class="btn btn-secondary fw-bold flex-fill" onclick="checkDB()">
                    <i class="bi bi-database-check me-1"></i> Check Database
                </button>
            </div>

        </div>

        <pre id="maintenance-output"
             class="bg-black text-success p-3 rounded"
             style="height: 150px; overflow-y:auto;">
System log ready...
        </pre>

    </div>
</div>


{{-- SYSTEM INFORMATION --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>System Information</h5>
    </div>

    <div class="card-body">
        <p>PHP Version: <strong>{{ $systemInfo['php'] }}</strong></p>
        <p>Laravel Version: <strong>{{ $systemInfo['laravel'] }}</strong></p>
        <p>Server OS: <strong>{{ $systemInfo['os'] }}</strong></p>
        <p>Upload Limit: <strong>{{ $systemInfo['upload_limit'] }}</strong></p>
    </div>
</div>

{{-- Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


{{-- Maintenance AJAX Scripts --}}
<script>
    function checkStorage() {
        fetch("{{ route('admin.maintenance.storage') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById("maintenance-output").textContent =
                "Storage Used: " + data.total_mb + " MB";
            document.getElementById("storage-used").textContent =
                data.total_mb + " MB";
        });
    }

    function checkDB() {
        fetch("{{ route('admin.maintenance.db') }}", {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById("maintenance-output").textContent =
                "Database Status: " + data;
            document.getElementById("db-status").textContent = data;
        });
    }

    checkStorage();
    checkDB();
</script>

@endcan
@endsection