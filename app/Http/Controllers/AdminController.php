<?php

namespace App\Http\Controllers;

use App\Mail\Users;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::paginate(10);
        $user = Auth::user();
        $total = User::count();
        return view('pages.admin.users', compact('users', 'user', 'total'));
    }

    public function blockUser($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (\Throwable$th) {
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
        } catch (\Throwable$th) {
            return redirect()->route('admin.users')->with('error', 'User not found.');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted!');
    }

    public function emailUsers(Request $request)
    {
        $user = $request->user();
        $types = ['bridon', 'prime', 'money'];

        if ($request->isMethod('GET')) {
            return view('pages.admin.email', compact('user', 'types'));
        }

        $val = Validator::make($request->all(), [
            'type' => 'required|string',
            'subject' => 'required|string|min:3',
            'message' => 'required|string',
        ]);

        if ($val->fails()) {
            return response()->json(['message' => Help::error($val)], 422);
        }

        if (!in_array($request->type, $types)) {
            return response()->json(['message' => 'Invalid type'], 400);
        }

        $success = 0;
        $failed = 0;

        if ($request->type === 'bridon') {
            $users = User::orderBy('id', 'desc');
        } elseif ($request->type === 'prime') {
            $users = DB::table('p_users')->orderBy('id', 'desc');
        } else {
            return response()->json(['message' => 'Type not yet available'], 400);
        }

        foreach ($users->get() as $u) {
            try {
                Mail::to($u->email)->send(new Users($u, $request->all()));
                $success += 1;
                if ($request->type !== 'bridon') {
                    $users->where('id', $u->id)->delete();
                }
            } catch (\Throwable$th) {
                $failed += 1;
                continue;
            }
        }

        return response()->json([
            'success' => $success,
            'failed' => $failed,
        ]);
    }
}
