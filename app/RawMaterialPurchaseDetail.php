<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed qty
 * @property mixed price
 */
class RawMaterialPurchaseDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'raw_material_purchase_id', 'raw_material_id', 'qty', 'price', 'status'
    ];

    public function raw_material_purchase()
    {
        return $this->belongsTo(RawMaterialPurchase::class);
    }

    public function raw_material()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function getTotalAttribute()
    {
        return $this->qty * $this->price;
    }
}
