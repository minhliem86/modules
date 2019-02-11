<?php

namespace App\Modules\Admin\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Yajra\Datatables\Datatables;
use App\Models\Role;
use Auth;
use Validator;

class UserManagementController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->middleware('check_admin');
        $this->user = $user;
        $this->auth = Auth::guard('web');;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $user = User::wherePermissionIs('login')->whereNotIn('id',[$this->auth->user()->id])->select('id', 'name', 'email', 'created_at');
            return Datatables::of($user)
                ->editColumn('created_at', function($user){
                    return date_format(date_create($user->created_at), 'd/m/Y');
                })
                ->filter(function($query) use ($request){
                    if (request()->has('name')) {
                        $query->where('name', 'like', "%{$request->input('name')}%");
                    }
                })
                ->addColumn('action', function($user){
                    return '
                <form method="POST" action=" '.route('admin.country.destroy', $user->id).' " accept-charset="UTF-8" class="d-inline-block">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-sm" type="button" attrid=" '.route('admin.user.destroy', $user->id).' " onclick="confirm_remove(this);" > <i class="fa fa-trash"></i></button>
               </form>' ;
                })->setRowId('id')->make(true);
        }
        return view('Admin::pages.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin::pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);
        if($valid->fails()){
            return back()->withInput()->withErrors($valid->errors());
        }
        $admin = Role::where('name','admin')->first();
        $permission = Permission::where('name','login')->first();
        $input = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt('123456'),
        ];

        $user = $this->user->create($input);

        $user->attachRole($admin);
        $user->attachPermission($permission);

        return redirect()->route('admin.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::lists('name','id')->toArray();
        $inst = $this->user->find($id);
        $AllRole = Role::all();
        return view('Admin::pages.user.edit', compact('role','inst','AllRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rule = [
            'name' => 'required',
            'role_id' => 'required'
        ];
        $message = [
            'name.required' => 'Vui lòng nhập tên',
            'role_id.required' => 'Vui lòng chọn 1 Role cho User'
        ];
        $valid = Validator::make($request->all(), $rule, $message);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }else{
            $data= [
                'name' => $request->get('name'),
                'username' => $request->get('username'),
            ];
            $user = $this->user->update($data, $id);
            $role = Role::find($request->get('role_id'));
            $user->syncRoles([$role]);
        }
        return redirect()->route('admin.user.index')->with('success', 'User is updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user->delete($id);
        return redirect()->route('admin.user.index')->with('success','Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $data = $request->arr;
            if(count($data)){
                $response = $this->user->deleteAll($data);
                return response()->json(['msg' => 'ok']);
            }else{
                return response()->json(['msg' => 'error']);
            }

        }
    }
}
