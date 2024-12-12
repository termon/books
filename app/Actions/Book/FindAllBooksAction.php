<?php

namespace App\Actions\Book;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

class FindAllBooksAction {
    
    public function execute(?string $search = null, string $sort = 'id', string $direction = 'asc', int $size = 10): LengthAwarePaginator {
        $query = Book::with(['category']);      

        if ($search) {
            $query =  $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('year', 'like', "%{$search}%")
                ->orWhereHas(
                    'category',
                    fn($q) =>
                    $q->where('name', 'like', "%{$search}%")
                );
        }
        return $query->sortable($sort, $direction)->paginate($size)->withQueryString();
    }
}
