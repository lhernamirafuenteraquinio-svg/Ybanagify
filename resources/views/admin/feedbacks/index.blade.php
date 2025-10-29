@extends('layouts.Admin.app')

@section('content')
@can('admin-access')
	<div class="head-title">
		<div class="left">
			<h1>Feedbacks</h1>
			<ul class="breadcrumb">
				<li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        Home
                    </a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a href="{{ route('admin.feedbacks.index') }}" class="{{ request()->routeIs('admin.feedbacks.index') ? 'active' : '' }}">
                        Feedbacks
                    </a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a href="{{ route('admin.feedbacks.archived') }}" class="{{ request()->routeIs('admin.feedbacks.archived') ? 'active' : '' }}">
                        Archived Feedbacks
                    </a>
                </li>
			</ul>
		</div>
    </div>

    <div class="table-data">
    <div class="order">
        <div class="head">
            <h3>All Feedbacks ({{ $feedbacks->total() }})</h3>
        </div>

                {{-- Success Alert --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Feedback Table --}}
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Category</th>
                                <th>Message</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feedbacks as $feedback)
                                <tr>
                                    <td>{{ $feedback->name }}</td>
                                    <td>
                                        <a href="mailto:{{ $feedback->email }}">{{ $feedback->email }}</a>
                                    </td>
                                    <td>{{ $feedback->category ?? 'General' }}</td>
                                    <td>{{ Str::limit($feedback->message, 50) }}</td>
                                    <td>{{ $feedback->created_at->diffForHumans() }}</td>
                                    <td class="d-flex gap-2">
                                        {{-- Archive Button instead of Delete --}}
                                        <form action="{{ route('admin.feedbacks.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to archive this feedback?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-warning btn-sm" type="submit">
                                                <i class='bx bx-archive'></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No feedback messages found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $feedbacks->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@else
    <div class="p-6 text-red-600">
        <p>You do not have permission to view this page.</p>
    </div>
@endcan
@endsection
