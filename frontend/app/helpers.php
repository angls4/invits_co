<?php

use Vinkla\Hashids\Facades\Hashids;

if (! function_exists('encode_id')) {

    /**
     * Prepare the Column Name for Lables.
     */
    function encode_id($id)
    {
        $hashids = new Hashids(config('app.salt'), 3, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $hashid = $hashids::encode($id);

        return $hashid;
    }
}

/*
 *
 * Decode Id to a Hashids\Hashids
 *
 * ------------------------------------------------------------------------
 */
if (! function_exists('decode_id')) {

    /**
     * Prepare the Column Name for Lables.
     */
    function decode_id($hashid)
    {
        $hashids = new Hashids(config('app.salt'), 3, 'abcdefghijklmnopqrstuvwxyz1234567890');
        $id = $hashids::decode($hashid);

        if (count($id)) {
            return $id[0];
        } else {
            abort(404);
        }
    }
}
?>