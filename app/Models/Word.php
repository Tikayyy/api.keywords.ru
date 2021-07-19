<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    public function keyWords(){
        return $this->belongsToMany('Image', 'image_word', 'word_id', 'image_id');
    }
}
