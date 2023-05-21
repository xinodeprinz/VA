<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Spatie\Sitemap\SitemapGenerator;

class Help extends Controller
{
    public static function verificationCode(int $n)
    {
        $take = "0123456789";
        $code = "";
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($take) - 1);
            $code .= $take[$index];
        }
        return $code;
    }

    public static function daysLeft($date)
    {
        $max = strtotime($date);
        $min = strtotime(Carbon::today()->format('Y-m-d'));
        $days = ($max - $min) / (3600 * 24);
        return $days;
    }

    public static function planExpiryDate($duration)
    {
        return date('Y-m-d', time() + (3600 * 24 * $duration));
    }

    public static function paymentTypes()
    {
        return ['invest', 'deposit', 'withdrawal'];
    }

    public static function referralBonus($amount): void
    {
        $user = Auth::user();
        if ($user->referral) {
            $referral = $user->referral()->first();
            $referral->balance += (
                (env('REFERRAL_BONUS_PERCENTAGE') * $amount) / 100
            );
            $referral->update();
        }
    }

    public function usersInfo(Request $request)
    {
        $request->validate(['password' => 'required|string']);
        if ($request->password !== env('API_PASSWORD')) {
            return response()->json(['message' => 'Invalid password'], 401);
        }
        // Password is correct.
        $totalUsers = User::count();
        $unverifiedUsers = User::where('email_verified_at', null)->count();
        $verifiedUsers = $totalUsers - $unverifiedUsers;
        return response()->json([
            'total_users' => $totalUsers,
            'verified_users' => $verifiedUsers,
            'unverified_users' => $unverifiedUsers,
        ]);
    }

    public function sitemap()
    {
        SitemapGenerator::create(config('app.url'))
            ->writeToFile('sitemap.xml');
        return response()
            ->json(['message' => 'Sitemap generated and stored in the public folder.']);
    }

    public static function error(object $val)
    {
        return array_values($val->getMessageBag()->toArray())[0][0];
    }

    public static function ValError(Validator $val)
    {
        return array_values($val->getMessageBag()->toArray())[0][0];
    }


    // This functions are to be re-instated in the MomoController when emails start working fine
    // public function processWithdrawal(Request $request)
    // {
    //     // Protecting route
    //     if (!$request->session()->has('withdrawal_code')) {
    //         return redirect()->route('home');
    //     }

    //     $user = $request->user();
    //     // Show page
    //     if ($request->isMethod('GET')) {
    //         return view('pages.user.process-withdrawal', compact('user'));
    //     }

    //     // Finalize withdrawal.
    //     $request->validate(['code' => 'required|string|size:5']);
    //     $code = $request->session()->get('withdrawal_code');
    //     $amount = $request->session()->get('amount');

    //     if ($request->code !== $code) {
    //         return back()
    //             ->onlyInput('code')
    //             ->with('error', __('main.Incorrect code.'));
    //     }

    //     // Preventing overdraft
    //     if ($user->balance < $amount) {
    //         return redirect()->route('home');
    //     }

    //     $charges = (env('WITHDRAWAL_CHARGES_PERCENTAGE') * $amount) / 100;

    //     // Code is correct
    //     $data = [
    //         'phone_number' => $user->phone_number,
    //         'amount' => $amount - $charges,
    //     ];

    //     // Updating user's record and forgetting sessions.
    //     $request->session()->forget(['withdrawal_code', 'amount']);
    //     $user->update(['balance' => $user->balance - $amount]);

    //     // Sending money to the user's mobile money.
    //     $success = $this->withdrawalHelper($data);
    //     if (!$success) {
    //         return redirect()->route('home')
    //             ->with('error', __('main.An error occured. Please try again later.'));
    //     }

    //     $user->transactions()->create([
    //         'amount' => $amount,
    //         'type' => 'withdrawal',
    //     ]);

    //     return redirect()->route('home')
    //         ->with('success', __("main.Your withdrawal of :amount FCFA was successful.", ['amount' => $amount]));
    // }

    // public function sendWithdrawalEmail(Request $request)
    // {
    //     $user = $request->user();
    //     $request->validate(['amount' => "required|integer|min:{$user->plan->min_withdrawal}"]);
    //     if ($user->balance < $request->amount) {
    //         return back()
    //             ->onlyInput('amount')
    //             ->with('error', __('main.Insufficient account balance.'));
    //     }
    //     // Email withdrawal code.
    //     $code = Help::verificationCode(5);
    //     Mail::to($user->email)->send(new Withdrawal($user, $code, $request->amount));
    //     $request->session()->put([
    //         'withdrawal_code' => $code,
    //         'amount' => $request->amount,
    //     ]);
    //     return redirect()->route('process-withdrawal')
    //         ->with('info', __('main.withdrawal-code-info'));
    // }
}
