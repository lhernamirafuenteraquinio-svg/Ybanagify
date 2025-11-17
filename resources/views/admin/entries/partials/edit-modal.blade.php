<!-- Edit Entry Modal -->
<div class="modal fade" id="editModal-{{ $entry->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $entry->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editModalLabel-{{ $entry->id }}">
                    <i class="bx bx-edit me-2"></i>Edit Entry
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.entries.update', $entry->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bx bx-text me-1"></i>Filipino Word</label>
                            <input type="text" name="filipino_word" class="form-control" value="{{ $entry->filipino_word }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bx bx-translate me-1"></i>Ybanag Translation</label>
                            <input type="text" name="ybanag_translation" class="form-control" value="{{ $entry->ybanag_translation }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bx bx-microphone me-1"></i>Pronunciation (Text)</label>
                            <input type="text" name="pronunciation" class="form-control" value="{{ $entry->pronunciation }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bx bx-music me-1"></i>Pronunciation Audio</label>
                            @if ($entry->pronunciation_audio)
                                <div class="mb-2">
                                    <audio controls style="width: 100%;">
                                        <source src="{{ asset('storage/' . $entry->pronunciation_audio) }}" type="audio/mpeg">
                                    </audio>
                                </div>
                            @endif
                            <input type="file" name="pronunciation_audio" class="form-control" accept=".mp3,.wav,.ogg">
                            <small class="text-muted">Leave blank to keep current audio.</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bx bx-category me-1"></i>Part of Speech</label>
                            <select name="part_of_speech" class="form-select">
                                <option value="">Select...</option>
                                <option value="noun" {{ $entry->part_of_speech == 'noun' ? 'selected' : '' }}>Noun</option>
                                <option value="verb" {{ $entry->part_of_speech == 'verb' ? 'selected' : '' }}>Verb</option>
                                <option value="adjective" {{ $entry->part_of_speech == 'adjective' ? 'selected' : '' }}>Adjective</option>
                                <option value="adverb" {{ $entry->part_of_speech == 'adverb' ? 'selected' : '' }}>Adverb</option>
                                <option value="pronoun" {{ $entry->part_of_speech == 'pronoun' ? 'selected' : '' }}>Pronoun</option>
                                <option value="preposition" {{ $entry->part_of_speech == 'preposition' ? 'selected' : '' }}>Preposition</option>
                                <option value="conjunction" {{ $entry->part_of_speech == 'conjunction' ? 'selected' : '' }}>Conjunction</option>
                                <option value="interjection" {{ $entry->part_of_speech == 'interjection' ? 'selected' : '' }}>Interjection</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold"><i class="bx bx-book-open me-1"></i>Tagalog Meaning</label>
                            <input type="text" name="tagalog_meaning" class="form-control" value="{{ $entry->tagalog_meaning }}">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold"><i class="bx bx-book me-1"></i>English Example Sentence</label>
                            <textarea name="english_example_sentence" class="form-control" rows="2">{{ $entry->english_example_sentence }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold"><i class="bx bx-book me-1"></i>Filipino Example Sentence</label>
                            <textarea name="filipino_example_sentence" class="form-control" rows="2">{{ $entry->filipino_example_sentence }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold"><i class="bx bx-book me-1"></i>Ybanag Example Sentence</label>
                            <textarea name="ybanag_example_sentence" class="form-control" rows="2">{{ $entry->ybanag_example_sentence }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> <i class="bx bx-x me-1"></i>Cancel</button>
                    <button type="submit" class="btn btn-warning text-white"><i class="bx bx-save me-1"></i>Update Entry</button>
                </div>
            </form>
        </div>
    </div>
</div>
