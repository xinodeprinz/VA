<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
