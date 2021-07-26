<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{

    /**
     * @OA\Schema(
     *     schema="Words",
     *     @OA\Property(property="id", type="number"),
     *     @OA\Property(property="text", type="string"),
     *     @OA\Property(property="rus_text", type="string"),
     *     @OA\Property(property="popularity", type="float"),
     * )
     */

    public function images(){
        return $this->belongsToMany('App\Models\Image', 'word_image', 'word_id', 'image_id');
    }
}
