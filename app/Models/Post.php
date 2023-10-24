<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash_id',
        'title',
        'img_logo',
        'img_path',
        'img_banner',
        'text',
        'days',
        'locate',
        'link_locate',
        'category_id',
        'user_id',
        'start_date',
        'end_date',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
