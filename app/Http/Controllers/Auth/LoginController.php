<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request   $request
     * @param \App\Services\Authenticate $service
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     */
    public function login(Request $request, Authenticate $service)
    {
        try {
            return $service->tryLogin($request);
        } catch (ValidationException $e) {
            throw ValidationException::withMessages([
                    $service->username() => [$e->getMessage()],
            ]);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Services\Authenticate $service
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request, Authenticate $service)
    {
        return $service->tryLogout($request);
    }
}
