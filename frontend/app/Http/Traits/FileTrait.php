<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileTrait 
{
    public static function store_file($old_file, $request_file, $folder)
    {
        if (isset($request_file)) {
            
            // Delete Before Insert New file
            if ($old_file != null) {
                // Rpelace Directory
                $old_file = Str::replace('storage', 'public', $old_file);
                Storage::disk('local')->delete($old_file);
            }

            // Insert New file
            $dir_file = $request_file->store('public/'. $folder);

            // Replace Directory
            $file = Str::replace('public', 'storage', $dir_file);

            return $file;
        }

        return $old_file;
    }
}