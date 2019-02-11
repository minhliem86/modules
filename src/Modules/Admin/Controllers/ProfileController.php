<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->auth = Auth::guard('web');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);
    }

    public function index()
    {
        return view('Admin::profile.index');
    }

    public function postChangePass(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator->errors());
        }
        if(! \Hash::check($request->input('old_password'),  $this->auth->user()->password )){
            return redirect()->back()->with('error', ' The old Password is Incorrect.');
        }
        $user =  $this->auth->user();
        $user->password = bcrypt($request->input('new_password'));
        $user->save();

        $this->auth->logout();

        return redirect('/admin/login')->with('sucess', 'Please login with new password');
    }
}
