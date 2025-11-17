<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $table = 'translations';  // Make sure the table name matches

    protected $fillable = [
        'entry_id',
        'filipino_word',
        'ybanag_translation',
        'pronunciation_audio',
        'filipino_example_sentence',
        'ybanag_example_sentence',
        'is_visible',
    ];

    public function entry()
    {
        return $this->belongsTo(Entry::class, 'entry_id');
    }
}
