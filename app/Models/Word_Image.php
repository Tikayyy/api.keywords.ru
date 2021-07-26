<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word_Image extends Model
{
    /**
     * @OA\Schema(
     *     schema="Word_Image",
     *     @OA\Property(property="id", type="number"),
     *     @OA\Property(property="image_id", type="integer"),
     *     @OA\Property(property="word_id", type="integer"),
     * )
     */

    protected $table = 'word_image';
}
