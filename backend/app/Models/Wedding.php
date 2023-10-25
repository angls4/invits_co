<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wedding extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'weddings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'location',
        'location_gmap',
        'rekening_gift',
        'invitation_id',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\WeddingFactory::new();
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

    // Groom
    public function groom()
    {
        return $this->hasOne('App\Models\Groom');
    }

    // Bride
    public function bride()
    {
        return $this->hasOne('App\Models\Bride');
    }

    // Wish
    public function wish()
    {
        return $this->hasMany('App\Models\Wish');
    }

    // Wish
    public function gift()
    {
        return $this->hasMany('App\Models\Gift');
    }

    // Wedding Event
    public function event()
    {
        return $this->hasMany('App\Models\WeddingEvent');
    }

    // Wedding Love Story
    public function love_story()
    {
        return $this->hasMany('App\Models\WeddingLoveStory');
    }

    // Wedding Gallery
    public function gallery()
    {
        return $this->hasMany('App\Models\WeddingGallery');
    }

    /**
    *
    *  METHOD
    *
    * ---------------------------------------------------------------------
    */
}
