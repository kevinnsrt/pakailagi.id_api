<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FirebaseAuthMiddleware
{
    protected $firebaseAuth;

    public function __construct(FirebaseAuth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }


   public function handle(Request $request, Closure $next): Response
{
    $token = $request->bearerToken();

    if (!$token) {
        return response()->json(['error' => 'No token'], 401);
    }

    try {
        $verified = $this->firebaseAuth->verifyIdToken($token);
        $uid = $verified->claims()->get('sub');

        // inject uid ke request
        $request->merge([
            'uid' => $uid
        ]);

    } catch (\Throwable $e) {
        return response()->json([
            'error' => 'Invalid token',
            'message' => $e->getMessage()
        ], 401);
    }

    return $next($request);
}


}
