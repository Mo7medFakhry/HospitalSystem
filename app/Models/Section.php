<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use Translatable;


    protected $guarded = [];
    public $translatedAttributes = ['name'];


    use HasFactory;
}
