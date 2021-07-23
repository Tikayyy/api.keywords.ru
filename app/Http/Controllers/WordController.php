<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Word_Image;
use Illuminate\Http\Request;
use App\Models\Word;

class WordController extends Controller
{
    public function addKeyword(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'text' => 'string',
            'rus_text' => 'string',
            'popularity' => 'required',
        ]);

        try {
            $word = new Word;

            $word->text = $request->input('text');
            $word->rus_text = $request->input('rus_text');
            if ($request->input('popularity') != NULL )
                $word->popularity = $request->input('popularity');
            else
                $word->popularity = 0;

            $word->save();

            //return successful response
            return response()->json(['success' => 'true', 'message' => 'ADDED', 'data' => $word], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'Cannot added!', 'error_code' => 409, 'data' => $word], 409);
        }
    }

    public function addKeywordToImage(Request $request)
    {
        try {
            $text = $request->input('text');
            $image_id = $request->route('image_id');

            $word = new Word;
            $word->text = $text;
            $word->rus_text = NULL;
            $word->popularity = 0;

            $word->save();

            $word_image_id = new Word_Image;
            $word_image_id->image_id = $image_id;
            $word_image_id->word_id = $word->id;

            $word_image_id->save();

            //return successful response
            return response()->json(['success' => 'true', 'message' => 'DONE', 'data' => $word_image_id], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'Cannot create keyword', 'error_code' => 409, 'data' => $word_image_id], 409);
        }
    }

    public function showKeyword(Request $request)
    {
        try {
            $word = Word::all();
            return response()->json(['success' => 'true', 'message' => 'Words', 'data' => $word], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'Something go wrong(', 'error_code' => 409, 'data' => $word], 409);
        }
    }
}
