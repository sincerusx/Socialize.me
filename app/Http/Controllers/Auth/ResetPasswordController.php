<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ResetCredentials;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * Where to redirect users after resetting their password.
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
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string|null              $token
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
                ['token' => $token, 'email' => $request->only('email')]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param \App\Services\ResetCredentials $resetCredentials
     * @param \Illuminate\Http\Request       $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(ResetCredentials $resetCredentials, Request $request)
    {
        return $resetCredentials->reset($request);
    }
}
