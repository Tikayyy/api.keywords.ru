<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *   title="Keywords API",
     *   version="1.0",
     *   @OA\Contact(
     *     email="yurkaon@gmail.com",
     *     name="Yuriy"
     *   )
     * )
     */

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }
}
