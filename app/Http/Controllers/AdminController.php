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

    public function emailUsers(Request $request)
    {
        if ($request->isMethod('GET')) {
            $types = $this->getTypes();
            $user = Auth::user();
            return view('pages.admin.email', compact('types', 'user'));
        }

        $val = Validator::make($request->all(), [
            'type' => 'required|string',
            'skip' => 'required|integer',
            'take' => 'required|integer',
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        if ($val->fails()) {
            $error = Help::ValError($val);
            return response()->json(['message' => $error], 422);
        }

        $users = Help::getUsers($request);

        if (!$users) {
            return response()->json(['message' => 'Invalid Type'], 400);
        }

        $success = 0;
        $failed = 0;

        foreach ($users as $user) {
            try {
                Mail::to($user->email)->send(new Users($request));
                $success += 1;
            } catch (\Throwable $th) {
                $failed += 1;
                continue;
            }
        }

        return response()->json([
            'success' => $success,
            'failed' => $failed,
        ]);
    }

    protected function getTypes()
    {
        $types = Help::types();
        $result = [];
        foreach ($types as $type) {
            $count = DB::table($type . '_users')->count();
            $result[$type] = $count;
        }
        return $result;
    }

    public function uploadImage(Request $request)
    {
        $request->validate(['image' => 'required|image']);
        $imagePath = $request->file('image')->store('images', 'public');
        $url = config('app.url') . "/storage/" . $imagePath;
        return response()->json(['url' => $url]);
    }
}
