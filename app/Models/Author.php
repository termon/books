<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;

    public $guarded = ['id'];


    // 1:M relationship
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
