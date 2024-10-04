<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function profile() {
        $user = Auth::user();
        return view('authViews.profile', compact('user'));
    }
    public function changeInformation(Request $request) {
        $user = Auth::user();
        return view('authViews.information', compact('user'));
    }
    public function updateInformation(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'currentPassword' => 'required',
            'newPassword' => ['required', 'regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.* ).{8,16}$/']
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->currentPassword, $user->password)) {
            $user->update([
                'password' => Hash::make($request->newPassword),
            ]);

            return redirect()->route('profile')->with('success', "Password changed.");
        }
        return redirect()->back()->withErrors([ 'currentPassword' => 'incorrect current password.' ])->onlyInput('currentPassword');
    }
}
