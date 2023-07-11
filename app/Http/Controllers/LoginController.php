<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User login",
     *     description="Authenticate user and generate a bearer token",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     description="User's email",
     *                     type="string",
     *                     example="admin@weroad.it"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="User's password",
     *                     type="string",
     *                     example="admin"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="token",
     *                     description="Bearer token for authentication",
     *                     type="string",
     *                     example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     description="User's name",
     *                     type="string",
     *                     example="Jhon"
     *                 ),
     *                 @OA\Property(
     *                     property="role",
     *                     description="User's role",
     *                     type="string",
     *                     example="admin"
     *                 ),
     *                 @OA\Property(
     *                     property="email_verified_at",
     *                     description="Verification time",
     *                     type="string",
     *                     example="2023-07-10T23:10:58.000000Z"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="success",
     *                     description="Error status",
     *                     type="boolean",
     *                     example="true"
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     description="Error message",
     *                     type="string",
     *                     example="The provided credentials are incorrect."
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required'],
                'password' => ['required']
            ]);

            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                $success['token'] =  $user->createToken('access_token')->plainTextToken;
                $success['name'] =  $user->name;
                $success['role'] =  $user->role->name;
                $success['email_verified_at'] =  $user->email_verified_at;

                return $this->sendResponse($success, 'User login successfully.');
            }

            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.']
            ]);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}
