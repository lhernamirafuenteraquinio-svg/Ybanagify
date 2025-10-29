@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center text-dark display-5 fw-bold"><i class="bi bi-book"></i> Collected Ybanag Words</h1>

    <!-- 🔤 Alphabet Filter -->
    <div class="mb-4">
        <h5 class="text-dark fw-semibold mb-2" style="font-size: 1.25rem;">
            <i class="bi bi-alphabet me-1"></i>Browse by Letter:
        </h5>
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            @foreach (range('A', 'Z') as $char)
                <button type="button"
                    class="btn btn-sm letter-btn {{ request('letter') === $char ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-3 shadow-sm"
                    data-letter="{{ $char }}">
                    {{ $char }}
                </button>
            @endforeach
            <button type="button" id="resetLetter"
                class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm">
                <i class="bi bi-x-circle"></i> Reset
            </button>
        </div>
    </div>

    <!-- 🔍 Search Bar -->
    <form method="GET" action="{{ route('dictionary.index') }}">
        <div class="input-group mb-4">
            <span class="input-group-text bg-white"><i class="bi bi-search text-secondary"></i></span>
            <input type="text" name="search" class="form-control form-control-lg shadow-sm"
                   placeholder="Search Filipino or Ybanag word..." value="{{ $search }}" style="font-size: 1.1rem;">
            <button class="btn btn-primary shadow-sm" type="submit">
                <i class="bi bi-arrow-right-circle"></i> Search
            </button>
        </div>
    </form>

    <!-- 📚 Dictionary Entries -->
    <div id="entriesContainer">
    @if($entries->isEmpty())
        <div class="alert alert-warning text-center">
            <i class="bi bi-exclamation-triangle"></i> No dictionary entries found.
        </div>
    @else
        @php
            $groupedEntries = $entries->groupBy(function($item) {
                return strtoupper(substr($item->filipino_word, 0, 1));
            })->sortKeys();
            $groupedChunks = $groupedEntries->chunk(ceil($groupedEntries->count() / 2));
        @endphp

        <div class="row">
            @foreach($groupedChunks as $chunk)
                <div class="col-md-6">
                    @foreach($chunk as $letter => $group)
                        @if (!request('letter'))
                            <h3 class="text-center text-primary fw-bold mt-4 mb-3">{{ $letter }}</h3>
                        @else
                            <div class="mt-5"></div>
                        @endif
                        <div class="row row-cols-1 g-3">
                            @foreach ($group as $entry)
                                @php $collapseId = 'entry-' . $entry->id; @endphp
                                <div class="col">
                                    <div class="card mb-3 shadow dictionary-card border-0 rounded-3 bg-light">
                                        <div class="card-header bg-transparent border-0">
                                            <h5 class="mb-0">
                                                <a class="text-decoration-none d-block text-dark collapse-toggle"
                                                   data-bs-toggle="collapse"
                                                   href="#{{ $collapseId }}"
                                                   role="button"
                                                   aria-expanded="false"
                                                   aria-controls="{{ $collapseId }}">
                                                    <strong class="text-capitalize">{{ $entry->filipino_word }}</strong>
                                                    <i class="bi bi-chevron-down float-end toggle-icon"></i>
                                                </a>
                                            </h5>
                                        </div>

                                        <div id="{{ $collapseId }}" class="collapse">
                                            <div class="card-body text-dark">
                                                <p><i class="bi bi-translate me-1"></i>
                                                    Ybanag: <strong class="text-capitalize">{{ $entry->ybanag_translation }}</strong>
                                                </p>

                                                @if ($entry->pronunciation)
                                                    <p>
                                                        @if ($entry->pronunciation)
                                                            <i class="bi bi-volume-up me-1 text-primary play-audio-icon"
                                                                style="cursor: pointer;"
                                                                data-audio="{{ asset('storage/' . $entry->pronunciation_audio) }}"></i>
                                                    @else
                                                        <i class="bi bi-volume-up me-1 text-muted"></i>
                                                    @endif

                                                        Pronunciation: /<em>{{ $entry->pronunciation }}</em>/
                                                    </p>
                                                @endif

                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function () {
                                                        const audioPlayer = new Audio;

                                                        document.querySelectorAll('.play-audio-icon').forEach(icon => {
                                                            icon.replaceWith(icon.cloneNode(true));
                                                        });

                                                        document.querySelectorAll('.play-audio-icon').forEach(icon => {
                                                            icon.addEventListener('click', function () {
                                                                const audioScr = this.getAttribute('data-audio');

                                                                if (!audioPlayer.paused) {
                                                                    audioPlayer.pause();
                                                                    audioPlayer.currentTime = 0;
                                                                }

                                                                audioPlayer .src = audioScr;
                                                                audioPlayer.play();
                                                            });
                                                        });
                                                    });
                                                </script>

                                                @if ($entry->english_example_sentence || $entry->filipino_example_sentence || $entry->ybanag_example_sentence)
                                                    <hr>
                                                    <h6 class="fw-bold">
                                                        <i class="bi bi-chat-left-text me-1"></i>Example Sentences:
                                                    </h6>

                                                    @if ($entry->english_example_sentence)
                                                        <p><strong>English:</strong> {{ $entry->english_example_sentence }}</p>
                                                    @endif
                                                    @if ($entry->filipino_example_sentence)
                                                        <p><strong>Filipino:</strong> {{ $entry->filipino_example_sentence }}</p>
                                                    @endif
                                                    @if ($entry->ybanag_example_sentence)
                                                        <p><strong>Ybanag:</strong> {{ $entry->ybanag_example_sentence }}</p>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
    </div>

    <!-- 🔝 Back to Top Button -->
    <button id="backToTopBtn"
        class="btn btn-primary btn-lg rounded-circle shadow position-fixed d-flex align-items-center justify-content-center"
        style="bottom: 90px; right: 30px; width: 50px; height: 50px;
               opacity: 0; visibility: hidden; transition: opacity 0.3s, visibility 0.3s;
               z-index: 1050;">
        <i class="bi bi-arrow-up-short fs-3"></i>
    </button>

    <!-- ✏️ Floating Contribute Button -->
    <a href="#" class="btn btn-primary btn-lg rounded-circle shadow position-fixed"
       style="bottom: 30px; right: 30px; z-index: 1060;"
       data-bs-toggle="modal" data-bs-target="#contributeModal">
        <i class="bi bi-pencil-square"></i>
    </a>
</div>

<!-- 📝 Contribution Modal -->
<div class="modal fade" id="contributeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">

    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title"><i class="bx bx-pencil me-2"></i>Contribute a New Word</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{ route('contribute.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-bold"><i class="bx bx-text me-1"></i>Filipino Word</label>
              <input type="text" name="filipino_word" required class="form-control" placeholder="Enter Filipino word">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold"><i class="bx bx-translate me-1"></i>Ybanag Translation</label>
              <input type="text" name="ybanag_translation" required class="form-control" placeholder="Enter Ybanag translation">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold"><i class="bx bx-microphone me-1"></i>Pronunciation (Text)</label>
              <input type="text" name="pronunciation" class="form-control" placeholder="Example: mab-ba-lo">
            </div>

            <!-- <div class="col-md-6">
              <label class="form-label fw-bold"><i class="bx bx-music me-1"></i>Pronunciation Audio</label>
              <input type="file" name="pronunciation_audio" accept=".mp3,.wav,.ogg" class="form-control">
            </div> -->

            <div class="col-md-12">
              <hr class="my-2">
              <h6 class="fw-bold mb-2"><i class="bx bx-chat me-1"></i>Example Sentences</h6>
            </div>

            <div class="col-md-12">
              <label class="form-label"><i class="bx bx-book me-1"></i>English Example Sentence</label>
              <textarea name="english_example_sentence" required class="form-control" rows="2" placeholder="Enter English example sentence"></textarea>
            </div>

            <div class="col-md-12">
              <label class="form-label"><i class="bx bx-book me-1"></i>Filipino Example Sentence</label>
              <textarea name="filipino_example_sentence" required class="form-control" rows="2" placeholder="Enter Filipino example sentence"></textarea>
            </div>

            <div class="col-md-12">
              <label class="form-label"><i class="bx bx-book me-1"></i>Ybanag Example Sentence</label>
              <textarea name="ybanag_example_sentence" required class="form-control" rows="2" placeholder="Enter Ybanag example sentence"></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold"><i class="bx bx-user me-1"></i>Your Name</label>
              <input type="text" name="submitted_by" required class="form-control" placeholder="Enter your full name">
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold"><i class="bx bx-envelope me-1"></i>Your Email</label>
              <input type="email" name="submitted_email" required class="form-control" placeholder="Enter your email">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bx bx-x me-1"></i>Cancel</button>
          <button type="submit" class="btn btn-success"><i class="bx bx-send me-1"></i>Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ✅ Success Toast (place this RIGHT AFTER the modal) -->
@if (session('success'))
  <div id="successToast"
       class="position-fixed top-0 start-50 translate-middle-x p-3"
       style="z-index: 9999;">
    <div class="toast align-items-center text-white bg-success border-0 show shadow-lg"
         role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body fw-semibold">
          <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Hide modal if open
      const modalEl = document.getElementById('contributeModal');
      const modal = bootstrap.Modal.getInstance(modalEl);
      if (modal) modal.hide();

      // Automatically fade out the toast after 4 seconds
      setTimeout(() => {
        const toastEl = document.querySelector('#successToast .toast');
        if (toastEl) {
          toastEl.classList.remove('show');
          setTimeout(() => toastEl.remove(), 500);
        }
      }, 4000);
    });
  </script>
@endif
@endsection

@section('styles')
<style>
    .dictionary-card { transition: transform 0.2s ease; }
    .toggle-icon { font-size: 1.1rem; transition: transform 0.3s ease; }
    .dictionary-card:hover { transform: scale(1.01); }
    .btn:focus { box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25); }
    .modal-body { max-height: 60vh; overflow-y: auto; }
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* -------------------------------
     * 🔍 SEARCH VALIDATION
     * ----------------------------- */
    const searchForm = document.querySelector('form[action*="dictionary"]');
    const searchInput = searchForm.querySelector('input[name="search"]');

    searchForm.addEventListener('submit', function (e) {
        const searchValue = searchInput.value.trim();

        if (searchValue === '') {
            e.preventDefault();
            showSearchError('Please enter a word to search.');
            return;
        }

        if (!/^[a-zA-ZÀ-ÿ\s\-]+$/.test(searchValue)) {
            e.preventDefault();
            showSearchError('Search must only contain letters — numbers or symbols are not allowed.');
            return;
        }
    });

    function showSearchError(message) {
        let existingAlert = document.querySelector('#searchErrorAlert');
        if (existingAlert) existingAlert.remove();

        const alert = document.createElement('div');
        alert.id = 'searchErrorAlert';
        alert.className = 'alert alert-danger text-center mt-3 fade show';
        alert.innerHTML = `<i class="bi bi-exclamation-triangle"></i> ${message}`;

        searchForm.insertAdjacentElement('afterend', alert);
        setTimeout(() => alert.remove(), 4000);
    }

    /* -------------------------------
     * 🔠 AJAX LETTER FILTER
     * ----------------------------- */
    const entriesContainer = document.getElementById('entriesContainer');

    function fetchEntries(letter = '') {
        entriesContainer.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-3 text-muted">Loading words...</p>
            </div>
        `;

        fetch(`{{ route('dictionary.index') }}?letter=${letter}`)
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newEntries = doc.querySelector('#entriesContainer');
                entriesContainer.innerHTML = newEntries
                    ? newEntries.innerHTML
                    : `<div class="alert alert-warning text-center"><i class="bi bi-exclamation-triangle"></i> No results found.</div>`;
                
                // ✅ Re-initialize collapse listeners after new HTML is loaded
                initCollapseAutoClose();
            })
            .catch(() => {
                entriesContainer.innerHTML = `
                    <div class="alert alert-danger text-center mt-4">
                        <i class="bi bi-x-circle"></i> Failed to load entries.
                    </div>
                `;
            });
    }

    document.querySelectorAll('.letter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const letter = this.getAttribute('data-letter');
            fetchEntries(letter);
            document.querySelectorAll('.letter-btn').forEach(b => b.classList.remove('btn-primary'));
            this.classList.add('btn-primary');
        });
    });

    document.getElementById('resetLetter').addEventListener('click', function () {
        fetchEntries('');
        document.querySelectorAll('.letter-btn').forEach(b => b.classList.remove('btn-primary'));
    });

    /* -------------------------------
     * 🔝 BACK TO TOP BUTTON
     * ----------------------------- */
    const backToTopBtn = document.getElementById('backToTopBtn');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 300) {
            backToTopBtn.style.opacity = '1';
            backToTopBtn.style.visibility = 'visible';
        } else {
            backToTopBtn.style.opacity = '0';
            backToTopBtn.style.visibility = 'hidden';
        }
    });

    backToTopBtn.addEventListener('click', function (e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    /* -------------------------------
     * 📝 CONTRIBUTION MODAL RESET
     * ----------------------------- */
    const contributeModal = document.getElementById('contributeModal');
    contributeModal.addEventListener('hidden.bs.modal', function () {
        contributeModal.querySelector('form').reset();
    });

    /* -------------------------------
     * 📖 COLLAPSE AUTO-CLOSE FUNCTION
     * ----------------------------- */
    function initCollapseAutoClose() {
        const toggles = document.querySelectorAll('.collapse-toggle');

        toggles.forEach(toggle => {
            const targetId = toggle.getAttribute('href').substring(1);
            const target = document.getElementById(targetId);
            const icon = toggle.querySelector('.toggle-icon');

            if (!target) return;

            target.addEventListener('show.bs.collapse', () => {
                document.querySelectorAll('.collapse.show').forEach(open => {
                    if (open.id !== targetId) {
                        const instance = bootstrap.Collapse.getInstance(open);
                        if (instance) {
                            instance.hide();
                        } else {
                            new bootstrap.Collapse(open, { toggle: false }).hide();
                        }
                    }
                });
                icon.classList.replace('bi-chevron-down', 'bi-chevron-up');
            });

            target.addEventListener('hide.bs.collapse', () => {
                icon.classList.replace('bi-chevron-up', 'bi-chevron-down');
            });

            // Optional: Scroll into view when opened
            target.addEventListener('shown.bs.collapse', () => {
                target.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });
    }

    // ✅ Initialize for first load
    initCollapseAutoClose();
});
</script>
@endpush
