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

}

public function getUserdata(Request $request){
    $data = User::where('uid',$request->uid)->get();
    return response()->json($data);
}


}
