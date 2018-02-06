<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Session;
use DB;
use Hash;

class LoginController extends Controller {
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
    protected $loginPath = '/root/login';
    protected $redirectTo = '/dashboard';
    protected $redirectAfterLogout = '/root/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, Validator $validator) {
        $this->middleware('guest', ['except' => 'logout']);
        $this->request = $request;
        $this->validator = $validator;
    }

    public function login() {
        $userdata = array(
            'email' => $this->request->email,
            'password' => $this->request->password
        );
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6',
        );
        $validator = Validator::make($userdata, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator->getMessageBag()->toArray());
        } else {
            if (Auth::validate($userdata)) {
                if (Auth::attempt($userdata)) {
                    $user = Auth::user();
                    if ($user->hasRole('root') || $user->hasRole('super_user') || $user->hasRole('sells') || $user->hasRole('collect') || $user->hasRole('owner') || $user->hasRole('cashier')) {
                        return Redirect::intended('/dashboard');
                    } else {
                        Auth::logout();
                        Session::flush();
                        return Redirect::back()->withInput()->withErrors(['Permiso negado']);
                    }
                }
            } else {
                Session::flash('error', 'Algo anda mal');
                return Redirect::back()->withInput()->withErrors(['Credenciales invalidos']);
            }
        }
    }

    public function logout() {

        $user = Auth::user();
        Auth::logout();
        return redirect('/root/login');
    }

}
