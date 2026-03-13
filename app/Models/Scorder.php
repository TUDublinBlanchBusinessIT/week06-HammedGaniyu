<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scorder extends Model
{
    use HasFactory;

    protected $table = 'scorders';
    protected $fillable = ['orderdate'];
}