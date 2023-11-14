<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait HelperTrait
{
    public static function dateID($date)
    {
        return \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y');
    }

    public static function storeImage($old_image, $request_image, $folder)
    {
        if (isset($request_image)) {
            if ($old_image != null) {
                // Delete Before Insert New Image
                // Rpelace Directory
                $old_image = Str::replace('storage', 'public', $old_image);
                Storage::disk('local')->delete($old_image);
            }
            // Insert New Image
            $dir_image = $request_image->store('public/'. $folder);

            // Replace Directory
            $image = Str::replace('public', 'storage', $dir_image);

            return $image;
        }

        return $old_image;
    }
}