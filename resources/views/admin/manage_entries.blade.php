@extends('layouts.app')

@section('content')
<div class="content">
    <h1>Manage Entries</h1>

    <div class="manage-actions">
        <button onclick="showForm('dictionary')" class="btn">
            <i class='bx bx-plus'></i> Add Dictionary
        </button>
        <button onclick="showForm('translation')" class="btn">
            <i class='bx bx-filter'></i> Add Translation
        </button>
    </div>

    <div id="dictionaryForm" class="entry-form" style="display:none;">
        <h2>Add Dictionary Entry</h2>
        <form action="{{ route('dictionary.store') }}" method="POST">
            @csrf
            <label for="filipino_word">Filipino Word:</label>
            <input type="text" name="filipino_word" required>

            <label for="ybanag_translation">Ybanag Translation:</label>
            <input type="text" name="ybanag_translation" required>

            <label for="example_usage">Example Usage:</label>
            <textarea name="example_usage"></textarea>

            <button type="submit" class="btn"><i class='bx bx-check'></i> Save</button>
        </form>
    </div>

    <div id="translationForm" class="entry-form" style="display:none;">
        <h2>Add Translation</h2>
        <form action="{{ route('translation.store') }}" method="POST">
            @csrf
            <label for="source_text">Source Text:</label>
            <input type="text" name="source_text" required>

            <label for="translated_text">Translated Text:</label>
            <input type="text" name="translated_text" required>

            <label for="language_from">From:</label>
            <select name="language_from" required>
                <option value="filipino">Filipino</option>
                <option value="ybanag">Ybanag</option>
            </select>

            <label for="language_to">To:</label>
            <select name="language_to" required>
                <option value="ybanag">Ybanag</option>
                <option value="filipino">Filipino</option>
            </select>

            <button type="submit" class="btn"><i class='bx bx-check'></i> Translate</button>
        </form>
    </div>
</div>

<script>
function showForm(formType) {
    document.getElementById('dictionaryForm').style.display = (formType === 'dictionary') ? 'block' : 'none';
    document.getElementById('translationForm').style.display = (formType === 'translation') ? 'block' : 'none';
}
</script>

<style>
.content {
    padding: 20px;
    font-family: Arial, sans-serif;
}
.manage-actions {
    margin-bottom: 20px;
}
.manage-actions .btn {
    margin-right: 10px;
    padding: 10px 15px;
    background-color: #007bff;
    border: none;
    color: white;
    cursor: pointer;
}
.entry-form {
    margin-top: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    max-width: 500px;
}
.entry-form input, .entry-form textarea, .entry-form select {
    display: block;
    width: 100%;
    margin-bottom: 10px;
    padding: 8px;
}
.entry-form .btn {
    background-color: #28a745;
}
</style>
@endsection
