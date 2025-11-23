<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use App\Models\User;

class FirebaseAuthController extends Controller
{
    //

    public function login(Request $request, FirebaseAuth $auth)
    {
        $idToken = $request->input('token');

        try {
            // 🔥 Verifikasi Token Firebase
            $verifiedIdToken = $auth->verifyIdToken($idToken);
            $firebaseUid = $verifiedIdToken->claims()->get('sub');

            // Ambil data user dari Firebase
            $firebaseUser = $auth->getUser($firebaseUid);

            // 🔥 Buat user ke database kalau belum ada
            $user = User::firstOrCreate(
                ['firebase_uid' => $firebaseUid],
                [
                    'name'  => $firebaseUser->displayName ?? 'No Name',
                    'email' => $firebaseUser->email,
                ]
            );

            // 🔥 Buat Sanctum Token / API Token
            $token = $user->createToken('mobile')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 401);
        }
    }
}
