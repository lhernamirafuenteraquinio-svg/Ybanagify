<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    use HasFactory;

    protected $fillable = [
        'entry_id',
        'filipino_word',
        'ybanag_translation',
        'pronunciation',
        'pronunciation_audio',
        'part_of_speech',
        'tagalog_meaning',
        'english_example_sentence',
        'filipino_example_sentence',
        'ybanag_example_sentence',
        'is_visible',
    ];

    public function entry()
    {
        return $this->belongsTo(Entry::class, 'entry_id');
    }
}
