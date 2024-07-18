<?php

namespace Mostafax\Knet\Services;
use GuzzleHttp\Client;
class knet
{
    private $url;
    private $payment;

    public function __construct()
    {
        $this->url = env('APP_ENV') == 'local' ? env('PAYMENT_TEST_URL') : env('PAYMENT_PRODUCTION_URL');
        // $this->payment = new Payment;
    }

        /**
     * @param array $data
     * @return array
     */
    public function pay(array $data)
    {
        $param = $this->initPayment($data);

        $termResourceKey = env('PAYMENT_RESOURCE_KEY');

        $param = $this->encryptAES($param, $termResourceKey) . "&tranportalId=" . env('PAYMENT_TRANSPORT_ID') .
            "&responseURL=" . env('PAYMENT_SUCCESS_URL') . "&errorURL=" . env('PAYMENT_ERROR_URL');

        if ($param) {
            return ['success' => true, 'url' => $this->url . "&trandata=" . $param];
        }
        return ['success' => false, 'message' => trans('main.error')];
    }



        /**
     * @param array $data
     * @return string
     */
    public function initPayment(array $data)
    {
        $ReqTranportalId = "id=" . env('PAYMENT_TRANSPORT_ID');
        $ReqTranportalPassword = "password=" . env('PAYMENT_TRANSPORT_PASSWORD');
        $ReqAmount = "amt=" . $data['amount'];
        $ReqTrackId = "trackid=" . $data['track_id'];
        $ReqCurrency = "currencycode=" . env('PAYMENT_CURRENCY');
        $ReqLangid = "langid=" . env('PAYMENT_LANGUAGE');
        $ReqAction = "action=" . env('PAYMENT_ACTION_CODE');
        $ReqResponseUrl = "responseURL=" . env('PAYMENT_SUCCESS_URL');
        $ReqErrorUrl = "errorURL=" . env('PAYMENT_ERROR_URL');
        $ReqUdf = "udf1=" . $data['udf1'] . '&udf2=' . $data['udf2'] . '&udf3=' . $data['udf3'] . '&udf4=' . $data['udf4'] . '&udf5=' . $data['udf5'];

        return $ReqTranportalId . "&" . $ReqTranportalPassword . "&" . $ReqAction . "&" . $ReqLangid . "&" .
            $ReqCurrency . "&" . $ReqAmount . "&" . $ReqResponseUrl . "&" . $ReqErrorUrl . "&" . $ReqTrackId . "&" .
            $ReqUdf;
    }


    public function check($track_id, $amount)
    {
        $knetApiUrl =  env('PAYMENT_CHECK');
        $xmlRequest = '<id>'.env('PAYMENT_TRANSPORT_ID').'</id><password>'.env('PAYMENT_TRANSPORT_PASSWORD').'</password><action>8</action><amt>' . $amount . '</amt><transid>' . $track_id . '</transid><udf5>TrackID</udf5><trackid>' . $track_id . '</trackid>';

        // Create a new Guzzle HTTP client
       $client = new Client();
       // Send the request to the Knet API
       $response = $client->request('POST', $knetApiUrl, [
           'headers' => [
               'Content-Type' => 'application/xml',
               'Accept' => 'application/xml',
               'Content-length: ' . strlen($xmlRequest)
           ],
           'body' => $xmlRequest,
       ]);
        // Check if the request was successful
        if ($response->getStatusCode() == 200) {
            $xmlResponse = $response->getBody()->getContents();
            $xmlResponse = "<response>" . $xmlResponse . "</response>";
            $paymentStatus = simplexml_load_string($xmlResponse);
            return [
                'status' => 1,
                'data' => $paymentStatus
            ];
        } else {
            return [
                'status' => 0,
                'data' => []
            ];
        }
    }

    function encryptAES($str, $key): string
    {
        $str = $this->pkcs5_pad($str);
        $encrypted = openssl_encrypt($str, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $key);


        $encrypted = base64_decode($encrypted);
        $encrypted = unpack('C*', ($encrypted));
        $encrypted = $this->byteArray2Hex($encrypted);
        $encrypted = urlencode($encrypted);
        return $encrypted;
    }

    function pkcs5_pad($text)
    {
        $blocksize = 16;
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    function byteArray2Hex($byteArray)
    {
        $chars = array_map("chr", $byteArray);
        $bin = join($chars);
        return bin2hex($bin);
    }

    function decrypt($code, $key)
    {
        $code = $this->hex2ByteArray(trim($code));
        $code = $this->byteArray2String($code);
        $iv = $key;
        $code = base64_encode($code);
        $decrypted = openssl_decrypt($code, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        return $this->pkcs5_unpad($decrypted);
    }

    function hex2ByteArray($hexString)
    {
        $string = hex2bin($hexString);
        return unpack('C*', $string);
    }

    function byteArray2String($byteArray)
    {
        $chars = array_map("chr", $byteArray);
        return join($chars);
    }

    function pkcs5_unpad($text)
    {
        $pad = ord($text[strlen($text) - 1]);
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }
}
