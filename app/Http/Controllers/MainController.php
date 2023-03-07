<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Models\Plan;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function index()
    {
        $plans = Plan::limit(4)->get();
        $video = Video::inRandomOrder()->first();
        foreach ($plans as $plan) {
            $plan->total_earn = $plan->videos * $plan->video_cost * $plan->duration;
        }
        return view("pages.index", compact('plans', 'video'));
    }

    public function about()
    {
        $video = Video::inRandomOrder()->first();
        return view("pages.about", compact('video'));
    }

    public function plans()
    {
        $plans = Plan::paginate(8);
        foreach ($plans as $plan) {
            $plan->total_earn = $plan->videos * $plan->video_cost * $plan->duration;
        }
        return view("pages.plans", compact('plans'));
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

        return back()->with('success', __('main.Your message has been successfully emailed to us.'));
    }

    public function changeLanguage(Request $request, $locale)
    {
        $request->session()->put('locale', $locale);
        return back()->with('success', __('main.Language successfully changed.'));
    }
}
