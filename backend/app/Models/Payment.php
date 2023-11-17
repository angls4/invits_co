<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'total_price',
        'type',
        'transaction_id',
        'transaction_time',
        'transaction_status',
        'user_id',
        'order_id',
    ];

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

    /**
    *
    *  METHOD
    *
    * ---------------------------------------------------------------------
    */

    /**
     * Midtrans Payment
     *
     * @return 
     */
    public static function midtrans($user, $order, $payment)
    {
        // Mock for testing
        if(env('APP_ENV') == 'testing' 
        // || env('APP_ENV') == 'local'
        ) return "test-dummy-snap-token-orderId:$order->id";

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $payment->total_price,
            ),
            'customer_details' => array(
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->mobile,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return  $snapToken;
    }
}
