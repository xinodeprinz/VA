<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        return ['plan', 'deposit', 'withdrawal'];
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
}
