<?php

namespace App\Modules\Admin\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\Eloquent\CommonRepository;
use Datatables;
use DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $product;
    protected $common;
    protected $photo;
    protected $_original_path;
    protected $_thumbnail_path;
    protected $_removePath;

    public function __construct(ProductRepository $product, CommonRepository $common, PhotoRepository $photo)
    {
        $this->product = $product;
        $this->common = $common;
        $this->photo = $photo;
        $this->_original_path = env('ORIGINAL_PATH');
        $this->_thumbnail_path = env('THUMBNAIL_PATH');
        $this->_removePath = env('REMOVE_PATH');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $product = $this->product->query(['products.id as id', 'products.name_vi as name_vi', 'products.img_url as img_url', 'products.quantity as quantity', 'products.sku as sku', 'products.order as order', 'products.status as status', 'products.hot as hot','products.promotion as promotion' , 'brand_id', 'brands.name_vi as brand_name'])->join('brands','brands.id', '=', 'products.brand_id');

            return Datatables::of($product)
                ->addColumn('action', function($product){
                    return '<a href="'.route('admin.product.edit', $product->id).'" class="btn btn-success btn-sm d-inline-block"><i class="fa fa-edit"></i> </a>
                <form method="POST" action=" '.route('admin.product.destroy', $product->id).' " accept-charset="UTF-8" class="d-inline-block">
                    <input name="_method" type="hidden" value="DELETE">
                    <input name="_token" type="hidden" value="'.csrf_token().'">
                               <button class="btn  btn-danger btn-sm" type="button" attrid=" '.route('admin.product.destroy', $product->id).' " onclick="confirm_remove(this);" > <i class="fa fa-trash"></i></button>
               </form>' ;
                })->editColumn('order', function($product){
                    return "<input type='text' name='order' class='form-control' data-id= '".$product->id."' value= '".$product->order."' />";
                })->editColumn('status', function($product){
                    $status = $product->status ? 'checked' : '';
                    $product_id =$product->id;
                    return '
                  <label class="switch switch-icon switch-success-outline">
                    <input type="checkbox" class="switch-input" name="status" '.$status.' data-id="'.$product_id.'">
                    <span class="switch-label" data-on="" data-off=""></span>
                    <span class="switch-handle"></span>
                </label>
              ';
                })->editColumn('img_url',function($product){
                    return '<img src="'.asset('public/uploads/'.$product->img_url).'" width="60" class="img-fluid">';
                })->editColumn('hot', function($product){
                    $hot = $product->hot ? 'checked' : '';
                    $product_id =$product->id;
                    return '
                  <label class="switch switch-icon switch-success-outline">
                    <input type="checkbox" class="switch-input" name="hot" '.$hot.' data-id="'.$product_id.'">
                    <span class="switch-label" data-on="" data-off=""></span>
                    <span class="switch-handle"></span>
                </label>';
                })->editColumn('promotion', function($product){
                    $promotion = $product->promotion ? 'checked' : '';
                    $product_id =$product->id;
                    return '
                  <label class="switch switch-icon switch-success-outline">
                    <input type="checkbox" class="switch-input" name="promotion" '.$promotion.' data-id="'.$product_id.'">
                    <span class="switch-label" data-on="" data-off=""></span>
                    <span class="switch-handle"></span>
                </label>';
                })->filter(function($query) use ($request){
                    if (request()->has('name')) {
                        $query->where('name_vi', 'like', "%{$request->input('name')}%");
                    }
                })->setRowId('id')->make(true);
        }

        return view('Admin::pages.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = DB::table('brands')->lists('name_vi','id');
        return view('Admin::pages.product.create', compact('brands'));
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
            $thumb = $this->common->createThumbnail(asset('public/uploads/'.$img_url),$this->_thumbnail_path,350, 350, base_path($this->_removePath));
        }else{
          $img_url = "";
          $thumb = "";
        }
        $order = $this->product->getOrder();
        $data = [
            'name_vi' => $request->input('name_vi'),
            'name_en' => $request->input('name_en'),
            'slug' => \LP_lib::unicode($request->input('name_vi')),
            'description_vi' => $request->input('description_vi'),
            'description_en' => $request->input('description_en'),
            'content_vi' => $request->input('content_vi'),
            'content_en' => $request->input('content_en'),
            'sku' => strtoupper(str_replace(' ','', $request->input('sku'))),
            'quantity' => $request->input('quantity'),
            'price_vi' => floatval(str_replace(',','',$request->price_vi)),
            'img_url' => $img_url,
            'thumb_img_url' => $thumb,
            'order' => $order,
            'brand_id' => $request->input('brand_id'),
        ];
        $product = $this->product->create($data);

        $sub_photo = $request->file('thumb-input');
        if($sub_photo[0]){
            $data_photo = [];
            foreach($sub_photo as $thumb){
                $bigSize = $this->common->uploadImage($request, $thumb, $this->_original_path,$resize = false,null,null, base_path($this->_removePath));
                $smallsize = $this->common->createThumbnail($bigSize,$this->_thumbnail_path,350, 350, base_path($this->_removePath));
                $thumbsize = $this->common->createThumbnail($bigSize,$this->_thumbnail_path,85, 85, base_path($this->_removePath));

                $order = $this->photo->getOrder();
                $filename = $this->common->getFileName($bigSize);
                $data = new \App\Models\Photo(
                    [
                        'img_url' => $smallsize,
                        'thumb_url' => $thumbsize,
                        'big_url' => $bigSize,
                        'order'=>$order,
                        'filename' => $filename,
                    ]
                );
                array_push($data_photo, $data);
            }

            $product->photos()->saveMany($data_photo);
        }

        if($request->has('seo_checking')){
            if($request->has('meta_img')){
                $img_meta = $this->common->getPath($request->input('meta_img'));
            }else{
                $img_meta = '';
            }
            $data_seo = [
                'meta_keyword' => $request->input('keywords'),
                'meta_description' => $request->input('description'),
                'meta_img' => $img_meta,
            ];
            $product->metas()->save(new \App\Models\Meta($data_seo));
        }

        return redirect()->route('admin.product.index')->with('success','Created !');
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
        $brands = DB::table('brands')->lists('name_vi','id');
        $inst = $this->product->find($id,['*'],['photos']);
        return view('Admin::pages.product.edit', compact('inst', 'brands'));
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
        if($img_url){
            $thumb = $this->common->createThumbnail(asset('public/uploads/'.$img_url),$this->_thumbnail_path,350, 350, base_path($this->_removePath));
        }else{
            $thumb = '';
        }

        $data = [
            'name_vi' => $request->input('name_vi'),
            'name_en' => $request->input('name_en'),
            'slug' => \LP_lib::unicode($request->input('name_vi')),
            'description_vi' => $request->input('description_vi'),
            'description_en' => $request->input('description_en'),
            'content_vi' => $request->input('content_vi'),
            'content_en' => $request->input('content_en'),
            'sku' => strtoupper(str_replace(' ','', $request->input('sku'))),
            'quantity' => $request->input('quantity'),
            'price_vi' => floatval(str_replace(',','',$request->price_vi)),
            'img_url' => $img_url,
            'thumb_img_url' => $thumb,
            'order' => $request->input('order'),
            'brand_id' => $request->input('brand_id'),
            'status' => $request->input('status'),
        ];

        $product = $this->product->update($data, $id);

        $sub_photo = $request->file('thumb-input');

        if($sub_photo[0]){
            $data_photo = [];
            foreach($sub_photo as $thumb){
                $bigSize = $this->common->uploadImage($request, $thumb, $this->_original_path,$resize = false,null,null, base_path($this->_removePath));
                $smallsize = $this->common->createThumbnail($bigSize,$this->_thumbnail_path,350, 350, base_path($this->_removePath));
                $thumbsize = $this->common->createThumbnail($bigSize,$this->_thumbnail_path,85, 85, base_path($this->_removePath));
                $order = $this->photo->getOrder();
                $filename = $this->common->getFileName($bigSize);
                $data = new \App\Models\Photo(
                    [
                        'img_url' => $smallsize,
                        'thumb_url' => $thumbsize,
                        'big_url' => $bigSize,
                        'order'=>$order,
                        'filename' => $filename,
                    ]
                );
                array_push($data_photo, $data);
            }
            $product->photos()->saveMany($data_photo);
        }


        if($request->has('seo_checking')){
            $img_meta = $this->common->getPath($request->input('meta_img'));

            $data_seo = [
                'meta_keyword' => $request->input('keywords'),
                'meta_description' => $request->input('description'),
                'meta_img' => $img_meta,
            ];
            if(!$request->has('meta_id')){
                $product->metas()->save(new \App\Models\Meta($data_seo));
            }else{
                \DB::table('metables')->where('id',$request->input('meta_id'))->update($data_seo);
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Updated !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->product->delete($id);
        return redirect()->route('admin.product.index')->with('success', 'Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
      if(!$request->ajax()){
          abort(404);
      }else{
           $data = $request->arr;
           $response = $this->product->deleteAll($data);
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
                $obj = $this->product->find($k);
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
            $cate = $this->product->find($id);
            $cate->status = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }

    /*CHANGE PROMOTION*/
    public function updatePromotion(Request $request)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $value = $request->input('value');
            $id = $request->input('id');
            $cate = $this->product->find($id);
            $cate->promotion = $value;
            $cate->save();
            return response()->json([
                'mes' => 'Updated',
                'error'=> false,
            ], 200);
        }
    }

    public function updateHotProduct(Request $request)
    {
        if(!$request->ajax()){
            abort('404', 'Not Access');
        }else{
            $value = $request->input('value');
            $id = $request->input('id');
            $cate = $this->product->find($id);
            $cate->hot = $value;
            $cate->save();
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
