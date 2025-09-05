<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Flasher\Toastr\Laravel\Facade\Toastr;

class ResetPasswordController extends Controller
{
    public function show($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle the password reset.
     */
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
            'message' => 'Invalid token or email.'
        ])->withInput($request->only('email'));
    }
}
