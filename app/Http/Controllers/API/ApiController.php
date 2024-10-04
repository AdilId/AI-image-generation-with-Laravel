<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'email|required',
            'password' => 'required|confirmed',
        ]);


        if ($request->hasFile('image')) {
            $imageDirectory = public_path('images/usersImages');

            if (!file_exists($imageDirectory)) {
                mkdir($imageDirectory, 0755, true);
            }

            $newImageName = uniqid() . '-' . $request->name . '.jpg';
            $request->image->move($imageDirectory, $newImageName);

            User::create([
                'name' =>  $request->name,
                'email' =>  $request->email,
                'password' =>  Hash::make($request->password),
                'image_url' => $newImageName
            ]);
        } else {
            User::create([
                'name' =>  $request->name,
                'email' =>  $request->email,
                'password' =>  Hash::make($request->password),
                'image_url' => null
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully.',
        ]);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('myToken')->accessToken;
            return response()->json([
                'status' => true,
                'message' => 'User Logged Successfully.',
                'token' => $token,
                'owner' => $user
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid Login Details',
            ]);
        }
    }
    public function profile() {
        $user = Auth::user();

        return response()->json([
            'status' => true,
            'message' => 'Profile Information',
            'profile' => $user
        ]);
    }

    public function updateImg(Request $request) {

        if (!$request->image) {
            return response()->json("Doesn't update.");
        }

        $request->validate([
            'image' => 'required'
        ]);

        $user = User::where('email', Auth::user()->email)->first();

        $imageDirectory = public_path('images/usersImages');

        if (!file_exists($imageDirectory)) {
            mkdir($imageDirectory, 0755, true);
        }

        $newImageName = uniqid() . '-' . $user->name . '-updated' . '.jpg';
        $request->image->move($imageDirectory, $newImageName);

        $user->update([
            'image_url' => $newImageName,
        ]);

        return response()->json("Updated Successfully.");

    }

    public function updatePassword(Request $request) {
        $request->validate([
            'currentPassword' => 'required',
            'newPassword' => ['required', 'regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,16}$/']
        ]);

        $user = User::where('email', Auth::user()->email)->first();


        if ($user && Hash::check($request->currentPassword, $user->password)) {
            $user->update([
                'password' => Hash::make($request->newPassword),
            ]);

            return response()->json("Password Changed Successfully.");
        }

        return response()->json("Incorrect Information");
    }

    public function logout() {
        auth()->user()->token()->revoke();
        return response()->json([
            'status' => true,
            'message' => 'User Logged out',
        ]);
    }
}
