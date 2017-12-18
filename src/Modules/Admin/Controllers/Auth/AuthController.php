<?php
namespace App\Modules\Admin\Controllers\Auth;

use App\Models\Admin;
use Validator;
use Auth;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $redirectPath = '/admin/dashboard';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest.admin', ['except' => 'logout']);
        $this->auth = Auth::guard('web');
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showLoginForm(){
      return view('Admin::auth.login');
    }

    // Register
    public function showRegistrationForm(){
        if(\App\Models\Role::first()){
            $role = \App\Models\Role::lists('name', 'id')->toArray();
            return view('Admin::auth.register', compact('role'));
        }else{
            return redirect()->route('admin.createRole');
        }
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $user = $this->create($request->all());
        $role = Role::findOrFail($request->input('role_id'));
        $user->attachRole($role);

        $this->auth->login($user);

        return redirect($this->redirectPath());
    }
    public function logout()
    {
      $this->auth->logout();
      return redirect('/admin/login');
    }
}
