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
    /**
     * @OA\Post(
     *     path="/api/images",
     *     operationId="/api/images",
     *     tags={"Upload image"},
     *     @OA\Parameter(
     *         name="upload image",
     *         in="path",
     *         description="Method for uploading images",
     *         required=true,
     *         @OA\JsonContent(
     *                  required={"image"},
     *                  @OA\Property(property="images", type="file", format="file", example="C:/images/123.png"),
     *              ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="UPLOADED",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="Error: Cannot upload image.",
     *     ),
     * )
     */

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
            return response()->json(['success' => 'false', 'message' => 'Cannot upload image', 'error_code' => 409, 'data' => $image], 409);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/images/{id}",
     *     operationId="/api/images/{id}",
     *     tags={"Delete image"},
     *     @OA\Parameter(
     *         name="delete image",
     *         in="path",
     *         description="Method for deleting images",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="DELETED",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="Error: Cannot deleted image.",
     *     ),
     * )
     */

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

    /**
     * @OA\Put(
     *     path="/api/images/{id_image}/{id_word}",
     *     operationId="/api/images/{id_image}/{id_word}",
     *     tags={"Bind keyword with image"},
     *     @OA\Parameter(
     *         name="Bind keyword with image",
     *         in="path",
     *         description="Method for bind keyword with image",
     *         required=true,
     *         @OA\JsonContent(
     *                  required={"image_id in url", "word_id in url"},
     *              ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="DONE",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="Error: Cannot bind keyword with image.",
     *     ),
     * )
     */

    public function changeImage(Request $request)
    {
        $this->validate($request, [
            'text' => 'string',
            'rus_text' => 'string',
        ]);

        try {// need to change
            $image_id = $request->route('id_image');
            $word_id = $request->route('id_word');

            $word_image_id = new Word_Image;
            $word_image_id->image_id = $image_id;
            $word_image_id->word_id = $word_id;

            $word_image_id->save();

            //return successful response
            return response()->json(['success' => 'true', 'message' => 'DONE', 'data' => $word_image_id], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'Cannot bind keyword with image', 'error_code' => 409, 'data' => $word_image_id], 409);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/images",
     *     operationId="/api/images",
     *     tags={"Getting images using keyword"},
     *     @OA\Parameter(
     *         name="Getting images using keyword",
     *         in="path",
     *         description="Method for getting images using keyword",
     *         required=true,
     *         @OA\JsonContent(
     *                  required={"keyword"},
     *                  @OA\Property(property="keyword", type="strind", format="text", example="Word1"),
     *              ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="DONE",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="Error: Cannot find image.",
     *     ),
     * )
     */

    public function getImage(Request $request)
    {
        try {
            $word_id = $request->input('keyword');
            $word = Word::find($word_id)->first();

            $image = $word->images;

            //return successful response
            return response()->json(['success' => 'true', 'message' => 'DONE', 'data' => $image], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'Cannot find image', 'error_code' => 409, 'data' => NULL], 409);
        }
    }


}
