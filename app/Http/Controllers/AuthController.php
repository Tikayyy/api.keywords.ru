<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['success' => 'true', 'message' => 'CREATED', 'data' => $user], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['success' => 'false', 'message' => 'User Registration Failed!', 'error_code' => 409, 'data' => $user], 409);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
          //validate incoming request
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['success' => 'false', 'message' => 'Unauthorized', 'error_code' => 209, 'data' => $credentials], 209);
        }

        return $this->respondWithToken(['success' => 'true', 'message' => 'Authorized', 'error_code' => 401, 'data' => $token]);
    }

    public function logout()
    {
        Auth()->logout();

        return response()->json(['success' => 'true', 'message' => 'Successfully logged out', 'data' => NULL]);
    }
}
