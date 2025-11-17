@can('admin-access')
@extends('layouts.Admin.app')

@section('content')
	<div class="head-title">
		<div class="left">
			<h1>Visitor Logs</h1>
			<ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="{{ route('admin.visitor_logs.index') }}">Visitor Logs</a>
                </li>
            </ul>
		</div>
	</div>

    <div class="table-data">
        <div class="order">

            <div class="head d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h3 class="mb-0">All Logs ({{ $logs->total() }})</h3>

                <div class="dropdown">
                    <button class="filter-btn d-flex align-items-center gap-1" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class='bx bx-filter-alt'></i>
                        <span>
                            @if(request('action') == 'dictionary')
                                Dictionary
                            @elseif(request('action') == 'translator')
                                Translator
                            @else
                                Filter by Action
                            @endif
                        </span>
                        <i class='bx bx-chevron-down'></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="filterDropdown">
                        <li>
                            <a class="dropdown-item {{ request('action') == '' ? 'active' : '' }}" href="{{ route('admin.visitor_logs.index') }}">
                                All Actions
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('action') == 'dictionary' ? 'active' : '' }}" href="{{ route('admin.visitor_logs.index', ['action' => 'dictionary']) }}">
                                Dictionary
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('action') == 'translator' ? 'active' : '' }}" href="{{ route('admin.visitor_logs.index', ['action' => 'translator']) }}">
                                Translator
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>IP Address</th>
                        <th>Action</th>
                        <!-- <th>User Agent</th> -->
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                    <tr>
                        <td>{{ $log->ip_address }}</td>
                        <td>
                            @foreach(explode(',', $log->actions) as $action)
                                @php
                                    $label = ($action == 'dictionary') ? 'Dictionary' : ucfirst($action);
                                @endphp
                                <span class="badge bg-primary">{{ $label }}</span>
                            @endforeach
                        </td>
                        <!-- <td>
                            @foreach(explode(',', $log->user_agents) as $ua)
                                <div style="word-break: break-word;">{{ $ua }}</div>
                            @endforeach
                        </td> -->
                        <td>{{ \Carbon\Carbon::parse($log->last_visit)->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No visitor logs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $logs->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- ✅ Styles -->
<style>
    .filter-btn {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 6px 14px;
        cursor: pointer;
        font-size: 0.95rem;
        transition: all 0.2s ease-in-out;
    }
    .filter-btn:hover {
        border-color: #86b7fe;
        background-color: #f8f9fa;
    }

    .dropdown-menu {
        border-radius: 10px;
        font-size: 0.9rem;
    }
    .dropdown-item.active, 
    .dropdown-item:active {
        background-color: #0d6efd;
        color: #fff;
    }
    .dropdown-item:hover {
        background-color: #e9ecef;
    }

    .toggle-action-btn {
        width: 34px !important;
        height: 34px !important;
        transition: transform 0.2s ease-in-out;
    }
    .toggle-action-btn:hover {
        transform: scale(1.1);
        background-color: #d1e7dd !important;
    }
</style>

@endsection
@endcan
