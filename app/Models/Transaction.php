<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'username',
        'plan_name',
        'amount',
        'start_dt',
        'expire_dt',
        'status',
        'type',
        'p_method',
        'p_trxid',
        'seller_id',
        'created_by'
    ];
    
    public function createdBy()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }
    
}
