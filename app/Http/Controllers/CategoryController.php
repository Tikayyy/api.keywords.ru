<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Word;
use App\Models\Word_Image;
use Illuminate\Http\Request;

class CategoryController extends Controller
{



    public function addCategory(Request $request)
    {

        /**
         * @OA\Post(
         *     path="/api/categorys",
         *     operationId="/api/categorys",
         *     tags={"Categorys"},
         *     @OA\Parameter(
         *         name="category",
         *         in="path",
         *         description="Controller using for creating new category",
         *         required=true,
         *         @OA\JsonContent(
         *                  required={"category", "text", "images"},
         *                  @OA\Property(property="category", type="string", format="text", example="Apple"),
         *                  @OA\Property(property="text", type="string", format="text", example="Word1"),
         *                  @OA\Property(property="images", type="file", format="file", example="C:/images/123.png"),
         *              ),
         *     ),
         *     @OA\Response(
         *         response="201",
         *         description="Category created",
         *         @OA\JsonContent()
         *     ),
         *     @OA\Response(
         *         response="409",
         *         description="Error: Cannot create category.",
         *     ),
         * )
         */

        try {
            $category = new Category;

            $category_name = $request->input('category');
            $category->category = $category_name;

            $category->save();

            $word = new Word;

            $word->text = $request->input('text');
            $word->category_id = $category->id;

            $word->save();

            $file = $request->file('image');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = storage_path('images');
            $file->move($destinationPath, $name);

            $image = new Image;
            $image->name = $name;

            $image->save();

            $word_image = new Word_Image;
            $word_image->word_id = $word->id;
            $word_image->image_id = $image->id;

            $word_image->save();
            //return successful response
            return response()->json(['success' => 'true', 'message' => 'Category created', 'data' => [$image, $word]], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'Cannot create category', 'error_code' => 409, 'data' => NULL], 409);
        }
    }
}
