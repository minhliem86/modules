<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AlbumRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\Eloquent\CommonRepository;
use Datatables;
use DB;

class AlbumController extends Controller
{
    protected $album;
    protected $common;
    protected $photo;
    public function __construct(AlbumRepository $album, CommonRepository $common, PhotoRepository $photo)
    {
        $this->album = $album;
        $this->common = $common;
        $this->photo = $photo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if($request->ajax()){
            $album = $this->album->query(['id', 'title', 'img_url', 'order', 'status']);
            return Datatables::of($album)
                ->addColumn('action', function($album){
                    return '<a href="'.route('admin.album.edit', $album->id).'" class="btn btn-success btn-sm d-inline-block"><i class="fa fa-edit"></i> </a>
                <form method="POST" action=" '.route('admin.album.destroy', $album->id).' " accept-charset="UTF-8" class="d-inline-block">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-sm" type="button" attrid=" '.route('admin.album.destroy', $album->id).' " onclick="confirm_remove(this);" > <i class="fa fa-trash"></i></button>
               </form>' ;
                })->editColumn('order', function($album){
                    return "<input type='text' name='order' class='form-control' data-id= '".$album->id."' value= '".$album->order."' />";
                })->editColumn('status', function($album){
                    $status = $album->status ? 'checked' : '';
                    $album_id =$album->id;
                    return '
                  <label class="switch switch-icon switch-success-outline">
                    <input type="checkbox" name="status" class="switch-input" '.$status.' data-id="'.$album_id.'">
                    <span class="switch-label" data-on="" data-off=""></span>
                    <span class="switch-handle"></span>
                </label>
              ';
                })->editColumn('img_url',function($album){
                    return '<img src="'.asset(env("PATH_PHOTO").'/'.$album->img_url).'" width="120" class="img-responsive">';
                })->filter(function($query) use ($request){
                    if (request()->has('name')) {
                        $query->where('title', 'like', "%{$request->input('name')}%");
                    }
                })->setRowId('id')->make(true);
        }
        return view('Admin::pages.album.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin::pages.album.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $order_album = $this->album->getOrder();

        if($request->has('img_url')){
            $img_url = $this->common->getPath($request->input('img_url'));
        }else{
            $img_url = '';
        }

        $data_album = [
            'title' => $request->input('title'),
            'slug' => \LP_lib::unicode($request->input('title')),
            'img_url' => $img_url,
            'order' => $order_album,
        ];

        $album = $this->album->create($data_album);

        $sub_photo = $request->file('photo-input');

        if($sub_photo[0]) {
            $title_img = $request->input('title_img');
            $data_photo = [];
            foreach ($sub_photo as $k =>$thumb) {
                $response = $this->common->uploadImage($request, $thumb, env("ORIGINAL_PHOTO"), 350, 350);
                $order = $this->photo->getOrder();
                if($order == 1){
                    $order = $k + 1;
                }else{
                    $order = $order + $k;
                }
                $data = new \App\Models\Photo(
                    [
                        'title' => $title_img[$k],
                        'img_url' => $response['path'],
                        'thumb_url' =>  $response['thumbnail'],
                        'order' => $order,
                        'filename' => $response['name'],
                    ]
                );
                array_push($data_photo, $data);
            }

            $album->photos()->saveMany($data_photo);
        }

        return redirect()->route('admin.album.index')->with('success','Created !');

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
        $inst = $this->album->find($id);
        return view('Admin::pages.album.edit', compact('inst'));
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

        $data_album = [
            'title' => $request->input('title'),
            'slug' => \LP_lib::unicode($request->input('title')),
            'img_url' => $img_url,
            'order' => $request->input('order'),
            'status' => $request->input('status'),
        ];

        $album = $this->album->update($data_album, $id);

//        if($request->has('seo_checking') || $request->get('meta_keywords') || $request->input('meta_description') ){
//
//            $meta_img = $this->common->getPath($request->input('meta_img'));
//
//            $data_seo = [
//                'meta_keyword' => $request->input('meta_keywords'),
//                'meta_description' => $request->input('meta_description'),
//                'meta_img' => $meta_img,
//            ];
//
//            if(!$request->has('meta_config_id'))
//                $album->meta_configs()->save(new \App\Models\MetaConfig($data_seo));
//            else
//                $meta->update($data_seo,$request->input('meta_config_id'));
//        }

        $sub_photo = $request->file('photo-input');


        if($sub_photo[0]) {
            $title_img = $request->input('title_img');
            $data_photo = [];
            foreach ($sub_photo as $k =>$thumb) {
                $response = $this->common->uploadImage($request, $thumb, env("ORIGINAL_PHOTO"), 350, 350);
                $order = $this->photo->getOrder();
                if($order == 1){
                    $order = $k + 1;
                }else{
                    $order = $order + $k;
                }
                $data = new \App\Models\Photo(
                    [
                        'title' => $title_img[$k],
                        'img_url' => $response['path'],
                        'thumb_url' =>  $response['thumbnail'],
                        'order' => $order,
                        'filename' => $response['name'],
                    ]
                );
                array_push($data_photo, $data);
            }

            $album->photos()->saveMany($data_photo);
        }

        return redirect()->route('admin.album.index')->with('success', 'Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->album->delete($id);
        return redirect()->route('admin.album.index')->with('success','Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }else{
            $data = $request->arr;
            $response = $this->album->deleteAll($data);
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
                $obj = $this->album->find($k);
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
            $album = $this->album->find($id);
            $album->status = $value;
            $album->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }

    /* REMOVE CHILD PHOTO */
    public function AjaxRemovePhoto(Request $request)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $id = $request->input('key');
            $this->photo->delete($id);
            return response()->json(['success'],200);
        }
    }

    /* UPDATE CHILD PHOTO */
    public function AjaxUpdatePhoto(Request $request)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $id = $request->input('id_photo');
            $order = $request->input('value');
            $photo = $this->photo->update(['order'=>$order], $id);

            return response()->json([
                'mes' => 'Update Order',
                'error'=> false,
            ], 200);
        }
    }
}
