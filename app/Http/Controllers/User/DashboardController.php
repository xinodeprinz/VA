<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // User deposits
        $deposits = $user->transactions()
            ->where('type', 'deposit')
            ->orWhere('type', 'plan')->get();

        $user->deposits = 0;
        foreach ($deposits as $d) {
            $user->deposits += $d->amount;
        }

        // User withdrawals
        $withdrawals = $user->transactions()
            ->where('type', 'withdrawal')->get();

        $user->withdrawals = 0;
        foreach ($withdrawals as $w) {
            $user->withdrawals += $w->amount;
        }

        // Getting users plan.

        $user->plan = $user->plan()->first();

        $dp = 0;

        // Converting plan info to USD
        if ($user->plan()->exists() && session('currency') === 'USD') {
            $user->plan->amount /= env('EXCHANGE_RATE');
            $user->plan->ad_cost /= env('EXCHANGE_RATE');
            $dp = 2;
        }

        // Clicks info
        $user->total_clicks = $user->clickedAds()->count();
        $user->today_clicks = $user->clickedAds()->whereDate('created_at', Carbon::today())->count();

        // Converting to USD
        if (session('currency') === 'USD') {
            $user->deposits /= env('EXCHANGE_RATE');
            $user->withdrawals /= env('EXCHANGE_RATE');
            $user->account_balance /= env('EXCHANGE_RATE');
        }

        return view('pages.user.dashboard', compact('user', 'dp'));
    }

    public function depositHistory()
    {
        $user = Auth::user();
        // User deposits
        $user->deposits = $user->transactions()
            ->where('type', 'deposit')
            ->orWhere('type', 'plan')->get();

        if (session('currency') === 'USD') {
            for ($i = 0; $i < $user->deposits->count(); $i++) {
                $user->deposits[$i]->amount /= env('EXCHANGE_RATE');
            }
        }

        return view('pages.user.deposit-history', compact('user'));
    }

    public function withdrawalHistory()
    {
        $user = Auth::user();
        // User withdrawals
        $user->withdrawals = $user->transactions()
            ->where('type', 'withdrawal')->get();

        if (session('currency') === 'USD') {
            for ($i = 0; $i < $user->withdrawals->count(); $i++) {
                $user->withdrawals[$i]->amount /= env('EXCHANGE_RATE');
            }
        }

        return view('pages.user.withdrawal-history', compact('user'));
    }

    public function ads()
    {
        $user = Auth::user();
        $ads = [];

        if ($user->plan()->exists()) {
            $plan = $user->plan()->first();

            $today_clicks = $user->clickedAds()->whereDate('created_at', Carbon::today())->count();
            $count = $plan->daily_ads - $today_clicks;
            $ads = Ad::inRandomOrder()->limit($count)->get();
        }

        return view('pages.user.ads', compact('user', 'ads'));
    }

    public function toShowAd(Request $request)
    {
        $request->validate(['id' => 'required|integer|min:1']);

        try {
            $ad = Ad::findOrFail($request->id);
        } catch (\Throwable$th) {
            return back()->with('error', 'The selected ad does not exists.');
        }

        // Needs adjustment
        return redirect()->route('show-ad', ['id' => $request->id]);
    }

    public function showAd($id)
    {
        try {
            $ad = Ad::findOrFail($id);
        } catch (\Throwable$th) {
            return back()->with('error', 'The selected ad does not exists.');
        }

        $user = Auth::user();

        // Needs adjustment
        return view('pages.user.ad', compact('user', 'ad'));
    }

    public function processAd(Request $request)
    {
        $request->validate(['id' => 'required|integer|min:1']);
        try {
            $ad = Ad::findOrFail($request->id);
        } catch (\Throwable$th) {
            return back()->with('error', 'The selected ad does not exists.');
        }

        $user = Auth::user();

        $user->clickedAds()->create(['ad_id' => $ad->id]);

        $plan = $user->plan()->first();

        $user->account_balance += $plan->ad_cost;
        $user->update();

        return redirect()->route('ads')->with('success', 'Ad clicked successfully.');
    }

    public function referrals()
    {
        $user = Auth::user();
        $user->referrals = $user->referrals()->get(['username', 'email', 'code', 'phone_number', 'created_at']);

        return view('pages.user.referrals', compact('user'));
    }

    public function adverts(Request $request)
    {
        $user = Auth::user();

        if ($request->isMethod('GET')) {
            return view('pages.user.adverts', compact('user'));
        }

        if ($user->is_advert || $user->is_admin) {
            return redirect()->route('create-advert');
        }

        // User is not advert and should pay 25k to become one.
        if ($user->account_balance >= 25000) {
            $user->is_advert = true;
            $user->advert_expires_in = 30;
            $user->account_balance -= 25000;
            $user->update();
            return back()->with('success', 'You are now an advert.');
        }

        $amount = 25000;
        $message = "{$amount} FCFA";

        if (session('currency') === 'USD') {
            $amount /= env('EXCHANGE_RATE');
            $amount = number_format($amount, 2, '.', ',');
            $message = "$ {$amount}";
        }

        return redirect()->route('momo-deposit')->with('error', "Deposit more money for your account balance to be greater than or equal to {$message} to become an advert.");
    }

    public function createAdvert(Request $request)
    {
        $user = Auth::user();
        if ($request->isMethod('GET')) {
            return view('pages.user.create-advert', compact('user'));
        }

        $request->validate([
            'title' => 'required|string|min:5',
            'body' => 'required|string',
        ]);

        Ad::create($request->all());

        return redirect()->route('adverts')->with('success', 'Ad created successfully.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate(['image' => 'required|image']);

        $imagePath = $request->file('image')->store('images/ads', 'public');

        return response(['url' => "/storage/$imagePath"]);
    }
}