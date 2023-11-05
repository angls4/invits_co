<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeddingLoveStory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'wedding_love_stories';
    protected $fillable = [
        'year',
        'story',
        'image',
        'wedding_id',
    ];
    
    protected static function newFactory()
    {
        return \Database\Factories\WeddingLoveStoryFactory::new();
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
     * Update if there is love story, insert if there is no love story
     *
     * @return 
     */
    public static function update_or_create($wedding, $request)
    {
        foreach ($request->love_stories as $request_data) {
            $id_request_data = $request_data['id'] ?? null;
    
            WeddingLoveStory::updateOrCreate(
                ['id' => $id_request_data],
                [
                    'year' => $request_data['year'],
                    'story' => $request_data['story'],
                    'image' => $request_data['image'],
                    'wedding_id' => $wedding->id,
                ]
            );
        }
    }

    /**
     * Delete love story not in request
     *
     * @return 
     */
    public static function delete_not_in_request($existing_love_stories, $request)
    {
        if($existing_love_stories){
            foreach ($existing_love_stories as $existing_love_story) {
                $found_in_request = false;
                foreach ($request->love_stories as $request_data) {
                    if (isset($request_data['id']) && $existing_love_story->id === $request_data['id']) {
                        $found_in_request = true;
                        break;
                    }
                }
                if (!$found_in_request) {
                    $existing_love_story->forceDelete();
                }
            }
        }
    }

}
