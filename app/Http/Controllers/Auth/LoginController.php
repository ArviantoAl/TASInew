<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function redirectTo()
    {
        if (auth()->user()->user_role==1){
            return route('admin.dashboard');
        }elseif(auth()->user()->user_role==2){
            return route('teknisi.dashboard');
        }elseif(auth()->user()->user_role==3){
            return route('pelanggan.dashboard');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request,[
            'username' => 'required',
            'password' => 'required'
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if(auth()->attempt(array($fieldType=>$input['username'], 'password'=>$input['password']))){
            if(auth()->user()->user_role == 1){
                return redirect()->route('admin.dashboard');
            }elseif(auth()->user()->user_role == 2){
                return redirect()->route('teknisi.dashboard');
            }elseif(auth()->user()->user_role == 3){
                if (auth()->user()->status_id == 2 || auth()->user()->status_id == 3){
                    return redirect()->route('pelanggan.dashboard');
                }elseif(auth()->user()->status_id == 1){
                    return redirect()->route('login')->with('error', 'Anda Tidak Bisa Masuk!');
                }
            }
        }else{
            return redirect()->route('login')->with('error', 'Email dan Password salah');
        }
    }
}
