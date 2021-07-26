<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    /**
     * @OA\Schema(
     *     schema="Categorys",
     *     @OA\Property(property="id",     type="number"),
     *     @OA\Property(property="category", type="string"),
     * )
     */

    protected $table = 'categorys';
}
