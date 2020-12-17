<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prepaid extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'router_id',
        'plan_id',
        'start_dt',
        'expire_dt',
        'validity',
        'status'
    ];
    
    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }
    
    public function router()
    {
        return $this->hasOne('App\Models\Router','id','router_id');
    }
    
    public function plan()
    {
        return $this->hasOne('App\Models\Plan','id','plan_id');
    }
    
}
