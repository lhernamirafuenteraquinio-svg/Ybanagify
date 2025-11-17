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
                    Dictionary
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>All Entries ({{ $entries->total() }})</h3>
            
            <!-- ✅ Search form -->
            <form id="search-form" class="d-flex mt-2 mt-sm-0" role="search">
                <input type="text" 
                       id="search-input"
                       name="search" 
                       class="form-control me-2" 
                       placeholder="Search Filipino or Ybanag..." 
                       style="max-width: 250px;">
                <button class="btn btn-secondary" type="submit">
                    <i class='bx bx-search'></i>
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
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
                    <th>Part of Speech</th>
                    <th>Tagalog Meaning</th>
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
                        <td>{{ $entry->part_of_speech ?? '-' }}</td>
                        <td>{{ $entry->tagalog_meaning ?? '-' }}</td>
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

<script>
document.getElementById('search-form').addEventListener('submit', async function (e) {
    e.preventDefault();
    const query = document.getElementById('search-input').value;

    const response = await fetch(`{{ route('admin.entries.index') }}?search=${encodeURIComponent(query)}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });

    const html = await response.text();

    // Extract only the table body from returned HTML
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const newTbody = doc.querySelector('tbody');
    
    document.querySelector('tbody').innerHTML = newTbody.innerHTML;
});
</script>

<!-- Create Modal -->
@include('admin.entries.partials.create-modal')

@endsection
@endcan
