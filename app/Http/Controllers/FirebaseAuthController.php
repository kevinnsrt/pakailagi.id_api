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

public function getUserdata(Request $request){
    $data = User::where('id',$request->uid)->get();
    return response()->json($data);
}

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


}

