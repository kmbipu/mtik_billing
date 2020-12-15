<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    use HasFactory;

    protected $fillable = [ 'name','ip_range','router_id'];


    public function router()
    {
        return $this->hasOne('App\Models\Router','id','router_id');
    }

}
