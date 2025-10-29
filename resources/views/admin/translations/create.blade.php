@can('admin-access')
    @extends('layouts.Admin.app')

    @section('content')
    <div class="container">
        <h2>Add New Translation</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> May mga error sa form:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.translations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="filipino_word" class="form-label">Filipino Word</label>
                <input type="text" name="filipino_word" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="ybanag_translation" class="form-label">Ybanag Translation</label>
                <input type="text" name="ybanag_translation" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="pronunciation_audio" class="form-label">Pronunciation Audio (optional)</label>
                <input type="file" name="pronunciation_audio" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save Translation</button>
        </form>
    </div>
    @endsection
@endcan
