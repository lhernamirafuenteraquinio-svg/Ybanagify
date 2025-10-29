<div class="modal fade" id="editTranslationModal-{{ $translation->id }}" tabindex="-1" aria-labelledby="editTranslationModalLabel-{{ $translation->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.translations.update', $translation->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editTranslationModalLabel-{{ $translation->id }}">Edit Translation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          @if ($errors->any() && session('form') === 'edit-' . $translation->id)
            <div class="alert alert-danger">
              <strong>Oops!</strong> There were issues with the form submission.<br><br>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="mb-3">
            <label for="filipino_word" class="form-label">Filipino Word</label>
            <input type="text" name="filipino_word" value="{{ old('filipino_word', $translation->filipino_word) }}" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="ybanag_translation" class="form-label">Ybanag Translation</label>
            <input type="text" name="ybanag_translation" value="{{ old('ybanag_translation', $translation->ybanag_translation) }}" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="pronunciation_audio" class="form-label">Pronunciation Audio (optional)</label>
            <input type="file" name="pronunciation_audio" class="form-control">

            @if ($translation->pronunciation_audio)
              <div class="mt-2">
                <p>Current file:</p>
                <audio controls>
                  <source src="{{ asset('storage/' . $translation->pronunciation_audio) }}" type="audio/mpeg">
                  Your browser does not support the audio tag.
                </audio>
                <p class="mt-1">File Name: {{ basename($translation->pronunciation_audio) }}</p>
              </div>
            @endif
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Update Translation</button>
        </div>
      </form>
    </div>
  </div>
</div>
