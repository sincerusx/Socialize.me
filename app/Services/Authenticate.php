<?php

namespace App\Services;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Class Authenticate
 * @package App\Services
 */
class Authenticate
{
    use AuthenticatesUsers, ValidatesRequests;

    /**
     * The maximum number of login attempts to allowed
     * .
     * @var int $maxAttempts
     */
    protected $maxAttempts;
    /**
     * The number of minutes each throttle lasts.
     *
     * @var int $decayMinutes
     */
    protected $decayMinutes;
    /**
     * Dictates whether we will throttle login attempts.
     *
     * @var bool $throttleLogins
     */
    private $throttleLogins = false;

    /**
     * Authenticate Service constructor.
     */
    public function __construct()
    {
        // @todo: Make use of Throttle Login and If from ip address do not throttle logins
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function tryLogin(Request $request)
    {

        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
                $this->username() => 'required|string',
                'password'        => 'required|string',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function tryLogout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    public function redirectTo()
    {
        return '/';
    }

}