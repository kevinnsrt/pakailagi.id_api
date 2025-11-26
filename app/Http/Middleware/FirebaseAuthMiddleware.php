<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth;
use Symfony\Component\HttpFoundation\Response;

class FirebaseAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

        protected $firebaseAuth;
        public function __construct(Auth $firebaseAuth){

            $this->firebaseAuth = $firebaseAuth;
        }

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if(!$token){
            return response()->json([
                'error'=> 'Unauthorized'
            ],401);
        }

        try{
            $verifiedToken = $this->firebaseAuth->verifyIdToken($token);
            $request->attributes->add([
                'firebase_user'=> $verifiedToken->getClaim('sub')
            ]);
        }

        catch(\Exception $e){
            return response()->json([
                'error'=>'Unauthorized'
            ],401);
        }
        return $next($request);
    }
}
