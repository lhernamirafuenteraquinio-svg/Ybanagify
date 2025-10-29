<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.dictionary.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createModalLabel">Add New Ybanag Words Entry</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="filipino_word" class="form-label">Filipino Word</label>
            <input type="text" name="filipino_word" class="form-control" id="filipino_word" required>
          </div>

          <div class="mb-3">
            <label for="ybanag_translation" class="form-label">Ybanag Translation</label>
            <input type="text" name="ybanag_translation" class="form-control" id="ybanag_translation" required>
          </div>

          <div class="mb-3">
            <label for="pronunciation" class="form-label">Pronunciation</label>
            <input type="text" name="pronunciation" class="form-control" id="pronunciation">
          </div>

          <div class="mb-3">
            <label for="english_example_sentence" class="form-label">English Example Sentence</label>
            <textarea name="english_example_sentence" class="form-control" id="english_example_sentence" rows="2"></textarea>
          </div>

          <div class="mb-3">
            <label for="filipino_example_sentence" class="form-label">Filipino Example Sentence</label>
            <textarea name="filipino_example_sentence" class="form-control" id="filipino_example_sentence" rows="2"></textarea>
          </div>

          <div class="mb-3">
            <label for="ybanag_example_sentence" class="form-label">Ybanag Example Sentence</label>
            <textarea name="ybanag_example_sentence" class="form-control" id="ybanag_example_sentence" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Entry</button>
        </div>
      </div>
    </form>
  </div>
</div>
