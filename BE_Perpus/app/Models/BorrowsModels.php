<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class BorrowsModels extends Model
{
    use HasFactory,HasUuids;

    protected $table = 'borrows';
    protected $fillable = [
        'Load_date',
        'Borrow_date',
        'book_id',
        'user_id',
    ];

    public function listBook()
    {
        return $this->belongsTo(BooksModels::class, 'book_id', 'id');
    }


    public function listUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
