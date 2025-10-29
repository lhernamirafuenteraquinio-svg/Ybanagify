<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use SoftDeletes;

    protected $table = 'feedbacks';

    protected $fillable = ['name', 'email', 'category', 'message'];
}
