<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'description',
        'stock',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }


    public function activeBorrowingsCount()
    {
        return $this->borrowings()->where('status', 'borrowed')->count();
    }

    public function isAvailable()
    {
        return $this->activeBorrowingsCount() < $this->stock;
    }

    public function availableStock()
    {
        return max(0, $this->stock - $this->activeBorrowingsCount());
    }
}
