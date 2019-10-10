<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/Dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest'); //Pagina se carga solo si usuario No esta Logeado

        $this->middleware('auth');//pagina se carga unicamente cuando se este logeado
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
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'min:2'],
            'role' => ['required', 'string','not_in:0'],
            'company' => ['required', 'string','not_in:0'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'description' => ['required', 'string', 'min:5'],
            'password' => ['required', 'string', 'min:5', 'confirmed']/*,
            'image' => ['image'],*/
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'role' => $data['role'],
            'company' => $data['company'],
            'email' => $data['email'],
            'description' => $data['description'],
            'password' => Hash::make($data['password'])/*,
            'image' => $data['image'],*/
        ]);
    }
}
