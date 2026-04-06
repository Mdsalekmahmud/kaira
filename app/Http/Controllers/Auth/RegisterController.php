<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
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
    protected $redirectTo = '/';

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
            'fast_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'country'  =>['required', 'string',],
            'c_companyname'  =>['required', 'string',],


            'c_address'  =>['required', 'string',],
            'c_postal_zip'  =>['required', 'string',],
            'c_state_country'  =>['required', 'string',],
            'c_phone'  =>['required', 'string',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]); 
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'role_id'=>3,
            'fast_name' => $data['fast_name'],
            'last_name' => $data['last_name'],
            'country' => $data['country'],
            'c_companyname' => $data['c_companyname'],
            'c_address' => $data['c_address'],
            'c_postal_zip' => $data['c_postal_zip'],
            'c_state_country' => $data['c_state_country'],
            'c_phone' => $data['c_phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
