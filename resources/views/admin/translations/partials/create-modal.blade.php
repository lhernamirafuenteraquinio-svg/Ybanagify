<div class="modal fade" id="createTranslationModal" tabindex="-1" aria-labelledby="createTranslationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.translations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="createTranslationModalLabel">Add New Translation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          @if ($errors->any() && session('form') === 'create')
            <div class="alert alert-danger">
              <strong>Oops!</strong> May mga error sa form:<br><br>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="mb-3">
            <label for="filipino_word" class="form-label">Filipino Word</label>
            <input type="text" name="filipino_word" class="form-control" value="{{ old('filipino_word') }}" required>
          </div>

          <div class="mb-3">
            <label for="ybanag_translation" class="form-label">Ybanag Translation</label>
            <input type="text" name="ybanag_translation" class="form-control" value="{{ old('ybanag_translation') }}" required>
          </div>

          <div class="mb-3">
            <label for="pronunciation_audio" class="form-label">Pronunciation Audio (optional)</label>
            <input type="file" name="pronunciation_audio" class="form-control">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Translation</button>
        </div>
      </form>
    </div>
  </div>
</div>
