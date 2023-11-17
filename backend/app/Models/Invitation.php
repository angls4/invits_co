<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

// Models
use App\Models\Wedding;
use App\Models\Bride;
use App\Models\Groom;
use App\Models\WeddingEvent;
use App\Models\WeddingGallery;
use App\Models\WeddingLoveStory;

class Invitation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'invitations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'slug',
        'is_custom_domain',
        'custom_domain',
        'user_id',
        'order_id',
        'invitation_type_id',
    ];

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

    //  Init Wedding Invitation
    public static function initWeddingInvitation($order){
        $invitation = Invitation::create([
            'user_id'               => $order->user_id,
            'invitation_type_id'    => 1,
            'status'                => 'INCOMPLETE',
            'slug'                  => Str::slug($order->user->name . " " . Str::random(10), '-'),
            'is_custom_domain'      => false,
            'order_id'              => $order->id,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        $wedding = Wedding::create([
            'invitation_id'         => $invitation->id,
        ]);

        Bride::create([
            'wedding_id'         => $wedding->id,
        ]);

        Groom::create([
            'wedding_id'         => $wedding->id,
        ]);

        WeddingEvent::create([
            'wedding_id'         => $wedding->id,
            'name'               => 'Akad Nikah',
        ]);

        WeddingEvent::create([
            'wedding_id'         => $wedding->id,
            'name'               => 'Resepsi',
        ]);

        WeddingEvent::create([
            'wedding_id'         => $wedding->id,
            'name'               => 'Unduh Mantu',
        ]);

        WeddingGallery::create([
            'wedding_id'         => $wedding->id,
            'file'               => "https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp"
        ]);

        WeddingGallery::create([
            'wedding_id'         => $wedding->id,
            'file'               => "https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp"
        ]);

        WeddingGallery::create([
            'wedding_id'         => $wedding->id,
            'file'               => "https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp"
        ]);

        WeddingGallery::create([
            'wedding_id'         => $wedding->id,
            'file'               => "https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp"
        ]);
        
        WeddingLoveStory::create([
            'wedding_id'         => $wedding->id,
            'image'              => "https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp",
            'year'               => "2021",
            'story'              => "Story 1",
        ]);

        WeddingLoveStory::create([
            'wedding_id'         => $wedding->id,
            'image'              => "https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp",
            'year'               => "2022",
            'story'              => "Story 2",
        ]);

        WeddingLoveStory::create([
            'wedding_id'         => $wedding->id,
            'image'              => "https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain2.webp",
            'year'               => "2023",
            'story'              => "Story 3",
        ]);
    }

    //  Get invitation by slug
    public static function get_by_slug($slug){
        return Invitation::where('slug', $slug)->first();
    }

    //  Get invitation by invitation id
    public static function get_by_id($id){
        return Invitation::where('id', $id)->first();
    }
}
