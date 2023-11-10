<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'username',
        'email',
        'mobile',
        'gender',
        'date_of_birth',
        'password',
        'avatar',
        'status',
        'role',
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {

            $userprofile = new Userprofile();
            $userprofile->user_id = $user->id;
            $userprofile->name = $user->name;
            $userprofile->first_name = $user->first_name;
            $userprofile->last_name = $user->last_name;
            $userprofile->username = $user->username;
            $userprofile->email = $user->email;
            $userprofile->mobile = $user->mobile;
            $userprofile->gender = $user->gender;
            $userprofile->date_of_birth = $user->date_of_birth;
            $userprofile->avatar = $user->avatar;
            $userprofile->status = ($user->status > 0) ? $user->status : 0;
            $userprofile->save();

        });
    }

    /**
    *
    *  RELATION
    *
    * ---------------------------------------------------------------------
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function providers()
    {
        return $this->hasMany('App\Models\UserProvider');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne('App\Models\Userprofile');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userprofile()
    {
        return $this->hasOne('App\Models\Userprofile');
    }

}
