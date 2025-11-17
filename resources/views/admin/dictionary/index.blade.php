@extends('layouts.Admin.app')

@section('content')
@can('admin-access')

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

        <!-- ✅ HEADER SECTION with FILTER BUTTON -->
        <div class="head d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h3 class="mb-0">All Dictionary Entries ({{ $entries->total() }})</h3>

            <!-- Filter dropdown -->
            <div class="dropdown">
                <button class="filter-btn d-flex align-items-center gap-1" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-filter-alt'></i> 
                    <span>
                        @if(request('visibility') == 'visible')
                            Visible Only
                        @elseif(request('visibility') == 'hidden')
                            Hidden Only
                        @else
                            All Visibility
                        @endif
                    </span>
                    <i class='bx bx-chevron-down'></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item {{ request('visibility') == '' ? 'active' : '' }}" href="{{ route('admin.dictionary.index') }}">All Visibility</a></li>
                    <li><a class="dropdown-item {{ request('visibility') == 'visible' ? 'active' : '' }}" href="{{ route('admin.dictionary.index', ['visibility' => 'visible']) }}">Visible Only</a></li>
                    <li><a class="dropdown-item {{ request('visibility') == 'hidden' ? 'active' : '' }}" href="{{ route('admin.dictionary.index', ['visibility' => 'hidden']) }}">Hidden Only</a></li>
                </ul>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        <!-- ✅ TABLE -->
        <table>
            <thead>
                <tr>
                    <th>Filipino</th>
                    <th>Ybanag</th>
                    <th>Pronunciation</th>
                    <th>Part of Speech</th>
                    <th>Tagalog Meaning</th>
                    <!-- <th>English Example</th>
                    <th>Filipino Example</th>
                    <th>Ybanag Example</th> -->
                    <th>Visibility</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($entries as $entry)
                    <tr id="entry-{{ $entry->id }}">
                        <td>{{ $entry->filipino_word }}</td>
                        <td>{{ $entry->ybanag_translation }}</td>
                        <td><em>{{ $entry->pronunciation ?? '-' }}</em></td>
                        <td>{{ $entry->part_of_speech ?? '-' }}</td>
                        <td>{{ $entry->tagalog_meaning ?? '-' }}</td>
                        <!-- <td>{{ $entry->english_example_sentence ?? '-' }}</td>
                        <td>{{ $entry->filipino_example_sentence ?? '-' }}</td>
                        <td>{{ $entry->ybanag_example_sentence ?? '-' }}</td> -->
                        <td class="text-center">
                            <button 
                                class="toggle-visibility-btn border-0 rounded-circle d-flex align-items-center justify-content-center"
                                data-id="{{ $entry->id }}"
                                title="{{ $entry->is_visible ? 'Hide Entry' : 'Show Entry' }}"
                                style="width: 38px; height: 38px; background-color: {{ $entry->is_visible ? '#e8f5e9' : '#f5f5f5' }}; transition: 0.3s;"
                            >
                                @if ($entry->is_visible)
                                    <i class='bx bx-show text-success' style="font-size: 22px;"></i>
                                @else
                                    <i class='bx bx-hide text-secondary' style="font-size: 22px;"></i>
                                @endif
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Ybanag Words entries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $entries->links() }}
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

    .toggle-visibility-btn {
        width: 34px !important;
        height: 34px !important;
        transition: transform 0.2s ease-in-out;
    }
    .toggle-visibility-btn:hover {
        transform: scale(1.1);
        background-color: #d1e7dd !important;
    }
</style>

<!-- ✅ JS for toggling visibility -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-visibility-btn').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;

            fetch(`/admin/dictionary/${id}/toggle-visibility`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const icon = this.querySelector('i');
                    if (data.is_visible) {
                        icon.classList.remove('bx-hide', 'text-secondary');
                        icon.classList.add('bx-show', 'text-success');
                        this.style.backgroundColor = '#e8f5e9';
                        this.title = 'Hide Entry';
                    } else {
                        icon.classList.remove('bx-show', 'text-success');
                        icon.classList.add('bx-hide', 'text-secondary');
                        this.style.backgroundColor = '#f5f5f5';
                        this.title = 'Show Entry';
                    }
                }
            });
        });
    });
});
</script>

@endcan
@endsection
