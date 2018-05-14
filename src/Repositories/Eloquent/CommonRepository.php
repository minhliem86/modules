<?php
namespace App\Repositories\Eloquent;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Validator;
use Notification;

class CommonRepository{
    public function uploadImage($request, $file, $path, $resize = true, $width = null, $height = null, $removePath = ''){
        $destinationPath = base_path($path);
        $name = preg_replace('/\s+/', '', $file->getClientOriginalName());
        $filename = time().'_'.$name;

        if($resize){
            $filename_resize = $destinationPath.'/'.$filename;
            \Image::make($file->getRealPath())->resize($width,$height)->save($filename_resize);
        }else{
            $img = $file->move($destinationPath,$filename);
        }
        $img_url = $destinationPath.'/'.$filename;
        return $this->getPath($img_url, '', $removePath);
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
