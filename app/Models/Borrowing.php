<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'borrower_name',
        'book_id',
        'borrow_date',
        'return_date',
        'status',
        'notes',
        'fine',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Accessor to determine borrowing type (online/offline)
    public function getTypeAttribute()
    {
        return $this->user_id ? 'online' : 'offline';
    }

    // Scope for online borrowings
    public function scopeOnline($query)
    {
        return $query->whereNotNull('user_id');
    }

    // Scope for offline borrowings
    public function scopeOffline($query)
    {
        return $query->whereNull('user_id');
    }

    // Get borrower display name
    public function getBorrowerDisplayNameAttribute()
    {
        return $this->user_id ? $this->user->name : $this->borrower_name;
    }
}
