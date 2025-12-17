<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use App\Models\User;

class FirebaseAuthController extends Controller
{
 
// register native
public function register(Request $request)
{
        // buat user
    $user = User::create([
    'id' => $request->uid,
    'name' => $request->username,
    'role' => 'client',
    'number' => $request->number,
    'latitude' => $request->latitude,
    'longitude' => $request->longitude,
    ]); 

    return response()->json([
    'status' => 'success',
    'user' => $user
    ]);
}

// mengambil data user
public function getUserdata(Request $request){
    $data = User::where('id',$request->uid);
    return response()->json($data);
}

// register google
public function registerGoogle(Request $request)
{
        
            $user = User::firstOrCreate([
            'id' => $request->uid],
            [
            'name' => $request->username,
            'role' => 'client',
            'number' => $request->number,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            ]);

        return response()->json([
            'status' => 'success',
            'user' => $user
        ]);
}

// update lokasi user
public function updateLocation(Request $request)
{
    $validated = $request->validate([
        'uid'=> 'required',
        'latitude'=> 'required|numeric|between:-90,90',
        'longitude'=> 'required|numeric|between:-180,180',
    ]);

    $user = User::where('id', $validated['uid'])->first();

    if (!$user) {
        return response()->json([
            'message' => 'User tidak ditemukan'
        ], 404);
    }

    $user->update([
        'latitude' => $validated['latitude'],
        'longitude' => $validated['longitude'],
    ]);

    return response()->json([
        'message'=> 'Lokasi berhasil di-update',
        'user' => $user,
    ]);
}


}

