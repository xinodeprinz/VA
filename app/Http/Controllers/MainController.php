<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function index()
    {
        $plans = Plan::limit(3)->get();
        $dp = 0;

        if (session('currency') === 'USD') {
            $dp = 2;
            foreach ($plans as $plan) {
                $plan->amount = $plan->amount / env('EXCHANGE_RATE');
                $plan->ad_cost = $plan->ad_cost / env('EXCHANGE_RATE');
            }
        }

        return view("pages.index", compact('plans', 'dp'));
    }

    public function about()
    {
        return view("pages.about");
    }

    public function plans()
    {
        $plans = Plan::all();

        $dp = 0;

        if (session('currency') === 'USD') {
            $dp = 2;
            foreach ($plans as $plan) {
                $plan->amount /= env('EXCHANGE_RATE');
                $plan->ad_cost /= env('EXCHANGE_RATE');
            }
        }

        return view("pages.plans", compact('plans', 'dp'));
    }

    public function contact(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view("pages.contact");
        }

        $data = $request->validate([
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|email',
            'subject' => 'required|string|min:3|max:150',
            'message' => 'required|string|min:3|max:1000',
        ]);

        Mail::to(env('EMAIL'))->send(new Contact($data));

        return back()->with('success', 'Your message has been successfully emailed to us.');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function currency(Request $request)
    {
        $request->validate(['currency' => 'required|string|min:3|max:4']);

        session(['currency' => $request->currency]);

        return back()->with('success', "Currency changed to {$request->currency}.");
    }
}