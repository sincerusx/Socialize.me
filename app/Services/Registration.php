<?php
/**
 * Created by Liam Nelson.
 * Email: lmjnelson@yahoo.com
 */

namespace App\Services;

use Illuminate\Foundation\Auth\RegistersUsers;
use App\Events\UserHasRegistered;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Class Registration
 * @package App\Services
 */
class Registration
{
    use RegistersUsers, ValidatesRequests;

    protected $registeredService;
    /**
     * @var \App\Repositories\Contracts\UserRepositoryInterface $User
     */
    private $User;

    /**
     * Registration constructor.
     *
     * @param \App\Services\UserRepositoryInterface $user
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->User = $user;
        $this->registeredService = $this;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function tryRegister(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->User->create($request->all());

        event(new UserHasRegistered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                ? : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
                'username' => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function redirectTo()
    {
        return '/';
    }

}