<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Repositories\Eloquent\CommonRepository;


use App\Repositories\Eloquent\UploadRepository;
use App\Repositories\PhotoRepository;

class MultiPhotoController extends Controller
{
    protected $up_photos;
    protected $photo;
    protected $common;
    protected $_removePath = 'public/upload/';

    public function __construct(CommonRepository $common, UploadRepository $up_photos, PhotoRepository $photo){
        $this->up_photos = $up_photos;
        $this->photo = $photo;
        $this->common = $common;
    }
    public function getIndex()
    {
        $inst = $this->photo->all();
        return view('Admin::pages.multi-photo.index', compact('inst'));
    }

    public function getCreate()
    {
        return view('Admin::pages.multi-photo.create');
    }

    public function postCreate(Request $request)
    {
         $input = $request->all();
         $response = $this->up_photos->upload($input);
         return $response;
    }

    public function getEdit($id)
    {
      $inst = $this->photo->find($id);
      return view('Admin::pages.multi-photo.edit', compact('inst'));
    }

    public function postEdit(Request $request, $id)
    {
      $img_url = $request->hasFile('img_url') ?  $this->common->getPath($this->common->uploadImage($request, $request->file('img_url'),env('DROPZONER_UPLOAD_PATH'),false), asset($this->_removePath).'/')  : $this->photo->find($id)->img_url;
      $data = [
          'title' => $request->input('title'),
          'img_url' => $img_url,
          'order' => $request->input('order'),
      ];
      if($this->photo->update($data, $id)){
          return redirect()->route('admin.photo.index')->with('success', 'Update Successful.');
      }
          return redirect()->route('admin.photo.index')->with('error', 'Update Fail.');
    }

    public function destroy($id)
    {
        $response = $this->up_photos->delete($id);
        if(!$response->getData()->error){
            return redirect()->route('admin.photo.index')->with('success','Item Deleted.');
        }
    }

    public function deleteAll(Request $request)
    {
      if(!$request->ajax()){
        abort(404, 'No Permission');
      }else{
        $data = $request->input('arr');
        $this->up_photos->deleteAll($data);
      }
    }
}
