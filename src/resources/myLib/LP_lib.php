<?php
class LP_lib{
  /***
  SET ACTIVE
  ***/
  public static function setActive($segment,$route,$class='active'){
		return (\Request::segment($segment) == $route ? $class : '');
	}

  /**
 	 * Block comment
 	 *
 	 * @param string
 	 * UNICODE
	 */
   public static function unicode($string)
   {
       // Chuyển đổi chuỗi kí tự thành dạng slug dùng cho việc tạo friendly url.
           // @access    public
           // @param    string
           // @return    string

           $search = array (
               '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
               '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
               '#(ì|í|ị|ỉ|ĩ)#',
               '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
               '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
               '#(ỳ|ý|ỵ|ỷ|ỹ)#',
               '#(đ)#',
               '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
               '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
               '#(Ì|Í|Ị|Ỉ|Ĩ)#',
               '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
               '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
               '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
               '#(Đ)#',
               "/[^a-zA-Z0-9\-\_]/",
               ) ;
           $replace = array (
               'a',
               'e',
               'i',
               'o',
               'u',
               'y',
               'd',
               'A',
               'E',
               'I',
               'O',
               'U',
               'Y',
               'D',
               '-',
               ) ;
           $string = preg_replace($search, $replace, $string);
           $string = preg_replace('/(-)+/', '-', $string);
           $string = strtolower($string);
           return $string;
   }

   /**
 	 * Block comment
 	 *
 	 * @param type
 	 * UNICODE No SPACE
	 */

   public static function unicodenospace($string){
       // Chuyển đổi chuỗi kí tự thành dạng slug dùng cho việc tạo friendly url.
           // @access    public
           // @param    string
           // @return    string

           $search = array (
               '#(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)#',
               '#(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)#',
               '#(ì|í|ị|ỉ|ĩ)#',
               '#(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)#',
               '#(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)#',
               '#(ỳ|ý|ỵ|ỷ|ỹ)#',
               '#(đ)#',
               '#(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)#',
               '#(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)#',
               '#(Ì|Í|Ị|Ỉ|Ĩ)#',
               '#(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)#',
               '#(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)#',
               '#(Ỳ|Ý|Ỵ|Ỷ|Ỹ)#',
               '#(Đ)#',
               "/[^a-zA-Z0-9\-\_]/",
               ) ;
           $replace = array (
               'a',
               'e',
               'i',
               'o',
               'u',
               'y',
               'd',
               'A',
               'E',
               'I',
               'O',
               'U',
               'Y',
               'D',
               '-',
               ) ;
           $string = preg_replace($search, $replace, $string);
           $string = preg_replace('/(-)+/', '', $string);
           $string = strtolower($string);
           return $string;
   }

   /**
 	 * Block comment
 	 *
 	 * @param type
 	 * CREATE UNIQUE STRING
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

   /**
 	 * Block comment
 	 *
 	 * @param type
 	 * Tách chuội lấy tên IMG
	 */

   public static function getString($chuoi,$kytu,$vitricanlay){
     $mang = explode($kytu,$chuoi);
     $str = $mang[$vitricanlay];
     return $str;
   }

   /**
 	 * Block comment
 	 *
 	 * @param type
 	 *Lấy tên IMG từ đường dẫn
	 */
   public static function getImgName($chuoi1,$path_img,$chuoi2="."){
 		$arr1 = explode($chuoi1, $path_img);
 		$last_ele = end($arr1);
 		$arr2 = explode($chuoi2, $last_ele);
 		return current($arr2);
 	}







}
