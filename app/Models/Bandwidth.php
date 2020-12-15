<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandwidth extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rate_down',
        'rate_down_unit',
        'rate_up',
        'rate_up_unit'
    ];
    
}
