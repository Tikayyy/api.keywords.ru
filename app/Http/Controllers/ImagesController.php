<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
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
            return response()->json(['image' => $image, 'path' => $destinationPath.DIRECTORY_SEPARATOR.$name, 'message' => 'UPLOADED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Cannot save image'], 409);
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
            return response()->json(['message' => 'DELETED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Cannot deleted image'], 409);
        }
    }
}
