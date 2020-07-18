<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'no_id', 'name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
