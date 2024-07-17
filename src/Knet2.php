<?php

namespace Mostafax\Knet;

use Mostafax\Knet\Models\Payment;
use Mostafax\Knet\Requests\KnetRequest;
use Illuminate\Http\Request;

class Knet
{
   

    public function __construct()
    {
        $this->url = env('APP_ENV') == 'local' ? env('PAYMENT_TEST_URL') : env('PAYMENT_PRODUCTION_URL');
        $this->payment = new Payment;
    }



    public function success(Request $request)
    {
        $data = $this->handleError($request->all());
        $this->payment->where('track_id', $data['trackid'])->update([
            'payment_id' => $data['paymentid'],
            'tran_id' => ($data['tranid']) ?? null,
            'ref_id' => ($data['ref'])?? null,
            'status' => 1,
            'result' => ($data['result'])?? null,
            'udf1' => ($data['udf1'])?? null,
            'udf2' => ($data['udf2'])?? null,
            'udf3' => ($data['udf3'])?? null,
            'udf4' => ($data['udf4'])?? null,
            'udf5' => ($data['udf5'])?? null,
        ]);

        return view('knet::success', compact('data'));
    }

    public function error(Request $request)
    { 
        $data = $this->handleError($request->all());
        $this->payment->where('track_id', $data['trackid'])->update([
            'payment_id' => $data['paymentid'],
            'tran_id' => ($data['tranid']) ?? null,
            'ref_id' => ($data['ref']) ?? null,
            'status' => 2,
            'result' => ($data['result']) ?? null,
            'udf1' => ($data['udf1']) ?? null,
            'udf2' => ($data['udf2']) ?? null,
            'udf3' => ($data['udf3']) ?? null,
            'udf4' => ($data['udf4']) ?? null,
            'udf5' => ($data['udf5']) ?? null,
        ]);
        return view('knet::error', compact('data'));
    }


    public function init(KnetRequest $request, $data  = null)
    {
        $data = (is_array($data)) ? $data : $request->all();
        $this->payment->create($data);
        return $this->pay($data);
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


    public function handleError($data)
    {
        $ResTranData = isset($data['trandata']) && !empty($data['trandata']) ? $data['trandata'] : '';
        $termResourceKey = env('PAYMENT_RESOURCE_KEY');
        if ($ResTranData != '') {
            $decrytedData = $this->decrypt($ResTranData, $termResourceKey);
            parse_str($decrytedData, $payment);
        } else {
            $payment = $data;
        }

        return $payment;
    }

    /**
     * @param array $data
     * @return array
     */
    public function checkPayment(array $data): array
    {
        $ResTranData = $data['trandata'] ?? '';
        if ($data['trandata'] == '' && $data['result'] != 'CAPTURED') {
            Payment::where('id', $data['udf5'])->update([
                'payment_id' => $data['paymentid'],
                'updated_at' => date('Y-m-d H:i:s'),
                'pay' => -1
            ]);
            return ['success' => 0, 'data' => $data['paymentid']];
        }


        $termResourceKey = env('PAYMENT_RESOURCE_KEY');
        if ($data['trandata'] != '') {
            $decryptedData = $this->decrypt($ResTranData, $termResourceKey);
            parse_str($decryptedData, $payData);
        } else {
            $payData = $data;
        }

        Log::info('pay Data: ', $payData);
        $this->create_log('payment', 'pay Data', 'payment', $payData['udf1'], 'client', $payData['udf2'], json_encode($payData));

        if ($payData['result'] != 'CAPTURED') {
            Payment::where('id', $payData['udf1'])->update([
                'payment_id' => $payData['paymentid'], 'updated_at' => date('Y-m-d H:i:s'), 'pay' => -1
            ]);
            return ['success' => 0, 'data' => $payData];
        } else {
            //            $payment_date = $payData['postdate'];
            //            $payment_date = date('Y').'-'.substr($payment_date, 0, 2).'-'.substr($payment_date, 2, 2) ?? date('Y-m-d');

            $result = [
                'id' => $payData['udf1'],
                'result' => $payData['result'],
                'track_id' => $payData['trackid'],
                'trans_id' => $payData['tranid'],
                'payment_id' => $payData['paymentid'],
                'auth' => $payData['auth'],
                'amount' => $payData['amt'],
                'postdate' => $payData['postdate'],
                'ref' => $payData['ref']
            ];

            //                dd($payData['udf5']);
            if ($payData['udf5'] !== null) {
                $instalment = Instalment::with('client')->find($payData['udf5']);
                if ($instalment) {
                    $instalment->update(['is_paid' => 1]);
                    // Push Notification to Admin
                    $users = User::whereNotNull('email_verified_at')->get();
                    foreach ($users as $user) {
                        $user->notify(new NewInstallment($instalment));
                    }

                    //                    if (isset($instalment->client)) {
                    //                        $order['paymentData'] = $result;
                    //                        $order['name'] = $instalment->client->name ?? '';
                    //                        $order['subject'] = 'New Installment Request';
                    //                        $order['date'] = date('Y-m-d H:i:s');
                    //                        Mail::to($instalment->client->email)->send(new newInstallmentReceipt($order));
                    //                    }

                }
            }


            $pay = Payment::where('id', $result['id'])->update([
                'payment_id' => $result['payment_id'],
                'updated_at' => date('Y-m-d H:i:s'),
                'pay' => 1,
                'post_date' => $payData['postdate'],
                'tran_id' => $result['trans_id'],
                'auth' => $result['auth'],
                'ref' => $result['ref'],
            ]);
            Log::info('update Payment in system Easybuy after paid');
            $this->create_log('payment', 'update Payment in system Easybuy after paid', 'payment', $result['id'], 'client', $payData['udf2'], Null);


            try {
                //                $payment = Payment::where('id', $result['id'])->first();
                //    (new Controller())->updatePaymentOracle($payment, $payData);
            } catch (\Exception $e) {
                Log::info($e);
            }

            return ['success' => 1, 'data' => $result];
        }
    }

    public function check($track_id, $pay_id, $amount = null)
    {
        $url = 'https://kpay.com.kw/kpg/tranPipe.htm?param=tranInit&=';
        info('url : ' . $url);
        $xml = '<id>134501</id><password>134501pg</password><action>8</action><amt>' . $amount . '</amt><transid>' . $track_id . '</transid><udf5>TrackID</udf5><trackid>' . $track_id . '</trackid>';

        /*init curl post request*/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-type: application/xml',
            'Content-length: ' . strlen($xml),
        ));
        $output = curl_exec($ch);
        curl_close($ch);
        info('knet output : ' . \GuzzleHttp\json_encode($output));

        /*return result*/
        $xml = simplexml_load_string('<root>' . $output . '</root>');
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);
        info('knet result : ' . \GuzzleHttp\json_encode($array));
        if ($array['result'] != 'SUCCESS') {
            return [
                'status' => 0,
                'data' => []
            ];
        }
        return [
            'status' => 1,
            'data' => $array
        ];
    }


}
