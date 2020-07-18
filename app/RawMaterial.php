<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterial extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'raw_material_category_id', 'code', 'name', 'tag', 'description', 'price', 'unit'
    ];

    public function raw_material_category()
    {
        return $this->belongsTo(RawMaterialCategory::class);
    }
}
