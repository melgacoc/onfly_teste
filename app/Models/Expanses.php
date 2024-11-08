<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Expanses extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'description',
        'date',
        'user_id',
    ];
}