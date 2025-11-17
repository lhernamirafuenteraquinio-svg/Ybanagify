@extends('layouts.app')

@section('content')
<div class="container py-5 translator-page">
    <h1 class="text-center text-dark display-5 fw-bold">YBANAGIFY Translator</h1>

    <!-- Language Direction Toggle -->
    <div class="text-center mb-4">
        <div class="d-flex justify-content-center align-items-center" style="gap: 20px;">
            <div class="text-center flex-fill">
                <span class="fw-bold d-block" id="sourceLang">Filipino</span>
            </div>
            <div>
                <button onclick="swapDirection()" class="btn btn-outline-primary btn-sm" title="Swap Languages">
                    <i id="swapBtnIcon" class="bi bi-arrow-left-right"></i>
                </button>
            </div>
            <div class="text-center flex-fill">
                <span class="fw-bold d-block" id="targetLang">Ybanag</span>
            </div>
        </div>
        <input type="hidden" id="direction" value="filipino_to_ybanag">
    </div>


    <!-- Translator Interface -->
    <div class="translator-container d-flex flex-wrap justify-content-between gap-3 mb-4">
        <!-- Input Section -->
        <div class="translator-box">
            <label for="inputText" class="form-label fw-semibold d-flex justify-content-between">
                <span>Input</span>
                <div>
                    <button class="btn btn-sm btn-outline-success me-1" id="recordInputBtn" title="Speak Input">
                        <i class="bi bi-mic"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary me-1" onclick="speakInput()" title="Play Input Audio">
                        <i class="bi bi-volume-up"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary me-1" onclick="copyText('inputText')" title="Copy Input">
                        <i class="bi bi-clipboard"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="clearText('inputText')" title="Clear">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </label>
            <textarea id="inputText" class="form-control" placeholder="Type or paste text here..."></textarea>
            <div id="exampleInput" class="mt-3 text-secondary"></div>
            <ul id="suggestionsBox" class="suggestions-box"></ul>
        </div>

        <!-- Output Section -->
        <div class="translator-box">
            <label for="outputText" class="form-label fw-semibold d-flex justify-content-between">
                <span>Translation</span>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-1" onclick="speakOutput()" title="Play Output Audio">
                        <i class="bi bi-volume-up"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary me-1" onclick="copyText('outputText')" title="Copy Translation">
                        <i class="bi bi-clipboard"></i>
                    </button>
                </div>
            </label>
            <textarea id="outputText" class="form-control" readonly placeholder="Translation will appear here..."></textarea>
            <div id="exampleOutput" class="mt-3 text-secondary"></div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="toast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="polite" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">Copied to clipboard!</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .translator-container {
        gap: 20px;
    }

    .translator-box {
        position: relative;
        flex: 1 1 48%;
        background-color: #ecf0f1;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    textarea.form-control {
        height: 200px;
        resize: none;
        font-size: 16px;
        border-radius: 8px;
        border: 1px solid #ccc;
        transition: border-color 0.3s ease;
    }

    textarea.form-control:focus {
        border-color: #3498db;
        box-shadow: none;
    }

    button.btn-sm {
        border-radius: 50px;
    }

    .suggestions-box {
        position: absolute;
        bottom: 150px;
        left: 16px;
        right: 16px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 0.85rem;
        color: #6c757d;
        pointer-events: auto;
        z-index: 10;
        padding: 6px 16px;
        
    }

    .suggestions-box span {
        background-color: #f1f1f1;
        padding: 4px 6px;
        border-radius: 12px;
        cursor: pointer;
        transition: background-color 0.2s, border-color 0.2s;
        border: 1px solid transparent;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .suggestions-box span:hover {
        background-color: #d9d9d9;
        border-color: #3498db;
    }

    @media (max-width: 768px) {
        .translator-box {
            flex: 1 1 100%;
        }

        .suggestions-box {
            font-size: 0.8rem;
            padding: 6px 16px;
        }
        .suggestions-box span {
            padding: 4px 6px;
        }
    }

    #recordInputBtn.recording {
        background-color: #dc3545; /* Red background while recording */
        color: white;
        animation: pulse 1s infinite;
        border-color: #dc3545;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

</style>
@endpush

@push('scripts')
<script>
    const inputText = document.getElementById('inputText');
    const outputText = document.getElementById('outputText');
    const directionInput = document.getElementById('direction');
    const suggestionsBox = document.getElementById('suggestionsBox');

    let typingTimer;
    const typingDelay = 300; // delay para hindi sabay-sabay request

    inputText.addEventListener('input', () => {
        clearTimeout(typingTimer);

        typingTimer = setTimeout(() => {
            translateText();
            fetchSuggestions();
        }, typingDelay);
    });

    async function translateText() {
        try {
            const response = await fetch("{{ route('ajax.translate') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content')
                },
                body: JSON.stringify({
                    text: inputText.value,
                    direction: directionInput.value
                })
            });

            const data = await response.json();
            outputText.value = data.translated;
            window.translationAudio = data.audio || null;

            if (data.translated && data.translated.trim() !== '' && data.translated !== 'Not found') {
                suggestionsBox.style.display = 'none';
            }

            const exampleInput = document.getElementById('exampleInput');
            const exampleOutput = document.getElementById('exampleOutput');

            function highlightWords(sentence, wordsObj) {
                if (!sentence) return '';
                let highlighted = sentence;
                const highlightedSet = new Set();

                for (const word in wordsObj) {
                    const lowerWord = word.toLowerCase();
                    if (highlightedSet.has(lowerWord)) continue;

                    const escapedWord = word.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    const regex = new RegExp(`(${escapedWord})`, 'gi');
                    highlighted = highlighted.replace(regex, (match) => {
                        highlightedSet.add(match.toLowerCase());
                        return `<mark>${match}</mark>`;
                    });
                }

                return highlighted;
            }

            // Example sentences display
            if (directionInput.value === 'filipino_to_ybanag') {
                exampleInput.innerHTML = Object.keys(data.examples_fil).length
                    ? `<strong>Filipino Examples:</strong><br>${Object.values(data.examples_fil)
                        .map(sentence => highlightWords(sentence, data.examples_fil))
                        .join('<br>')}` : '';
                exampleOutput.innerHTML = Object.keys(data.examples_yba).length
                    ? `<strong>Ybanag Examples:</strong><br>${Object.values(data.examples_yba)
                        .map(sentence => highlightWords(sentence, data.examples_yba))
                        .join('<br>')}` : '';
            } else {
                exampleInput.innerHTML = Object.keys(data.examples_yba).length
                    ? `<strong>Ybanag Examples:</strong><br>${Object.values(data.examples_yba)
                        .map(sentence => highlightWords(sentence, data.examples_yba))
                        .join('<br>')}` : '';
                exampleOutput.innerHTML = Object.keys(data.examples_fil).length
                    ? `<strong>Filipino Examples:</strong><br>${Object.values(data.examples_fil)
                        .map(sentence => highlightWords(sentence, data.examples_fil))
                        .join('<br>')}` : '';
            }
        } catch (err) {
            console.error('Translation error:', err);
        }
    }

    async function fetchSuggestions() {
        const query = inputText.value.trim();

        if (query.length < 2) {
            suggestionsBox.style.display = 'none';
            return;
        }

        try {
            const response = await fetch("{{ route('ajax.suggestions') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content')
                },
                body: JSON.stringify({
                    query: query,
                    direction: directionInput.value
                })
            });

            const suggestions = await response.json();

            if (!suggestions.length || !query) {
                suggestionsBox.style.display = 'none';
                return;
            }

            if (suggestions.some(word => word.toLowerCase() === query.toLowerCase())) {
                suggestionsBox.style.display = 'none';
                return;
            }

            suggestionsBox.innerHTML = '';
            suggestionsBox.style.display = 'block';

            suggestions.forEach(word => {
                const span = document.createElement('span');
                span.textContent = word;
                span.addEventListener('click', () => {
                    inputText.value = word;
                    suggestionsBox.style.display = 'none';
                    translateText();
                });
                suggestionsBox.appendChild(span);
            });
        } catch (error) {
            suggestionsBox.style.display = 'none';
        }
    }

    // Hide suggestions when clicking outside
    document.addEventListener('click', (event) => {
        if (!inputText.contains(event.target) && !suggestionsBox.contains(event.target)) {
            suggestionsBox.style.display = 'none';
        }
    });

    // Swap direction
    function swapDirection() {
        if (directionInput.value === 'filipino_to_ybanag') {
            directionInput.value = 'ybanag_to_filipino';
            document.getElementById('sourceLang').textContent = 'Ybanag';
            document.getElementById('targetLang').textContent = 'Filipino';
        } else {
            directionInput.value = 'filipino_to_ybanag';
            document.getElementById('sourceLang').textContent = 'Filipino';
            document.getElementById('targetLang').textContent = 'Ybanag';
        }

        const temp = inputText.value;
        inputText.value = outputText.value;
        outputText.value = temp;

        translateText();
    }

    // Speech features
    function speakInput() {
        if (directionInput.value === 'filipino_to_ybanag') {
            const utterance = new SpeechSynthesisUtterance(inputText.value);
            utterance.lang = 'tl-PH';
            window.speechSynthesis.speak(utterance);
        } else {
            playYbanagAudio();
        }
    }

    function speakOutput() {
        if (directionInput.value === 'filipino_to_ybanag') {
            playYbanagAudio();
        } else {
            const utterance = new SpeechSynthesisUtterance(outputText.value);
            utterance.lang = 'tl-PH';
            window.speechSynthesis.speak(utterance);
        }
    }

    function playYbanagAudio() {
        if (!window.translationAudio) return;
        const audio = new Audio("{{ asset('storage/') }}/" + window.translationAudio);
        audio.play();
    }

    // Copy & clear
    function copyText(id) {
        const text = document.getElementById(id).value;
        navigator.clipboard.writeText(text).then(() => {
            const toast = new bootstrap.Toast(document.getElementById('toast'));
            toast.show();
        });
    }

    function clearText(id) {
        document.getElementById(id).value = '';
        if (id === 'inputText') translateText();
    }

    // Speech recognition
    const recordInputBtn = document.getElementById('recordInputBtn');
    if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        const recognition = new SpeechRecognition();
        recognition.lang = 'tl-PH';
        recognition.interimResults = false;
        recognition.maxAlternatives = 1;

        recordInputBtn.addEventListener('click', () => {
            recordInputBtn.classList.add('recording');
            recognition.start();
        });

        recognition.onresult = (event) => {
            const speechResult = event.results[0][0].transcript;
            inputText.value = speechResult;
            translateText();
        };

        recognition.onend = () => {
            recordInputBtn.classList.remove('recording');
        };

        recognition.onerror = (event) => {
            recordInputBtn.classList.remove('recording');
            alert('Speech recognition error: ' + event.error);
        };
    } else {
        recordInputBtn.disabled = true;
        recordInputBtn.title = "Speech recognition not supported in this browser";
    }
</script>
@endpush
