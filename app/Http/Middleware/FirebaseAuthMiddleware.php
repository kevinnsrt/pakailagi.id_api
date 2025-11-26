<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth;
use Symfony\Component\HttpFoundation\Response;

class FirebaseAuthMiddleware
{

 protected $tokenVerifier;

    public function __construct(Verifier $tokenVerifier)
    {
        $this->tokenVerifier = $tokenVerifier;
    }

    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');

        if (!$header || !preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            return response()->json(['message' => 'Unauthorized: Token not provided'], 401);
        }

        $idToken = $matches[1];

        try {
            $verifiedIdToken = $this->tokenVerifier->verifyIdToken($idToken);
            $request->attributes->set('firebase_uid', $verifiedIdToken->claims()->get('sub'));
            // Optionally, you can also retrieve and set other claims like email, etc.
        } catch (InvalidToken $e) {
            return response()->json(['message' => 'Unauthorized: Invalid token'], 401);
        }

        return $next($request);
    }
}
