<?php

namespace App\Modules\Admin\Controllers;

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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin::pages.user.index');
    }

    public function getData(Request $request)
    {
        $user = User::wherePermissionIs('login')->whereNotIn('id',[Auth::user()->id])->select('id', 'name', 'email', 'created_at');
        $datatable = Datatables::of($user)
            ->editColumn('created_at', function($user){
                return date_format(date_create($user->created_at), 'd/m//Y');
            })
            ->filter(function($query) use ($request){
                if (request()->has('name')) {
                    $query->where('name', 'like', "%{$request->input('name')}%");
                }
            })
            ->addColumn('action', function($cate){
                return '<a href="'.route('admin.user.edit', $cate->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>
                <form method="POST" action=" '.route('admin.user.destroy', $cate->id).' " accept-charset="UTF-8" class="inline-block-span">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-xs remove-btn" type="button" attrid=" '.route('admin.user.destroy', $cate->id).' " onclick="confirm_remove(this);" > Remove </button>
               </form>' ;
            })
            ->make(true);

        return $datatable;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::lists('display_name','id')->toArray();
        return view('Admin::pages.user.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
            'username' => 'required',
            'role_id' => 'required'
        ];
        $message = [
            'name.required' => 'Vui lòng nhập tên',
            'username.required' => 'Vui lòng nhập Username',
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
