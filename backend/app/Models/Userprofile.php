<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Userprofile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'username',
        'email',
        'mobile',
        'gender',
        'url_website',
        'url_facebook',
        'url_twitter',
        'url_instagram',
        'url_linkedin',
        'date_of_birth',
        'address',
        'bio',
        'avatar',
        'user_metadata',
        'last_ip',
        'login_count',
        'last_login',
        'email_verified_at',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
