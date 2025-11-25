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
    try {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'No token provided'], 401);
        }

        $auth = app('firebase.auth');
        $verified = $auth->verifyIdToken($token);

        $userData = $verified->claims();

        // buat user
        $user = User::create([
            'uid' => $request->uid,
            'name' => $request->username,
            'role' => 'client',
            'number' => $request->number,
            'location' => $request->location,
        ]);

        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function getUserdata(Request $request){
    $data = User::where('uid',$request->uid)->get();
    return response()->json($data);
}


}
