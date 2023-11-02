<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rsvp extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'rsvps';

    protected $fillable = [
        'name',
        'amount_guest',
        'is_attend',
        'invitation_id',
        'guest_id',
    ];
    
    protected static function newFactory()
    {
        return \Database\Factories\RsvpFactory::new();
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
