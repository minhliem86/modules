<?php

namespace App\Repositories\Eloquent;

use App\Modules\Admin\Events\PhotoWasDeleted;
use App\Modules\Admin\Events\PhotoWasUploaded;
use Intervention\Image\ImageManager;
use App\Models\Photo;
use Event;

use App\Repositories\Eloquent\CommonRepository;

class UploadRepository
{
    /**
     * Upload Single Image
     *
     * @param $input
     * @return mixed
     */
    protected $photo;
    protected $common;
    protected $_removePath = 'public/upload/';
    public function __construct(CommonRepository $common, Photo $photo){
      $this->photo = $photo;
      $this->common = $common;
    }
    public function upload($input)
    {
        $validator = \Validator::make($input, config('dropzoner.validator'), config('dropzoner.validator-messages'));

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->messages()->first(),
                'code' => 400
            ], 400);
        }

        $photo = $input['file'];
        $original_name = $photo->getClientOriginalName();
        $extension = $photo->getClientOriginalExtension();
        $original_name_without_extension = substr($original_name, 0, strlen($original_name) - strlen($extension) - 1);

        $filename = $this->sanitize($original_name_without_extension);
        $allowed_filename = $this->createUniqueFilename( $filename );
        $filename_with_extension = $allowed_filename .'.' . $extension;

        $manager = new ImageManager();
        $image = $manager->make( $photo )->save(config('dropzoner.upload-path') . $filename_with_extension );

        // $img_thumb = $manager->make( $photo )->resize(400, 210)->save(config('dropzoner.thumb-path'). $filename_with_extension );

        if( !$image ) {
            return response()->json([
                'error' => true,
                'message' => 'Server error while uploading',
                'code' => 500
            ], 500);
        }

        // Fire ImageWasUploaded Event
        $img_url = $this->common->getPath(config('dropzoner.upload-path').$filename_with_extension, $this->_removePath);
        $current = $this->getOrder();
        $data = [
          'title' => $input['text_title'],
        //   'album_id' => $input['album_id'],
          'img_url' =>  $img_url,
        //   'thumbnail_url' =>  asset(config('dropzoner.thumb-path').$filename_with_extension),
          'order' => $current,
          'filename' => $filename_with_extension,
        ];

        event(new PhotoWasUploaded($original_name, $filename_with_extension, $data));

        return response()->json([
            'error' => false,
            'code'  => 200,
            'filename' => $filename_with_extension
        ], 200);
    }

    /**
     * Delete Single Image
     *
     * @param $server_filename
     * @return mixed
     */
    public function delete($id)
    {
        $server_filename = $this->getNameImg($id);
        $img = config('dropzoner.upload-path');
        $thumb = config('dropzoner.thumb-path');
        $full_path = $img . $server_filename;
        $thumb_path = $thumb . $server_filename;

        if (\File::exists($full_path)) {
            \File::delete($full_path);
        }
        if (\File::exists($thumb_path)) {
            \File::delete($thumb_path);
        }
        event(new PhotoWasDeleted($id));
        return response()->json([
            'error' => false,
            'code'  => 200
        ], 200);
    }

    public function deleteAll($data){
      $img = config('dropzoner.upload-path');
      $thumb = config('dropzoner.thumb-path');
      foreach($data as $item){
        $server_filename = $this->getNameImg($item);
        $full_path = $img . $server_filename;
        $thumb_path = $thumb . $server_filename;

        if (\File::exists($full_path)) {
            \File::delete($full_path);
        }
        if (\File::exists($thumb_path)) {
            \File::delete($thumb_path);
        }

        event(new PhotoWasDeleted($item));
      }
      return response()->json([
          'error' => false,
          'code'  => 200
      ], 200);
    }

    /**
     * Check upload directory and see it there a file with same filename
     * If filename is same, add random 5 char string to the end
     *
     * @param $filename
     * @return string
     */
    private function createUniqueFilename( $filename )
    {
        $full_size_dir = config('dropzoner.upload-path');
        $full_image_path = $full_size_dir . $filename . '.jpg';

        if (\File::exists($full_image_path)) {
            // Generate token for image
            $image_token = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $image_token;
        }

        return $filename;
    }

    /**
     * Create safe file names for server side
     *
     * @param $string
     * @param bool $force_lowercase
     * @return mixed|string
     */
    private function sanitize($string, $force_lowercase = true)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);

        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    public function getOrder(){
      $order = $this->photo->orderBy('order','DESC')->first();
      count($order) == 0 ?  $current = 1 :  $current = $order->order +1 ;
      return $current;
    }

    public function getNameImg($id){
      return $this->photo->find($id)->filename;
    }
}
