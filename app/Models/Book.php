<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $guarded = [
        'id'
    ];

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'book_id', 'id');
    }
}
