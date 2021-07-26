<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Word_Image;
use Illuminate\Http\Request;
use App\Models\Word;

class WordController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/keyword",
     *     operationId="/api/keyword",
     *     @OA\Parameter(
     *         name="Adding keyword",
     *         in="path",
     *         description="Method for adding keyword",
     *         required=true,
     *         @OA\JsonContent(
     *                  required={"popularity"},
     *                  @OA\Property(property="text", type="string", format="text", example="Word1"),
     *                  @OA\Property(property="rus_text", type="string", format="text", example="Слово1"),
     *                  @OA\Property(property="popularity", type="float", format="number", example="0.2"),
     *              ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="ADDED",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="Error: Cannot added keyword.",
     *     ),
     * )
     */

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

    /**
     * @OA\Post(
     *     path="/api/keyword/{image_id}",
     *     operationId="/api/keyword/{image_id}",
     *     @OA\Parameter(
     *         name="Adding keyword to image",
     *         in="path",
     *         description="Method for adding keyword to image",
     *         required=true,
     *         @OA\JsonContent(
     *                  required={"text or rus_text", "image_id in url"},
     *                  @OA\Property(property="text", type="string", format="text", example="Word1"),
     *                  @OA\Property(property="rus_text", type="string", format="text", example="Слово1"),
     *              ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="DONE",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="Error: Cannot create keyword.",
     *     ),
     * )
     */

    public function addKeywordToImage(Request $request)
    {
        try {
            $text = $request->input('text');
            $rus_text = $request->input('rus_text');
            $image_id = $request->route('image_id');

            $word = new Word;
            $word->text = $text;
            $word->rus_text = $rus_text;
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

    /**
     * @OA\Get(
     *     path="/api/keywords",
     *     operationId="/api/keywords",
     *     @OA\Parameter(
     *         name="Showing keywords",
     *         in="path",
     *         description="Method for showing keywords",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Showing words",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="Error: Cannot show words.",
     *     ),
     * )
     */

    public function showKeyword(Request $request)
    {
        try {
            $word = Word::all();
            return response()->json(['success' => 'true', 'message' => 'Words', 'data' => $word], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'Cannot show words', 'error_code' => 409, 'data' => $word], 409);
        }
    }
}
