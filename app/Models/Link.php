<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash_id',
        'name',
        'path',
        'category_id',
        'user_id',
        'posts_id',
    ];

    protected $hidden = [
        'id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->hash_id = Str::uuid()->toString();
        });
    }
}