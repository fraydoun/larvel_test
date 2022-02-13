<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    const CATEGORY_ADS = 'ads';


    public $table = 'category';

    public $fillable = ['title', 'parent', 'icon', 'category'];

    /** get parent relation */
    public function relParent(){
        return $this->belongsTo(self::class, 'parent');
    }

    /** get childs relation */
    public function relChilds(){
        return $this->hasMany(self::class, 'parent');
    }

    /** get form relation each category */
    public function relForm(){
        return $this->belongsToMany(FormItem::class, 'category_form');
    }
}
