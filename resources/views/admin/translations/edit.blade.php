@can('admin-access')
    @extends('layouts.Admin.app')

    @section('content')
    <div class="container">
        <h2>Edit Translation</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> There were issues with the form submission.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.translations.update', $translation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="filipino_word" class="form-label">Filipino Word</label>
                <input type="text" name="filipino_word" value="{{ $translation->filipino_word }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="ybanag_translation" class="form-label">Ybanag Translation</label>
                <input type="text" name="ybanag_translation" value="{{ $translation->ybanag_translation }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="pronunciation_audio" class="form-label">Pronunciation Audio (optional)</label>
                <input type="file" name="pronunciation_audio" class="form-control">
                
                @if ($translation->pronunciation_audio)
                    <div class="mt-2">
                        <p>Current file:</p>
                        <!-- Audio player with controls -->
                        <audio controls>
                            <source src="{{ asset('storage/' . $translation->pronunciation_audio) }}" type="audio/mpeg">
                            Your browser does not support the audio tag.
                        </audio>
                        <p class="mt-1">File Name: {{ basename($translation->pronunciation_audio) }}</p>
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-success">Update Translation</button>
        </form>
    </div>
    @endsection
@endcan
