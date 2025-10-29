<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
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
        'submitted_by',
        'submitted_email',
        'submitted_ip',
        'user_agent',
    ];
}
