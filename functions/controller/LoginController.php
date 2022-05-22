<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;
use Password;

class LoginController extends Controller
{
    /**
     * User login.
    **/

    public function login(Request $request) {
        
        $validator = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ]);

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            return response()->json(['errors' => 'invalid_login'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    /**
     * User logout. 
    */
    public function logout() {
        Auth::logout();
    }

    /**
     * Send password reset link. 
    */
    public function sendPasswordResetLink(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255'
        ]);

        if(User::where('email', $request->email)->exists()) {
            Password::sendResetLink($credentials);
            return response()->json([
                'success' => true,
                'message' => "Reset password link sent on your email id."
            ], 201); 
        }
        else {
            return response()->json([
                'success' => false,
                'errors' => "Email could not be sent to this email address."
            ], 401); 
        }
    }

    
    /**
     * Handle reset password 
     */
    public function callResetPassword(Request $request) {
        
       $credentials = request()->validate([
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:8'
        ]);

        if($request->uid) {
            User::where('id', $request->uid)->update([
                'password'=>Hash::make($request->password)
            ]);

            return response()->json([
                'success' => true,
                'message' => "Password has been successfully changed."
            ], 201);
        }
        
        return response()->json([
                'success' => false,
                'errors' => "Invalid token provided."
            ], 401); 
    }

    

}
