<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'guests';

    protected $fillable = [
        'name',
        'description',
        'address',
        'is_invited',
        'no_whats_app',
        'email',
        'invitation_id',
    ];
    
    protected static function newFactory()
    {
        return \Database\Factories\GuestFactory::new();
    }

    /**
    *
    *  RELATION
    *
    * ---------------------------------------------------------------------
    */

    // Invitation
    public function invitation()
    {
        return $this->belongsTo('App\Models\Invitation');
    }

    /**
    *
    *  METHOD
    *
    * ---------------------------------------------------------------------
    */
}
