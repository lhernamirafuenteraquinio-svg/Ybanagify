@can('admin-access') 
@extends('layouts.Admin.app')

@section('content')
<div class="container">
    <h2>Edit Ybanag Words Entry</h2>

    <form action="{{ route('admin.dictionary.update', $dictionary->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="filipino_word" class="form-label">Filipino Word</label>
            <input type="text" name="filipino_word" class="form-control" id="filipino_word" value="{{ old('filipino_word', $dictionary->filipino_word) }}" required>
        </div>

        <div class="mb-3">
            <label for="ybanag_translation" class="form-label">Ybanag Translation</label>
            <input type="text" name="ybanag_translation" class="form-control" id="ybanag_translation" value="{{ old('ybanag_translation', $dictionary->ybanag_translation) }}" required>
        </div>

        <div class="mb-3">
            <label for="pronunciation" class="form-label">Pronunciation</label>
            <input type="text" name="pronunciation" class="form-control" id="pronunciation" value="{{ old('pronunciation', $dictionary->pronunciation) }}">
        </div>

        <div class="mb-3">
            <label for="english_example_sentence" class="form-label">English Example Sentence</label>
            <textarea name="english_example_sentence" class="form-control" id="english_example_sentence" rows="2">{{ old('english_example_sentence', $dictionary->english_example_sentence) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="filipino_example_sentence" class="form-label">Filipino Example Sentence</label>
            <textarea name="filipino_example_sentence" class="form-control" id="filipino_example_sentence" rows="2">{{ old('filipino_example_sentence', $dictionary->filipino_example_sentence) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="ybanag_example_sentence" class="form-label">Ybanag Example Sentence</label>
            <textarea name="ybanag_example_sentence" class="form-control" id="ybanag_example_sentence" rows="2">{{ old('ybanag_example_sentence', $dictionary->ybanag_example_sentence) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Entry</button>
    </form>
</div>
@endsection
@endcan
