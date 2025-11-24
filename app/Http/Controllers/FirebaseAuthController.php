<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use App\Models\User;

class FirebaseAuthController extends Controller
{
    //

   public function register(Request $request)
{
    $validated = $request->validate([
        'uid' => 'required|string',
        'username' => 'required|string',
        'number' => 'required|string',
        'location' => 'required|string',
    ]);

    // 1. Verifikasi Firebase ID Token
    $firebase = app('firebase.auth');

    try {
        $verifiedIdToken = $firebase->verifyIdToken($request->bearerToken());
    } catch (\Exception $e) {
        return response()->json(['error' => 'Invalid Firebase token'], 401);
    }

    // 2. Simpan ke database
    $user = User::create([
        'uid' => $validated['uid'],
        'username' => $validated['username'],
        'number' => $validated['number'],
        'location' => $validated['location'],
    ]);

    return response()->json([
        'message' => 'User registered',
        'user' => $user
    ], 200);
}

}
