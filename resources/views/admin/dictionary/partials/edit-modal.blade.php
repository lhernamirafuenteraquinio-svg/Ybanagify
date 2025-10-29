<div class="modal fade" id="editModal-{{ $dictionary->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $dictionary->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.dictionary.update', $dictionary->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel-{{ $dictionary->id }}">Edit Ybanag Words Entry</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="filipino_word_{{ $dictionary->id }}" class="form-label">Filipino Word</label>
            <input type="text" name="filipino_word" class="form-control" id="filipino_word_{{ $dictionary->id }}" value="{{ old('filipino_word', $dictionary->filipino_word) }}" required>
          </div>

          <div class="mb-3">
            <label for="ybanag_translation_{{ $dictionary->id }}" class="form-label">Ybanag Translation</label>
            <input type="text" name="ybanag_translation" class="form-control" id="ybanag_translation_{{ $dictionary->id }}" value="{{ old('ybanag_translation', $dictionary->ybanag_translation) }}" required>
          </div>

          <div class="mb-3">
            <label for="pronunciation_{{ $dictionary->id }}" class="form-label">Pronunciation</label>
            <input type="text" name="pronunciation" class="form-control" id="pronunciation_{{ $dictionary->id }}" value="{{ old('pronunciation', $dictionary->pronunciation) }}">
          </div>

          <div class="mb-3">
            <label for="english_example_sentence_{{ $dictionary->id }}" class="form-label">English Example Sentence</label>
            <textarea name="english_example_sentence" class="form-control" id="english_example_sentence" rows="2">{{ old('english_example_sentence', $dictionary->english_example_sentence) }}</textarea>
          </div>

          <div class="mb-3">
            <label for="filipino_example_sentence_{{ $dictionary->id }}" class="form-label">Filipino Example Sentence</label>
            <textarea name="filipino_example_sentence" class="form-control" id="filipino_example_sentence" rows="2">{{ old('filipino_example_sentence', $dictionary->filipino_example_sentence) }}</textarea>
          </div>

          <div class="mb-3">
            <label for="ybanag_example_sentence_{{ $dictionary->id }}" class="form-label">Ybanag Example Sentence</label>
            <textarea name="ybanag_example_sentence" class="form-control" id="ybanag_example_sentence_{{ $dictionary->id }}" rows="2">{{ old('ybanag_example_sentence', $dictionary->ybanag_example_sentence) }}</textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Entry</button>
        </div>
      </div>
    </form>
  </div>
</div>
