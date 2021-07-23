<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Word;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Word_Image;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function upload(Request $request)
    {
        try {
            $file = $request->file('image');
            $name = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = storage_path('images');
            $file->move($destinationPath, $name);

            $image = new Image;
            $image->name = $name;

            $image->save();

            //return successful response
            return response()->json(['success' => 'true', 'message' => 'UPLOADED', 'data' => ['image' => $image, 'path' => $destinationPath.DIRECTORY_SEPARATOR.$name]], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'User Registration Failed!', 'error_code' => 409, 'data' => $image], 409);
        }
    }

    public function delete(Request $request)
    {
        try {
            $id = $request->route('id');
            $destinationPath = storage_path('images');

            $image = Image::find($id);
            unlink($destinationPath.DIRECTORY_SEPARATOR.$image->name);

            Image::destroy($id);

            //return successful response
            return response()->json(['success' => 'true', 'message' => 'DELETED', 'data' => NULL], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'Cannot deleted image', 'error_code' => 409, 'data' => NULL], 409);
        }
    }

    public function changeImage(Request $request)
    {
        $this->validate($request, [
            'text' => 'string',
            'rus_text' => 'string',
        ]);

        try {// need to change
            $image_id = $request->route('id_image');
            $word_id = $request->route('id_word');
            //$text = $request->input('text');
            // $image = Image::find($image_id);
            // $word = Image::find($word_id);

            $word_image_id = new Word_Image;
            $word_image_id->image_id = $image_id;
            $word_image_id->word_id = $word_id;

            $word_image_id->save();

            //return successful response
            return response()->json(['success' => 'true', 'message' => 'DONE', 'data' => $word_image_id], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'Cannot create keyword', 'error_code' => 409, 'data' => $word_image_id], 409);
        }
    }

    public function getImage(Request $request)
    {
        try {
            $word_id = $request->route('id_word');
            $word = Word::find($word_id)->first();

            $image = $word->images;

            //return successful response
            return response()->json(['success' => 'true', 'message' => 'DONE', 'data' => $image], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'Cannot create keyword', 'error_code' => 409, 'data' => NULL], 409);
        }
    }

    public function addCategory(Request $request)
    {
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
