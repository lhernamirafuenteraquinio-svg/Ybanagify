<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $fillable = [
        'filipino_word',
        'ybanag_translation',
        'pronunciation',
        'pronunciation_audio',
        'english_example_sentence',
        'filipino_example_sentence',
        'ybanag_example_sentence',
    ];
}
