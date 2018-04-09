<?php

namespace App\Services;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Password;

//use Illuminate\Contracts\Auth\PasswordBroker as Password;
//use Illuminate\Contracts\Auth\PasswordBroker;

class ResetCredentials
{
    use SendsPasswordResetEmails, ResetsPasswords, ValidatesRequests;

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
                $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
                ? $this->sendResetLinkResponse($response)
                : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
                $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                ? $this->sendResetResponse($response)
                : $this->sendResetFailedResponse($request, $response);
    }

    public function redirectTo()
    {
        return '/';
    }
}