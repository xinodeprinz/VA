<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::all();
        $user = Auth::user();

        if (session('currency') === 'USD') {
            for ($i = 0; $i < $users->count(); $i++) {
                $users[$i]->account_balance /= env('EXCHANGE_RATE');
            }
        }

        return view('pages.admin.users', compact('users', 'user'));
    }

    public function blockUser($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (\Throwable $th) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }

        $user->is_blocked = $user->is_blocked ? false : true;
        $mess = $user->is_blocked ? 'blocked' : 'unblocked';
        $user->update();

        return redirect()->route('admin.users')->with('success', "User {$mess}!");
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (\Throwable $th) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted!');
    }

    public function ads()
    {
        $ads = Ad::all();
        $user = Auth::user();
        return view('pages.admin.ads', compact('ads', 'user'));
    }

    public function deleteAd($id)
    {
        try {
            $ad = Ad::findOrFail($id);
        } catch (\Throwable $th) {
            return redirect()->route('admin.ads')->with('error', 'Ad not found.');
        }

        $ad->delete();

        return redirect()->route('admin.ads')->with('success', 'Ad deleted!');
    }
}