<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'phone',
        'subject_level',
        'is_message',
        'status',
    ];

    protected $hidden = [
        'id',
        'email',
        'phone',
    ];
}
