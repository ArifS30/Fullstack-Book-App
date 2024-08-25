<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class BooksModels extends Model
{
    use HasFactory,HasUuids;

    protected $table = 'books';
    protected $fillable = [
        'title',
        'summary',
        'image',
        'stock',
        'category_id',
    ];

    protected $hidden = [
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(CategoriesModels::class, 'category_id', 'id');
    }


    public function listBorrows()
    {
        return $this->hasMany(BorrowsModels::class, 'book_id', 'id');
    }


}
