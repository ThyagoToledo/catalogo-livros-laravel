<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    protected $hidden = [
        'normalized_title',
        'normalized_author',
    ];

    protected $fillable = [
        'title',
        'author',
        'category',
        'status',
    ];

    protected static function booted(): void
    {
        static::saving(function (Book $book): void {
            $book->normalized_title = Str::lower(trim($book->title));
            $book->normalized_author = Str::lower(trim($book->author));
        });
    }
}
