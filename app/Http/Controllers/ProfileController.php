<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

public function update(Request $request)
{
    // 🔥 Ambil UID dari middleware Firebase
    $uid = $request->attributes->get('firebase_uid');

    if (!$uid) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized (firebase uid missing)'
        ], 401);
    }

    $user = User::find($uid);

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'User tidak ditemukan atau tidak login'
        ], 401);
    }

    $request->validate([
        'name'            => 'nullable|string|max:255',
        'number'          => 'nullable|string|max:20',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
    ]);

    try {
        // Upload profile picture
        if ($request->hasFile('profile_picture')) {

            // Hapus foto lama jika ada
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')
                ->store('profile_pictures', 'public');

            $user->profile_picture = $path;
        }

        // Update field lain
        $user->update([
            'name'   => $request->name ?? $user->name,
            'number' => $request->number ?? $user->number,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data'    => [
                'id'                  => $user->id,
                'name'                => $user->name,
                'number'              => $user->number,
                'profile_picture_url' => $user->profile_picture ? url("/storage/{$user->profile_picture}") : null,
            ],
        ]);

    } catch (\Exception $e) {
        \Log::error('Update profile error: '.$e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Terjadi error saat update profile',
            'error'   => $e->getMessage(),
        ], 500);
    }
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
