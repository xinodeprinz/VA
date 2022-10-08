<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    public function verify()
    {
        $user = Auth::user();
        if ($user->email_verified_at) {
            return redirect()->route('home');
        }

        return view('auth.verify');
    }

    public function fulfill(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('home');
    }

    public function notification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'A fresh verification link has been sent to your email address.');
    }
}