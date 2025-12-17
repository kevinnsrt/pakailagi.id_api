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
        $uid = $verified->claims()->get('sub'); // Firebase UID

        // fcm_token
         $fcmToken = $request->header('X-FCM-TOKEN')
            ?? $request->input('fcm_token');

        // PK = UID
        $user = User::firstOrCreate(
            ['id' => $uid],
            [
                'name' => $request->username,
                'role' => 'client',
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'number' => $request->number,
                'fcm_token' => $fcmToken,   
            ]
        );

        // 🔥 Inject user ke request
        $request->attributes->set('auth_user', $user);
        $request->attributes->set('firebase_uid', $uid);

    } catch (\Throwable $e) {
        return response()->json([
            'error' => 'Invalid token',
            'message' => $e->getMessage()
        ], 401);
    }

    return $next($request);
}

}
