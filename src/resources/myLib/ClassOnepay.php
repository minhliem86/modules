<?php

/**
 * @link http://www.giicms.com/
 * @copyright Copyright (c) 2015 Giicms.,ltd
 * @license https://github.com/giicms/one_pay/blob/master/LICENSE
 * @author Vinh Huynh <huynhtuvinh87@gmail.com>
 */

class ClassOnepay
{

    //private $onepay_url = 'http://mtf.onepay.vn/onecomm-pay/vpc.op';
    // link thanh toan noi dia
    private $onepay_url_vn = 'https://mtf.onepay.vn/onecomm-pay/vpc.op';
    // link thanh toan quoc te
    private $onepay_url = 'https://mtf.onepay.vn/vpcpay/vpcpay.op';
    //$_POST['AgainLink']=urlencode($HTTP_REFERER);
    // Khóa bí mật - được cấp bởi OnePAY
    private $secure = '';
    // Mã merchante site 
    private $merchant = ''; // được cấp bởi OnePAY
    // Mật khẩu bảo mật
    private $access = ''; // được cấp bởi OnePAY

    // function cài đặt cac bien private trong class

    public function setupMerchant($merchant, $access, $secure)
    {
        $this->merchant = $merchant;
        $this->access = $access;
        $this->secure = $secure;
    }

    /**
    public function build_link_vn($order_id, $total_amount, $order_info, $url_return)
    {
        // tạo chuỗi dữ liệu được bắt đầu bằng khóa bí mật
        $md5HashData = $this->secure;
        // sắp xếp dữ liệu theo thứ tự a-z trước khi nối lại
        // arrange array data a-z before make a hash

        $array = array
        (
            'Title' => 'VPC 3-Party',
            'vpc_Merchant' => $this->merchant,
            'vpc_AccessCode' => $this->access,
            'vpc_MerchTxnRef' => $order_id,
            'vpc_OrderInfo' => $order_info,
            'vpc_Amount' => $total_amount * 100,
            'vpc_ReturnURL' => $url_return,
            'vpc_Version' => '2',
            'vpc_Command' => 'pay',
            'vpc_Locale' => 'en',
            'vpc_Currency' => 'VND'
        );
        ksort($array);
        $vpcURL = '';
        foreach ($array as $key => $value) {
            $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
            $md5HashData .= $value;
        }
        $vpcURL = ltrim($vpcURL, '&');

        $vpcURL = $this->onepay_url_vn . '?' . $vpcURL;
        if (strlen($this->secure) > 0) {
            $vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
        }
        return $vpcURL;
    }

    public function build_link($order_id, $total_amount, $order_info, $url_return)
    {
        // tạo chuỗi dữ liệu được bắt đầu bằng khóa bí mật
        $md5HashData = $this->secure;
        // sắp xếp dữ liệu theo thứ tự a-z trước khi nối lại
        // arrange array data a-z before make a hash

        $array = array
        (
            'Title' => 'VPC 3-Party',
            'vpc_Merchant' => $this->merchant,
            'vpc_AccessCode' => $this->access,
            'vpc_MerchTxnRef' => $order_id,
            'vpc_OrderInfo' => $order_info,
            'vpc_Amount' => $total_amount * 100,
            'vpc_ReturnURL' => $url_return,
            'vpc_Version' => '2',
            'vpc_Command' => 'pay',
            'vpc_Locale' => 'en',
            'vpc_Currency' => 'VND'
        );
        ksort($array);
        $vpcURL = '';
        foreach ($array as $key => $value) {
            $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
            $md5HashData .= $value;
        }
        $vpcURL = ltrim($vpcURL, '&');

        $vpcURL = $this->onepay_url . '?' . $vpcURL;
        if (strlen($this->secure) > 0) {
            $vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
        }
        return $vpcURL;
    }
    **/

    public function build_link_global($array_data, $order_id, $total_amount, $order_info, $url_return, $customer_id)
    {
        $vpcURL = $this->onepay_url . '?';

        // Remove the Virtual Payment Client URL from the parameter hash as we
        // do not want to send these fields to the Virtual Payment Client.

        // The URL link for the receipt to do another transaction.
        // Note: This is ONLY used for this example and is not required for
        // production code. You would hard code your own URL into your application.

        // Get and URL Encode the AgainLink. Add the AgainLink to the array
        // Shows how a user field (such as application SessionIDs) could be added
        $array_data['AgainLink'] = urlencode($_SERVER['HTTP_REFERER']);
        //$array_data['AgainLink']=urlencode($_SERVER['HTTP_REFERER']);
        // Create the request to the Virtual Payment Client which is a URL encoded GET
        // request. Since we are looping through all the data we may as well sort it in
        // case we want to create a secure hash and add it to the VPC data if the
        // merchant secret has been provided.
        //$md5HashData = $SECURE_SECRET; Khởi tạo chuỗi dữ liệu mã hóa trống
        $md5HashData = "";

        $array_data['vpc_Merchant'] = $this->merchant;
        $array_data['vpc_AccessCode'] = $this->access;
        $array_data['vpc_MerchTxnRef'] = $order_id;
        $array_data['vpc_OrderInfo'] = $order_info;
        $array_data['vpc_Amount'] = $total_amount * 100;
        $array_data['vpc_ReturnURL'] = $url_return;
        $array_data['vpc_Version'] = 2;
        $array_data['vpc_Command'] = 'pay';
        $array_data['vpc_Locale'] = 'vn';
        $array_data['vpc_Currency'] = 'VND';
        $array_data['vpc_Customer_Id'] = $customer_id;

        unset($array_data['_token']);

        ksort($array_data);

        // set a parameter to show the first pair in the URL
        $appendAmp = 0;

        foreach ($array_data as $key => $value) {

            // create the md5 input and URL leaving out any fields that have no value
            if (strlen($value) > 0) {

                // this ensures the first paramter of the URL is preceded by the '?' char
                if ($appendAmp == 0) {
                    $vpcURL .= urlencode($key) . '=' . urlencode($value);
                    $appendAmp = 1;
                } else {
                    $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                }
                //$md5HashData .= $value; sử dụng cả tên và giá trị tham số để mã hóa
                if ((strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                    $md5HashData .= $key . "=" . $value . "&";
                }
            }
        }
        //xóa ký tự & ở thừa ở cuối chuỗi dữ liệu mã hóa
        $md5HashData = rtrim($md5HashData, "&");
        // Create the secure hash and append it to the Virtual Payment Client Data if
        // the merchant secret has been provided.
        if (strlen($this->secure) > 0) {
            //$vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
            // Thay hàm mã hóa dữ liệu
            $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*', $this->secure)));
        }

        return $vpcURL;
    }

    public function check_response($array_data)
    {
        $vpc_Txn_Secure_Hash = $array_data["vpc_SecureHash"];
        unset($array_data["vpc_SecureHash"]);

        // set a flag to indicate if hash has been validated
        $errorExists = false;

        if (strlen($this->secure) > 0 && $array_data["vpc_TxnResponseCode"] != "7" && $array_data["vpc_TxnResponseCode"] != "No Value Returned") {

            ksort($array_data);
            //$md5HashData = $this->>$this->secure;
            //khởi tạo chuỗi mã hóa rỗng
            $md5HashData = "";
            // sort all the incoming vpc response fields and leave out any with no value
            foreach ($array_data as $key => $value) {
//        if ($key != "vpc_SecureHash" or strlen($value) > 0) {
//            $md5HashData .= $value;
//        }
                //      chỉ lấy các tham số bắt đầu bằng "vpc_" hoặc "user_" và khác trống và không phải chuỗi hash code trả về
                if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0,4)=="vpc_") || (substr($key,0,5) =="user_"))) {
                    $md5HashData .= $key . "=" . $value . "&";
                }
            }
            //  Xóa dấu & thừa cuối chuỗi dữ liệu
            $md5HashData = rtrim($md5HashData, "&");

            //    if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper ( md5 ( $md5HashData ) )) {
            //    Thay hàm tạo chuỗi mã hóa
            if (strtoupper ( $vpc_Txn_Secure_Hash ) == strtoupper(hash_hmac('SHA256', $md5HashData, pack('H*',$this->secure)))) {
                // Secure Hash validation succeeded, add a data field to be displayed
                // later.
                $hashValidated = "CORRECT";
            } else {
                // Secure Hash validation failed, add a data field to be displayed
                // later.
                $hashValidated = "INVALID HASH";
            }
        } else {
            // Secure Hash was not validated, add a data field to be displayed later.
            $hashValidated = "INVALID HASH";
        }

        return $hashValidated;
    }

    /**
    public function validate($mang)
    {
        $vpc_Txn_Secure_Hash = $mang["vpc_SecureHash"];
        unset($mang["vpc_SecureHash"]);

        // set a flag to indicate if hash has been validated
        $errorExists = false;

        if (strlen($this->secure) > 0 && $mang["vpc_TxnResponseCode"] != "7" && $mang["vpc_TxnResponseCode"] != "No Value Returned") {
            $md5HashData = $this->secure;

            // sort all the incoming vpc response fields and leave out any with no value
            foreach ($mang as $key => $value) {
                if ($key != "vpc_SecureHash" || strlen($value) > 0)
                    $md5HashData .= $value;
            }

            // Validate the Secure Hash (remember MD5 hashes are not case sensitive)
            // This is just one way of displaying the result of checking the hash.
            // In production, you would work out your own way of presenting the result.
            // The hash check is all about detecting if the data has changed in transit.
            if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(md5($md5HashData))) {
                // Secure Hash validation succeeded, add a data field to be displayed
                // later.
                $hashValidated = "CORRECT";
            } else {
                // Secure Hash validation failed, add a data field to be displayed
                // later.
                $hashValidated = "INVALID HASH";
            }
        } else {
            // Secure Hash was not validated, add a data field to be displayed later.
            $hashValidated = "INVALID HASH";
        }
        return $hashValidated;
    }
     **/

    // This method uses the QSI Response code retrieved from the Digital
    // Receipt and returns an appropriate description for the QSI Response Code
    //
    // @param $responseCode String containing the QSI Response Code
    //
    // @return String containing the appropriate description
    //
    public function getResponseDescription($responseCode)
    {

        switch ($responseCode) {
            case "0" :
                $result = "Giao dịch thành công - Approved";
                break;
            case "1" :
                $result = "Ngân hàng từ chối giao dịch - Bank Declined";
                break;
            case "3" :
                $result = "Mã đơn vị không tồn tại - Merchant not exist";
                break;
            case "4" :
                $result = "Không đúng access code - Invalid access code";
                break;
            case "5" :
                $result = "Số tiền không hợp lệ - Invalid amount";
                break;
            case "6" :
                $result = "Mã tiền tệ không tồn tại - Invalid currency code";
                break;
            case "7" :
                $result = "Lỗi không xác định - Unspecified Failure ";
                break;
            case "8" :
                $result = "Số thẻ không đúng - Invalid card Number";
                break;
            case "9" :
                $result = "Tên chủ thẻ không đúng - Invalid card name";
                break;
            case "10" :
                $result = "Thẻ hết hạn/Thẻ bị khóa - Expired Card";
                break;
            case "11" :
                $result = "Thẻ chưa đăng ký sử dụng dịch vụ - Card Not Registed Service(internet banking)";
                break;
            case "12" :
                $result = "Ngày phát hành/Hết hạn không đúng - Invalid card date";
                break;
            case "13" :
                $result = "Vượt quá hạn mức thanh toán - Exist Amount";
                break;
            case "21" :
                $result = "Số tiền không đủ để thanh toán - Insufficient fund";
                break;
            case "99" :
                $result = "Người sủ dụng hủy giao dịch - User cancel";
                break;
            default :
                $result = "Giao dịch thất bại - Failured";
        }
        return $result;
    }

    //  -----------------------------------------------------------------------------
    // If input is null, returns string "No Value Returned", else returns input
    public function null2unknown($data)
    {
        if ($data == "") {
            return "No Value Returned";
        } else {
            return $data;
        }
    }

}
