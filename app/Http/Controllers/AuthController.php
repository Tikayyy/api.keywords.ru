<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/register",
     *     operationId="/api/register",
     *     tags={"register"},
     *     @OA\Parameter(
     *         name="register",
     *         in="path",
     *         description="Method for registretion",
     *         required=true,
     *         @OA\JsonContent(
     *                  required={"name","email", "password", "password_confirmation"},
     *                  @OA\Property(property="name", type="string", format="text", example="user1"),
     *                  @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *                  @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *                  @OA\Property(property="password_confirmation", type="string", format="password", example="PassWord12345"),
     *              ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="User created successfully",
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="Error: Cannot create user.",
     *     ),
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="/api/login",
     *     tags={"login"},
     *     @OA\Parameter(
     *         name="login",
     *         in="path",
     *         description="Method for log in",
     *         required=true,
     *         @OA\JsonContent(
     *                  required={"email", "password"},
     *                  @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *                  @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *              ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Logged in",
     *     ),
     *     @OA\Response(
     *         response="409",
     *         description="Error: Unauthorized.",
     *     ),
     * )
     */

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     operationId="/api/logout",
     *     tags={"logout"},
     *     @OA\Parameter(
     *         name="logout",
     *         in="path",
     *         description="Method for log out",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Logged out",
     *     ),
     * )
     */


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
