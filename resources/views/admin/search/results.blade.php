@can('admin-access')
@extends('layouts.Admin.app')

@section('content')
<div class="head-title">
    <div class="left">
    <h1>Search Results for "<span id="search-query">{{ $query }}</span>"</h1>
</div>

<div class="table-data" id="search-results">

    {{-- Check if all results are empty --}}
    @if($entries->isEmpty() && $dictionaries->isEmpty() && $translations->isEmpty())
        <div class="alert alert-warning">
            No results found for "{{ $query }}".
        </div>
    @else

        {{-- ENTRIES --}}
        @if(!$entries->isEmpty())
            <h3 class="mt-3">Entries</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Filipino</th>
                        <th>Ybanag</th>
                        <th>Pronunciation</th>
                        <th>Audio</th>
                        <th>English Example</th>
                        <th>Filipino Example</th>
                        <th>Ybanag Example</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entries as $entry)
                        <tr>
                            <td>{!! str_ireplace($query, "<mark>{$query}</mark>", $entry->filipino_word) !!}</td>
                            <td>{!! str_ireplace($query, "<mark>{$query}</mark>", $entry->ybanag_translation) !!}</td>
                            <td>{{ $entry->pronunciation ?? '-' }}</td>
                            <td>
                                @if($entry->pronunciation_audio)
                                    <audio controls style="width:100px;">
                                        <source src="{{ asset('storage/' . $entry->pronunciation_audio) }}" type="audio/mpeg">
                                    </audio>
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $entry->english_example_sentence ?? '-' }}</td>
                            <td>{{ $entry->filipino_example_sentence ?? '-' }}</td>
                            <td>{{ $entry->ybanag_example_sentence ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $entries->appends(request()->all())->links('pagination::bootstrap-5') }}
        @endif

        {{-- DICTIONARY --}}
        @if(!$dictionaries->isEmpty())
            <h3 class="mt-4">Ybanag Words</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Filipino</th>
                        <th>Ybanag</th>
                        <th>Pronunciation</th>
                        <th>English Example</th>
                        <th>Filipino Example</th>
                        <th>Ybanag Example</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dictionaries as $dict)
                        <tr>
                            <td>{!! str_ireplace($query, "<mark>{$query}</mark>", $dict->filipino_word) !!}</td>
                            <td>{!! str_ireplace($query, "<mark>{$query}</mark>", $dict->ybanag_translation) !!}</td>
                            <td>{{ $dict->pronunciation ?? '-' }}</td>
                            <td>{{ $dict->english_example_sentence ?? '-' }}</td>
                            <td>{{ $dict->filipino_example_sentence ?? '-' }}</td>
                            <td>{{ $dict->ybanag_example_sentence ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $dictionaries->appends(request()->all())->links('pagination::bootstrap-5') }}
        @endif

        {{-- TRANSLATIONS --}}
        @if(!$translations->isEmpty())
            <h3 class="mt-4">Translations</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Filipino</th>
                        <th>Ybanag</th>
                        <th>Audio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($translations as $trans)
                        <tr>
                            <td>{!! str_ireplace($query, "<mark>{$query}</mark>", $trans->filipino_word) !!}</td>
                            <td>{!! str_ireplace($query, "<mark>{$query}</mark>", $trans->ybanag_translation) !!}</td>
                            <td>
                                @if($trans->pronunciation_audio)
                                    <audio controls style="width:100px;">
                                        <source src="{{ asset('storage/' . $trans->pronunciation_audio) }}" type="audio/mpeg">
                                    </audio>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $translations->appends(request()->all())->links('pagination::bootstrap-5') }}
        @endif

    @endif

</div>
@endsection
@endcan