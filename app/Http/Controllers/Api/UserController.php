<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller 
{
    /* public function __construct()
    {
        $this->middleware('can:auth-clients');
    } */

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'could_not_create_token'], 500);
        }

        $user = JWTAuth::user();
        //Crear token en tabla personal_access_token

        $tokenOne = $request->user()->createToken('token');
         
        //return ['token' => $token/* One->plainTextToken */];

        return response()->json(compact('token', 'user'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        $user = User::create([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'password'=>Hash::make($request->get('password'))
        ]);

        $token = JWTAuth::fromUser($user);

        

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['message' => 'user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['message' => 'token_expired'], /* $e->getStatusCode() */ 400);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'token_invalid'], /* $e->getStatusCode() */ 400);
        } catch (JWTException $e) {
        return response()->json(['message' => 'token_absent'], /*$e->getStatusCode()*/ 400 );
        }
        return response()->json(compact('user') , 200);
    }

    public function logout(Request $request)
    {
        // https://laravel.com/docs/8.x/queries#delete-statements
        $request->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}
