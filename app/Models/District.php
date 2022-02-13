<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{

    use HasFactory;

    public $fillable = ['enum', 'enumName', 'tags', 'city'];
    protected $casts = [
        'tags' => 'array'
    ];
}
