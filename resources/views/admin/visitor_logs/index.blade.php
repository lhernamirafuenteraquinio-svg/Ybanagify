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
            <div class="head">
                <h3>All Logs ({{ $logs->total() }})</h3>
            </div>

            <!-- 🔍 Search Form -->
            <form class="row g-2 mb-3" method="GET" action="{{ route('admin.visitor_logs.index') }}">
                <div class="col-md-4">
                    <input 
                        type="text" 
                        name="ip" 
                        class="form-control" 
                        placeholder="Search by IP" 
                        value="{{ request('ip') }}"
                    >
                </div>
                <div class="col-md-4">
                    <select name="action" class="form-select">
                        <option value="">-- Filter by Action --</option>
                        <option value="dictionary" {{ request('action') == 'dictionary' ? 'selected' : '' }}>Ybanag Words</option>
                        <option value="translator" {{ request('action') == 'translator' ? 'selected' : '' }}>Translator</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('admin.visitor_logs.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>IP Address</th>
                        <th>Action</th>
                        <!-- <th>User Agent</th> -->
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                    <tr>
                        <td>{{ $log->ip_address }}</td>
                        <td>
                            @foreach(explode(',', $log->actions) as $action)
                                <span class="badge bg-primary">{{ ucfirst($action) }}</span>
                            @endforeach
                        </td>
                        <!-- <td>
                            @foreach(explode(',', $log->user_agents) as $ua)
                                <div style="word-break: break-word;">{{ $ua }}</div>
                            @endforeach
                        </td> -->
                        <td>{{ \Carbon\Carbon::parse($log->last_visit)->format('M d, Y h:i A') }}</td>
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

@endsection
@endcan
