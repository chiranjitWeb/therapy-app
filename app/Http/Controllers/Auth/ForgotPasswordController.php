<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Flasher\Toastr\Laravel\Facade\Toastr;

class ForgotPasswordController extends Controller
{
    public function show()
    {
        return view('auth.forgot-password');
    }

   
    public function send(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);
    
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
