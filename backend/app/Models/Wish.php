<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wish extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'wishes';
    protected $fillable = [
        'name',
        'from',
        'wish',
        'wedding_id',
    ];
    
    protected static function newFactory()
    {
        return \Database\Factories\WishFactory::new();
    }

    /**
    *
    *  RELATION
    *
    * ---------------------------------------------------------------------
    */

    // Wedding
    public function wedding()
    {
        return $this->belongsTo('App\Models\Wedding');
    }

    /**
    *
    *  METHOD
    *
    * ---------------------------------------------------------------------
    */
}
