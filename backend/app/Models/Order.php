<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    protected $table = 'orders';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\OrderFactory::new();
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

    // Package
    public function package()
    {
        return $this->belongsTo('App\Models\Package');
    }

    // Theme
    public function theme()
    {
        return $this->belongsTo('App\Models\Theme');
    }

    // Invitation
    public function invitation()
    {
        return $this->hasOne('App\Models\Invitation');
    }

    // Payment
    public function payment()
    {
        return $this->hasOne('App\Models\Payment');
    }

    /**
     *
     *  METHOD
     *
     * ---------------------------------------------------------------------
     */
}
