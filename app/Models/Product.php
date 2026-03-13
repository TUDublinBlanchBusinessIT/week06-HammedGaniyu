<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product'; // important: matches your DB table

    protected $fillable = [
        'name', 'description', 'colour', 'price', 'image',
    ];
}