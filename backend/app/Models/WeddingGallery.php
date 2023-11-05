<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeddingGallery extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'wedding_galleries';
    protected $fillable = [
        'file',
        'type',
        'wedding_id',
    ];
    
    
    protected static function newFactory()
    {
        return \Database\Factories\WeddingGalleryFactory::new();
    }

    /**
    *
    *  RELATION
    *
    * ---------------------------------------------------------------------
    */

    // Wedding
    public function wedding()
    {
        return $this->belongsTo('App\Models\Wedding');
    }

    /**
    *
    *  METHOD
    *
    * ---------------------------------------------------------------------
    */

    /**
     * Update if there is wedding gallery, insert if there is no wedding gallery
     *
     * @return 
     */
    public static function update_or_create($wedding, $request)
    {
        foreach ($request->galleries as $request_data) {
            $id_request_data = $request_data['id'] ?? null;
    
            WeddingGallery::updateOrCreate(
                ['id' => $id_request_data],
                [
                    'file' => $request_data['file'],
                    'wedding_id' => $wedding->id,
                ]
            );
        }
    }

    /**
     * Delete wedding gallery not in request
     *
     * @return 
     */
    public static function delete_not_in_request($existing_galleries, $request)
    {
        if($existing_galleries){
            foreach ($existing_galleries as $existing_gallery) {
                $found_in_request = false;
                foreach ($request->galleries as $request_data) {
                    if (isset($request_data['id']) && $existing_gallery->id === $request_data['id']) {
                        $found_in_request = true;
                        break;
                    }
                }
                if (!$found_in_request) {
                    $existing_gallery->forceDelete();
                }
            }
        }
    }
}
