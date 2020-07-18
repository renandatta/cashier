<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterialCategory extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'description'
    ];
}
