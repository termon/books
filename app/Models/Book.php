<?php

namespace App\Models;

use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> **/
    /** @use App\Traits\Sortable  **/
    use HasFactory, Sortable;

    protected $guarded  = ['id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // 1:M relationship
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    // 1:M relationship
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->orderBy('created_at', 'desc');
    }

    protected function Rating(): Attribute
    {
        return Attribute::make(
            set: fn($value, $attributes) => round($value, 1),
        );
    }


    // make list of authors not associated with book
    public function addAuthorBookSelectList(): array
    {
        return Author::all()->diff($this->authors)
            ->pluck('name', 'id')->all();
    }

    public function canAddAuthor(): bool
    {
        return count($this->addAuthorBookSelectList()) > 0;
    }

    public function canRemoveAuthor(): bool
    {
        return count($this->removeAuthorBookSelectList()) > 0;
    }

    // make select list of authors associated with book
    public function removeAuthorBookSelectList(): array
    {
        return $this->authors->pluck('name', 'id')->all();
    }
}
