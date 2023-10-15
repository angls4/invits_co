<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvitationType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'invitation_types';
    
    /**
    *
    *  RELATION
    *
    * ---------------------------------------------------------------------
    */

    // Invitation
    public function invitation()
    {
        return $this->hasMany('App\Models\Invitation');
    }
}
