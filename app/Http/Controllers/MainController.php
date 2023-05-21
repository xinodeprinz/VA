<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Models\Plan;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Sitemap\SitemapGenerator;

class MainController extends Controller
{
    public function index()
    {
        $video = Video::inRandomOrder()->first();
        return view("pages.index", compact('video'));
    }

    public function about()
    {
        $video = Video::inRandomOrder()->first();
        return view("pages.about", compact('video'));
    }

    public function invest()
    {
        return view("pages.invest");
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

    public function sitemap()
    {
        SitemapGenerator::create('https://bridon-production.com')->writeToFile('sitemap.xml');
    }

    public function newsletter(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        return back()->with('success', __('main.You have subscribed successfully'));
    }
}
