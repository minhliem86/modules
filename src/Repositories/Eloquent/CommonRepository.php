<?php
namespace App\Repositories\Eloquent;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Validator;
use Notification;

class CommonRepository{
    public function uploadImage($request, $file, $path, $width = null, $height = null, $removePath = ''){
        $name = preg_replace('/\s+/', '', $file->getClientOriginalName());
        $filename = time().'_'.$name;

        $img = \Image::make($file->getRealPath());

        $folder = $path . '/'.$width.'x'.$height;
        $filesystem = new Filesystem();
        if(!$filesystem->exists($folder)){
            $filesystem->makeDirectory($folder, 0775, true);
        }

        $img->resize($width,$height, function ($constraint){
            $constraint->aspectRatio();
        })->save($folder.'/'.$filename);

        $file->move($path,$filename);

        $main_path = $this->getPath($path.'/'.$filename, '', $removePath);
        $thumbnail_path = $this->getPath($path.'/thumbnails/'.$width.'x'.$height.'/'.$filename, '', $removePath);

        return $response = [
            'name' => $filename,
            'path' => $main_path,
            'thumbnail' => $thumbnail_path
        ];
    }

    public function createThumbnail($fullfile, $location, $width = 500, $height = 250, $removePath = '')
    {
        if($fullfile){
            $arr_thumb = explode('/',$fullfile);
            $item = end($arr_thumb);
            $folder = base_path($location) . '/'.$width.'x'.$height;
            $filesystem = new Filesystem();
            if(!$filesystem->exists($folder)){
                $filesystem->makeDirectory($folder, 0775, true);
            }
            $filename = time();
            \Image::make(asset($fullfile))->fit($width, $height)->save($folder.'/'.$item);

            $thumb_url = $folder.'/'.$item;


            return $this->getPath($thumb_url, '', $removePath);
        }else{
            return '';
        }
    }

    public function getPath($path, $replace = '', $removePath = '/laravel-filemanager/')
    {
        return $str = str_replace($removePath, $replace, $path);
    }

    public function getFileName($fullfile)
    {
        if($fullfile){
            $arr_thumb = explode('/',$fullfile);
            return $item = end($arr_thumb);
        }
    }
}
