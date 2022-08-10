<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try{
            $user=JWTAuth::parseToken()->authenticate();
        } catch(TokenExpiredException $e){
            return response()->json(['error'=>'token_expired'],401);
        } catch(TokenInvalidException $e){
            return response()->json(['error'=>'token_invalid'],401);
        } catch(JWTException $e){
            return response()->json(['error'=>'token_absent'],401);
        } catch(Exception $e){
            return response()->json(['error'=> $e->getMessage()],500);
        }
        return $next($request);
    }
}
