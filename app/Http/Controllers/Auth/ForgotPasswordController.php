<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Auth\SendResetLinkRequest;

class ForgotPasswordController extends Controller
{
    // Show forgot password form
    public function show()
    {
        return view('auth.forgot-password');
    }

    // Handle sending password reset link
    public function reset(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
    
                Auth::login($user);
            }
        );
    
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('dashboard')->with('toast', [
                'type' => 'success',
                'message' => 'Password has been reset!'
            ]);
        }
    
        return back()->with('toast', [
            'type' => 'error',
            'message' => __($status)
        ])->withInput($request->only('email'));
    }
}
