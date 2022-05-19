<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class scene extends Model
{
    use HasFactory;
    protected $fillable = [
        'bg_path',
        'text',
    ];
}
