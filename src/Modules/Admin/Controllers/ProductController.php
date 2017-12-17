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

class ProductController extends Controller
{
    protected $_bigsize = 'public/upload/bigsize';
    protected $_thumbnail = 'public/upload/thumbnails';
    protected $productRepo;
    protected $common;
    protected $photo;

    public function __construct(ProductRepository $product, CommonRepository $common, PhotoRepository $photo)
    {
        $this->productRepo = $product;
        $this->common = $common;
        $this->photo = $photo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin::pages.product.index');
    }

    public function getData(Request $request)
    {
        $product = DB::table('products')->join('categories', 'products.category_id', '=','categories.id')->select(['products.id', 'products.title', 'products.avatar_img', 'products.price', 'products.order', 'products.status', 'products.hot']);

        return Datatables::of($product)
        ->addColumn('action', function($product){
            return '<a href="'.route('admin.product.edit', $product->id).'" class="btn btn-info btn-xs inline-block-span"> Edit </a>
            <form method="POST" action=" '.route('admin.product.destroy', $product->id).' " accept-charset="UTF-8" class="inline-block-span">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="'.csrf_token().'">
                           <button class="btn  btn-danger btn-xs remove-btn" type="button" attrid=" '.route('admin.product.destroy', $product->id).' " onclick="confirm_remove(this);" > Remove </button>
           </form>' ;
       })->editColumn('order', function($product){
               return "<input type='text' name='order' class='form-control' data-id= '".$product->id."' value= '".$product->order."' />";
       })->editColumn('status', function($product){
           $status = $product->status ? 'checked' : '';
           $product_id =$product->id;
           return '
             <label class="toggle">
                <input type="checkbox" name="status" value="1" '.$status.'   data-id ="'.$product_id.'">
                <span class="handle"></span>
              </label>
          ';
      })->editColumn('hot', function($product){
          $hot = $product->hot ? 'checked' : '';
          $product_id =$product->id;
          return '
            <label class="toggle">
               <input type="checkbox" name="hot" value="1" '.$hot.'   data-id ="'.$product_id.'">
               <span class="handle"></span>
             </label>
         ';
     })->editColumn('avatar_img',function($product){
          return '<img src="'.asset('public/upload').'/'.$product->avatar_img.'" width="120" class="img-responsive">';
        })->filter(function($query) use ($request){
           if (request()->has('name')) {
               $query->where('products.title', 'like', "%{$request->input('name')}%");
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
        return view('Admin::pages.product.create');
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
          $img_url = "";
        }
        if($request->has('meta_images')){
            $meta_img = $this->common->getPath($request->input('meta_images'));
        }else{
          $meta_img = "";
        }
        $order = $this->productRepo->getOrder();
        $data = [
            'title' => $request->input('title'),
            'slug' => \LP_lib::unicode($request->input('title')),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'meta_keywords' => $request->input('meta_keywords'),
            'meta_description' => $request->input('meta_description'),
            'meta_images' => $meta_img,
            'avatar_img' => $img_url,
            'order' => $order,
            'category_id' => 1,
        ];
        $product = $this->productRepo->create($data);

        if($request->file('thumb-input')){
          foreach($request->file('thumb-input') as $k=>$thumb){
            $img = $this->common->uploadImage($request, $thumb, $this->_bigsize,$resize = false);
            $thumbnail = $this->common->createThumbnail($img,$this->_thumbnail,100, 100);

            $order = $this->photo->getOrder();
            $product->photos()->save(new \App\Models\Photo([
              'img_url' => $this->common->getPath($img, asset('public/upload')),
              'thumb_url' => $this->common->getPath($thumbnail, asset('public/upload')),
              'order'=>$order,
            ]));
          }
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
        // dd($this->productRepo->make(['photos'])->find(19));
        $inst = $this->productRepo->find($id,['*'],['photos']);
        return view('Admin::pages.product.edit', compact('inst'));
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
        $img_url = $this->common->getPath($request->input('avatar_img'));
        $meta_image = $this->common->getPath($request->input('meta_image'));

        $data = [
                'title' => $request->input('title'),
                'slug' => \LP_lib::unicode($request->input('title')),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'category_id' => 1,
                'avatar_img' => $img_url,
                'meta_keywords' => $request->input('meta_keywords'),
                'meta_description' => $request->input('meta_description'),
                'meta_images' => $meta_image,
                'order' => $request->input('order'),
                'status' => $request->input('status'),
        ];
        $product = $this->productRepo->update($data, $id);

        if($request->hasFile('thumb-input')){
          foreach($request->file('thumb-input') as $k=>$thumb){
            $img = $this->common->uploadImage($request, $thumb, $this->_bigsize,$resize = false);
            $thumbnail = $this->common->createThumbnail($img,$this->_thumbnail,100, 100);

            $order = $this->photo->getOrder();
            $product->photos()->save(new \App\Models\Photo([
              'img_url' => $this->common->getPath($img, asset('public/upload')),
              'thumb_url' => $this->common->getPath($thumbnail, asset('public/upload')),
              'order'=>$order,
            ]));
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
        $this->productRepo->delete($id);
        return redirect()->route('admin.product.index')->with('success', 'Deleted !');
    }

    /*DELETE ALL*/
    public function deleteAll(Request $request)
    {
      if(!$request->ajax()){
          abort(404);
      }else{
           $data = $request->arr;
           $response = $this->productRepo->deleteAll($data);
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
                $obj = $this->productRepo->find($k);
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
            $cate = $this->productRepo->find($id);
            $cate->status = $value;
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
            $cate = $this->productRepo->find($id);
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
            $id = $request->input('id_photo');
            $this->photo->delete($id);
            return response()->json([
                'mes' => 'Deleted',
                'error'=> false,
            ], 200);
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
