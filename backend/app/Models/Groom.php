<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groom extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'grooms';
    protected $fillable = [
        'name',
        'father',
        'mother',
        'address',
        'instagram',
        'image',
        'wedding_id',
    ];
    
    protected static function newFactory()
    {
        return \Database\Factories\GroomFactory::new();
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
