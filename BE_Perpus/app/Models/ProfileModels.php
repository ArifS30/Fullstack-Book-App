<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class ProfileModels extends Model
{
    use HasFactory,HasUuids;

    protected $table = 'profiles';
    protected $fillable = [
        'bio',
        'age',
        'user_id',
    ];
}
