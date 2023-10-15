<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'invitations';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\InvitationFactory::new();
    }

    /**
     *
     *  RELATION
     *
     * ---------------------------------------------------------------------
     */

    // User
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    // Order
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    // Invitaion Type
    public function type()
    {
        return $this->belongsTo('App\Models\InvitationType', 'invitation_type_id');
    }

    // Wedding
    public function wedding()
    {
        return $this->hasOne('App\Models\Wedding');
    }

    // Guest
    public function guest()
    {
        return $this->hasMany('App\Models\Guest');
    }

    // RSVP
    public function rsvp()
    {
        return $this->hasMany('App\Models\Rsvp');
    }

    /**
     *
     *  METHOD
     *
     * ---------------------------------------------------------------------
     */
}
