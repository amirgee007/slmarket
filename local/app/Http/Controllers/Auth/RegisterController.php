<?php

namespace Responsive\Http\Controllers\Auth;

use Responsive\User;
use Responsive\Http\Controllers\Controller;
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
    protected $redirectTo = '/dashboard';

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
            'name' => 'required|regex:/^[\w-]*$/|unique:users|max:255',
            'email' => 'required|string|email|max:255|unique:users',
			'phone' => 'required|string|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
			'gender' => 'required|string|max:255',
			'g-recaptcha-response' => 'required|captcha',
			
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
	 
	public function clean($string) 
	{
    
     $string = preg_replace("/[^\p{L}\/_|+ -]/ui","",$string);

    
    $string = preg_replace("/[\/_|+ -]+/", '-', $string);

    
    $string =  trim($string,'-');

    return mb_strtolower($string);
	}  
	 
	 
    protected function create(array $data)
    {
		
        return User::create([
            'name' => $data['name'],
			'post_slug' => $this->clean($data['name']),
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
			'gender' => $data['gender'],
			'phone' => $data['phone'],
			'photo' => '',
			'country' => $data['country'],
			'admin' => $data['usertype'],
			
        ]);
    }
}
