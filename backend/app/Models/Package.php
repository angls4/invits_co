<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'packages';

    /**
    *
    *  RELATION
    *
    * ---------------------------------------------------------------------
    */

    // Order
    public function order()
    {
        return $this->hasMany('App\Models\Order');
    }

    // Theme
    public function theme()
    {
        return $this->hasMany('App\Models\Theme');
    }

    /**
    *
    *  METHOD
    *
    * ---------------------------------------------------------------------
    */
}
