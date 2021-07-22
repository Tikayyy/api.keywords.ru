<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    public function images(){
        return $this->belongsToMany('App\Models\Image', 'word_image', 'word_id', 'image_id');
    }
}
