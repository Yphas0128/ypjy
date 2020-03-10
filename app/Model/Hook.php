<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Hook extends Model
{
    //
    protected $fillable = ['name', 'controller_action','api','content'];
}
