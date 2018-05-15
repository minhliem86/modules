<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CategoriesRepository;
use App\Repositories\Eloquent\CommonRepository;
use Datatables;
use DB;

class CategoryController extends Controller
{
    protected $category;
    protected $common;
    public function __construct(CategoriesRepository $category, CommonRepository $common)
    {
        $this->category = $category;
        $this->common = $common;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if($request->ajax()){
            $cate = $this->category->query(['id', 'name', 'img_url', 'order', 'status']);
            return Datatables::of($cate)
                ->addColumn('action', function($cate){
                    return '<a href="'.route('admin.category.edit', $cate->id).'" class="btn btn-success btn-sm d-inline-block"><i class="fa fa-edit"></i> </a>
                <form method="POST" action=" '.route('admin.category.destroy', $cate->id).' " accept-charset="UTF-8" class="d-inline-block">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-sm" type="button" attrid=" '.route('admin.category.destroy', $cate->id).' " onclick="confirm_remove(this);" > <i class="fa fa-trash"></i></button>
               </form>' ;
                })->editColumn('order', function($cate){
                    return "<input type='text' name='order' class='form-control' data-id= '".$cate->id."' value= '".$cate->order."' />";
                })->editColumn('status', function($cate){
                    $status = $cate->status ? 'checked' : '';
                    $cate_id =$cate->id;
                    return '
                  <label class="switch switch-icon switch-success-outline">
                    <input type="checkbox" name="status" class="switch-input" '.$status.' data-id="'.$cate_id.'">
                    <span class="switch-label" data-on="" data-off=""></span>
                    <span class="switch-handle"></span>
                </label>
              ';
                })->editColumn('img_url',function($cate){
                    return '<img src="'.asset('public/uploads/'.$cate->img_url).'" width="120" class="img-responsive">';
                })->filter(function($query) use ($request){
                    if (request()->has('name')) {
                        $query->where('name', 'like', "%{$request->input('name')}%");
                    }
                })->setRowId('id')->make(true);
        }
        return view('Admin::pages.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin::pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('img_url')){
            $img_url = $this->common->getPath($request->input('img_url'));
        }else{
            $img_url = '';
        }
        $order = $this->category->getOrder();

        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'img_url' => $img_url,
            'order' => $order,
        ];
        $this->category->create($data);
        return redirect()->route('admin.category.index')->with('success','Created !');
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
        $inst = $this->category->find($id);
        return view('Admin::pages.category.edit', compact('inst'));
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
        $img_url = $this->common->getPath($request->input('img_url'));
        $data = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'slug' => \LP_lib::unicode($request->input('name')),
            'img_url' => $img_url,
            'order' => $request->input('order'),
            'status' => $request->input('status'),
        ];
        $this->category->update($data, $id);
        return redirect()->route('admin.category.index')->with('success', 'Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->category->delete($id);
        return redirect()->route('admin.category.index')->with('success','Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $data = $request->arr;
            $response = $this->category->deleteAll($data);
            return response()->json(['msg' => 'ok']);
        }
    }

    /*UPDATE ORDER*/
    public function postAjaxUpdateOrder(Request $request)
    {
        if(!$request->ajax())
        {
            abort('404', 'Not Access');
        }else{
            $data = $request->input('data');
            foreach($data as $k => $v){
                $upt  =  [
                    'order' => $v,
                ];
                $obj = $this->category->find($k);
                $obj->update($upt);
            }
            return response()->json(['msg' =>'ok', 'code'=>200], 200);
        }
    }

    /*CHANGE STATUS*/
    public function updateStatus(Request $request)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $value = $request->input('value');
            $id = $request->input('id');
            $cate = $this->category->find($id);
            $cate->status = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }
}
