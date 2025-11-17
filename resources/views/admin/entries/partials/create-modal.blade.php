<!-- Create Entry Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createModalLabel"><i class="bx bx-plus-circle me-2"></i>Add New Entry</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.entries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bx bx-text me-1"></i>Filipino Word</label>
                            <input type="text" name="filipino_word" class="form-control" value="{{ old('filipino_word') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bx bx-translate me-1"></i>Ybanag Translation</label>
                            <input type="text" name="ybanag_translation" class="form-control" value="{{ old('ybanag_translation') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bx bx-microphone me-1"></i>Pronunciation (Text)</label>
                            <input type="text" name="pronunciation" class="form-control" value="{{ old('pronunciation') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bx bx-music me-1"></i>Pronunciation Audio</label>
                            <input type="file" name="pronunciation_audio" class="form-control" accept=".mp3,.wav,.ogg">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bx bx-category me-1"></i>Part of Speech</label>
                            <select name="part_of_speech" class="form-select">
                                <option value="">Select...</option>
                                <option value="noun">Noun</option>
                                <option value="verb">Verb</option>
                                <option value="adjective">Adjective</option>
                                <option value="adverb">Adverb</option>
                                <option value="pronoun">Pronoun</option>
                                <option value="preposition">Preposition</option>
                                <option value="conjunction">Conjunction</option>
                                <option value="interjection">Interjection</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bx bx-book-open me-1"></i>Tagalog Meaning</label>
                            <input type="text" name="tagalog_meaning" class="form-control" value="{{ old('tagalog_meaning') }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold"><i class="bx bx-book me-1"></i>English Example Sentence</label>
                            <textarea name="english_example_sentence" class="form-control" rows="2">{{ old('english_example_sentence') }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold"><i class="bx bx-book me-1"></i>Filipino Example Sentence</label>
                            <textarea name="filipino_example_sentence" class="form-control" rows="2">{{ old('filipino_example_sentence') }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold"><i class="bx bx-book me-1"></i>Ybanag Example Sentence</label>
                            <textarea name="ybanag_example_sentence" class="form-control" rows="2">{{ old('ybanag_example_sentence') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bx bx-x me-1"></i>Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i>Save Entry</button>
                </div>
            </form>
        </div>
    </div>
</div>
