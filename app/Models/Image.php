<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{

    /**
     * @OA\Schema(
     *     schema="Images",
     *     @OA\Property(property="id", type="number"),
     *     @OA\Property(property="name", type="string"),
     * )
     */

    public function words(){
        return $this->belongsToMany('App\Models\Word', 'word_image', 'image_id', 'word_id');
    }
}
