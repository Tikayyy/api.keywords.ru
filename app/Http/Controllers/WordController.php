<?php

namespace App\Http\Controllers;

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
            $word->popularity = $request->input('popularity');

            $word->save();

            //return successful response
            return response()->json(['success' => 'true', 'message' => 'ADDED', 'data' => $word], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'Cannot added!', 'error_code' => 409, 'data' => $word], 409);
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
