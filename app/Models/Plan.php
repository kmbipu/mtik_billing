<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pool_id',
        'bandwidth_id',
        'price',
        'discount',
        'validity',
        'validity_unit',
        'reseller_id'
    ];

    public function bandwidth()
    {
        return $this->hasOne('App\Models\Bandwidth','id','bandwidth_id');
    }

}
