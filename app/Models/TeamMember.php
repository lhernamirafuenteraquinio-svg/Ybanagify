<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'role',
        'img',
        'email',
        'phone',
        'fb',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->img) {
            return str_starts_with($this->img, 'team/') 
                ? asset('storage/' . $this->img) 
                : asset($this->img);
        }
        return asset('images/prof.jpg'); // default profile image
    }

}
