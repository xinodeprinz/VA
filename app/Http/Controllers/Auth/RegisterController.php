<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'min:3', 'max:20', 'unique:users'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5'],
            'country' => ['required', 'string', 'max:50'],
            'phone_number' => ['required', 'string', 'min:5', 'max:15'],
            'code' => ['required', 'numeric', 'min:1', 'max:999'],
            'terms' => ['required', 'boolean'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data, array $others)
    {
        return User::create([
            'email' => $data['email'],
            'username' => $data['username'],
            'referral' => $others['referral'],
            'password' => Hash::make($data['password']),
            'country' => $data['country'],
            'phone_number' => $data['phone_number'],
            'code' => $data['code'],
        ]);
    }

    public function getCodes($countries)
    {
        $codes = [];
        foreach ($countries as $c) {
            if (!in_array($c['code'], $codes)) {
                array_push($codes, $c['code']);
            }
        }

        sort($codes);

        return $codes;
    }
}