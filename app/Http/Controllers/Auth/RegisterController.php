<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Services\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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

    //    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    public $redirectTo = '/';

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
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Services\Registration $service
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, Registration $service)
    {
        return $service->tryRegister($request);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return \App\Entities\User
     */
    protected function create(array $data)
    {
        return User::create([
                'username' => $data['username'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
        ]);
    }
}
