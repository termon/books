<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $guarded  = ['id'];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

    public static function getSelectList()
    {
        return self::all()->pluck('name', 'id');
    }
}
