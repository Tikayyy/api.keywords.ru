<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function words(){
        return $this->belongsToMany('App\Models\Word', 'word_image', 'image_id', 'word_id');
    }
}
