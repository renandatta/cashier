<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RawMaterialPurchase extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'no_transaction', 'status', 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function raw_material_purchase_details()
    {
        return $this->hasMany(RawMaterialPurchaseDetail::class)
            ->with('raw_material')
            ->orderBy('id', 'asc');
    }
}
