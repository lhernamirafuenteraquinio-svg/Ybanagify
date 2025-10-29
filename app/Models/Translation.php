<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $table = 'translations';  // Make sure the table name matches

    protected $fillable = [
        'filipino_word',
        'ybanag_translation',
        'pronunciation_audio',
        'is_visible',
    ];
}
