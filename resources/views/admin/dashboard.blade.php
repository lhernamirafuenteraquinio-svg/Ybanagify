@can('admin-access')
@extends('layouts.Admin.app')

@section('content')
	<div class="head-title">
		<div class="left">
			<h1>Dashboard</h1>
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

	<ul class="box-info">
		<li>
			<i class='bx bx-book'></i>
			<span class="text">
				<h3>{{ $totalEntries }}</h3>
				<p>Total Entries</p>
			</span>
		</li>
		<li>
			<i class='bx bx-globe'></i>
			<span class="text">
				<h3>{{ $visitorLogCount }}</h3>
				<p>Total Logs</p>
			</span>
		</li>
		<li>
			<i class='bx bx-chat'></i>
			<span class="text">
				<h3>{{ $feedbackCount }}</h3>
				<p>Feedback</p>
			</span>
		</li>
	</ul>

	<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Recent Additions</h3>
				
			</div>
			<table>
				<thead>
					<tr>
						<th>Filipino</th>
						<th>Ybanag</th>
						<th>Added By</th>
						<th>Entry Type</th>
						<th>Time</th>
					</tr>
				</thead>
                <tbody>
				@forelse ($recentAdditions as $entry)
					<tr>
						<td>{{ $entry['filipino'] }}</td>
						<td>{{ $entry['ybanag'] }}</td>
						<td>{{ $entry['added_by'] }}</td>
						<td>{{ $entry['entry_type'] }}</td>
						<td>{{ \Carbon\Carbon::parse($entry['created_at'])->diffForHumans() }}</td>
					</tr>
				@empty
					<tr>
						<td colspan="5" class="text-center">No recent additions.</td>
					</tr>
				@endforelse
			</tbody>
			</table>
		</div>

		<div class="todo">
			<div class="head">
				<h3>Admin Tasks</h3>
			
			</div>
			<ul class="todo-list">
				<li class="not-completed">
					<p>Review flagged words</p>
				
				</li>
				<li class="completed">
					<p>Backup database</p>
			
				</li>
				<li class="not-completed">
					<p>Add new audio recordings</p>
					
				</li>
                 <li class="completed">
                    <p>Monitor visitor logs</p>
                   
                </li>
			</ul>
		</div>
	</div>
@endsection
@endcan
