<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function keyWords(){
        return $this->belongsToMany('Word', 'image_word', 'image_id', 'word_id');
    }
}
