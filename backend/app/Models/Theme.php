<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'img_preview',
        'description',
        'price',
        'package_id',
    ];

    /**
    *
    *  RELATION
    *
    * ---------------------------------------------------------------------
    */

    // Package
    public function package()
    {
        return $this->belongsTo('App\Models\Package');
    }

    // Order
    public function order()
    {
        return $this->hasMany('App\Models\Order');
    }
}
