<?php

namespace App\Http\Controllers;

use App\Mail\Verify;
use DateTime;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public function resendCode(Request $request)
    {
        $code = Help::verificationCode(5);
        $user = $request->user();
        Mail::to($user->email)->send(new Verify($user, $code));
        $request->session()->put('code', $code);
        return back()->with('success', 'Code sent successfully. Check your email address.');
    }

    public function verifyUser(Request $request)
    {
        $request->validate(['code' => 'required|string|size:5']);
        $code = $request->session()->get('code');

        if ($code !== $request->code) {
            return back()
                ->withErrors(['code' => 'Incorrect code.'])
                ->onlyInput('code');
        }

        $user = $request->user();
        $user->email_verified_at = new DateTime();
        $user->update();
        $request->session()->forget('code');
        return redirect()->route('home')->with('success', 'Registration successful.');
    }
}
