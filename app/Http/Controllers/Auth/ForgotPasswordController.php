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
    public function send(SendResetLinkRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->back()->with('toast', [
                'type' => 'success',
                'message' => 'Password reset link sent'
            ]);
        }

        return redirect()->back()->with('toast', [
            'type' => 'error',
            'message' => __($status)
        ]);
    }
}
