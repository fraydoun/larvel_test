<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormItem extends Model
{
    use HasFactory;

    public $table = 'form_item';

    protected $hidden = ['pivot'];
    
    protected $casts = [
        'settings' => 'array'
    ];

    protected $appends = ['name'];


    public function getNameAttribute()
    {
        return $this->attributes['slug'];
    }
}
