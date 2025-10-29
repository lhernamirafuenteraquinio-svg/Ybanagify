@can('admin-access')
@extends('layouts.Admin.app')

@section('content')
<div class="head-title">
    <div class="left">
        <h1>Manage Entries</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Home
                </a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a href="{{ route('admin.entries.index') }}" class="{{ request()->routeIs('admin.entries.index') ? 'active' : '' }}">
                    Entries
                </a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a href="{{ route('admin.translations.index') }}" class="{{ request()->routeIs('admin.translations.index') ? 'active' : '' }}">
                    Translation
                </a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a href="{{ route('admin.dictionary.index') }}" class="{{ request()->routeIs('admin.dictionary.index') ? 'active' : '' }}">
                    Ybanag Words
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>All Entries ({{ $entries->total() }})</h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <!-- Add New Entry button -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class='bx bx-plus-circle'></i> Add New Entry
        </button>

        <!-- Entries table -->
        <table>
            <thead>
                <tr>
                    <th>Filipino</th>
                    <th>Ybanag</th>
                    <th>Pronunciation</th>
                    <th>Audio</th>
                    <th>English Example</th>
                    <th>Filipino Example</th>
                    <th>Ybanag Example</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($entries as $entry)
                    <tr>
                        <td>{{ $entry->filipino_word }}</td>
                        <td>{{ $entry->ybanag_translation }}</td>
                        <td><em>{{ $entry->pronunciation ?? '-' }}</em></td>
                        <td>
                            @if ($entry->pronunciation_audio)
                                <audio controls style="width: 100px;">
                                    <source src="{{ asset('storage/' . $entry->pronunciation_audio) }}" type="audio/mpeg">
                                </audio>
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $entry->english_example_sentence ?? '-' }}</td>
                        <td>{{ $entry->filipino_example_sentence ?? '-' }}</td>
                        <td>{{ $entry->ybanag_example_sentence ?? '-' }}</td>
                        <td class="d-flex gap-1">
                            <!-- Edit -->
                            <button 
                                class="btn btn-warning btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal-{{ $entry->id }}">
                                <i class='bx bx-edit'></i>
                            </button>

                            <!-- Delete -->
                            <form action="{{ route('admin.entries.destroy', $entry->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    @include('admin.entries.partials.edit-modal', ['entry' => $entry])
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No entries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $entries->links() }}
        </div>
    </div>
</div>

<!-- Create Modal -->
@include('admin.entries.partials.create-modal')

@endsection
@endcan
