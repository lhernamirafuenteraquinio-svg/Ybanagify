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
        'part_of_speech',
        'tagalog_meaning',
        'english_example_sentence',
        'filipino_example_sentence',
        'ybanag_example_sentence',
    ];

    public function dictionary()
    {
        return $this->hasOne(Dictionary::class, 'entry_id');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class, 'entry_id');
    }
}
