<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use App\Repositories\Eloquent\CommonRepository;
use Datatables;
use DB;

class CategoryController extends Controller
{
    protected $cateRepo;
    protected $common;
    public function __construct(CategoryRepository $cate, CommonRepository $common)
    {
        $this->cateRepo = $cate;
        $this->common = $common;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin::pages.category.index');
    }

    public function getData(Request $request)
    {
        $cate = DB::table('categories')->select(['id', 'title', 'avatar_img', 'order', 'status']);
            return Datatables::of($cate)
            ->addColumn('action', function($cate){
                return '<a href="'.route('admin.category.edit', $cate->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>
                <form method="POST" action=" '.route('admin.category.destroy', $cate->id).' " accept-charset="UTF-8" class="inline-block-span">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-xs remove-btn" type="button" attrid=" '.route('admin.category.destroy', $cate->id).' " onclick="confirm_remove(this);" > Remove </button>
               </form>' ;
           })->addColumn('order', function($cate){
               return "<input type='text' name='order' class='form-control' data-id= '".$cate->id."' value= '".$cate->order."' />";
           })->addColumn('status', function($cate){
               $status = $cate->status ? 'checked' : '';
               $cate_id =$cate->id;
               return '
                 <label class="toggle">
                    <input type="checkbox" name="status" value="1" '.$status.'   data-id ="'.$cate_id.'">
                    <span class="handle"></span>
                  </label>
              ';
           })->editColumn('avatar_img',function($cate){
             return '<img src="'.$cate->avatar_img.'" width="120" class="img-responsive">';
         })->filter(function($query) use ($request){
            if (request()->has('name')) {
                $query->where('title', 'like', "%{$request->input('name')}%");
            }
        })->setRowId('id')->make(true);
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
        }
        $order = $this->cateRepo->getOrder();
        $data = [
            'title' => $request->input('title'),
            'slug' => \LP_lib::unicode($request->input('title')),
            'avatar_img' => $img_url,
            'order' => $order,
        ];
        $this->cateRepo->create($data);
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
        $inst = $this->cateRepo->find($id);
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
                'title' => $request->input('title'),
                'slug' => \LP_lib::unicode($request->input('title')),
                'avatar_img' => $img_url,
                'order' => $request->input('order'),
                'status' => $request->input('status'),
        ];
        $this->cateRepo->update($data, $id);
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
        $this->cateRepo->delete($id);
        return redirect()->route('admin.category.index')->with('success','Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
      if(!$request->ajax()){
          abort(404);
      }else{
           $data = $request->arr;
           $response = $this->cateRepo->deleteAll($data);
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
                $obj = $this->cateRepo->find($k);
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
            $cate = $this->cateRepo->find($id);
            $cate->status = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }
}
