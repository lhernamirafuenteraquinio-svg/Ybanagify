@extends('layouts.Admin.app')

@section('content')
@can('admin-access')
	<div class="head-title">
		<div class="left">
			<h1>Submissions</h1>
			<ul class="breadcrumb">
				<li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        Home
                    </a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a href="{{ route('admin.submissions.index') }}" class="{{ request()->routeIs('admin.submissions.index') ? 'active' : '' }}">
                        Submissions
                    </a>
                </li>
			</ul>
		</div>
	</div>

    <div class="table-data">
    <div class="order">
        <div class="head">
            <h3>All Submissions ({{ $submissions->total() }})</h3>
        </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Filipino Word</th>
                                <th>Ybanag Translation</th>
                                <th>Submitted By</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Submitted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $submission)
                            <tr>
                                <td>{{ $submission->filipino_word }}</td>
                                <td>{{ $submission->ybanag_translation }}</td>
                                <td>{{ $submission->submitted_by ?? '-' }}</td>
                                <td>{{ $submission->submitted_email ?? '-' }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $submission->status === 'pending' ? 'bg-warning text-dark' : 
                                           ($submission->status === 'approved' ? 'bg-success' : 'bg-danger') }}">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </td>
                                <td>{{ $submission->created_at->diffForHumans() }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        @if($submission->status === 'pending')
                                            <form method="POST" action="{{ route('admin.submissions.approve', $submission->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm d-flex align-items-center gap-1">
                                                    <i class='bx bx-check'></i>
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.submissions.reject', $submission->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1">
                                                    <i class='bx bx-x'></i> 
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small fst-italic">No actions</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">No submissions found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $submissions->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endcan
@endsection
