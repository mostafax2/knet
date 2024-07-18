<?php
// app/Knet/Knet.php
namespace Mostafax\Knet;

use Mostafax\Knet\Requests\KnetRequest;
use Illuminate\Http\Request;
use Mostafax\Knet\Repositories\PaymentRepository;
use Mostafax\Knet\Services\knet;
use Mostafax\Knet\Models\Payment;

class KnetController
{
    private $url;
    private $paymentRepository;
    private $knetService;
    private $payment;

    public function __construct(PaymentRepository $paymentRepository,Knet $knetService)
    {
        $this->url = env('APP_ENV') == 'local' ? env('PAYMENT_TEST_URL') : env('PAYMENT_PRODUCTION_URL');
        $this->paymentRepository = $paymentRepository;
        $this->knetService = $knetService;
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
        // Handle init logic
        $data = (is_array($data)) ? $data : $request->all();
        $this->paymentRepository->createPayment($data);
        return $this->knetService->pay($data);
    }

    function form()  {
        return view("knet::form");
    }

    public function handleError($data)
    {
        $ResTranData = isset($data['trandata']) && !empty($data['trandata']) ? $data['trandata'] : '';
        $termResourceKey = env('PAYMENT_RESOURCE_KEY');
        if ($ResTranData != '') {
            $decrytedData =  $this->knetService->decrypt($ResTranData, $termResourceKey);
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
    public function checkPayment($track_id, $amount = null)
    {

        $payment = $this->payment->where(['track_id'=>$track_id , "amount"=>$amount])->first();
        if(!$payment) {
            return false;
        }
        $paymentStatus=$this->knetService->check($track_id,$amount);
        $paymentStatus = json_decode(json_encode($paymentStatus), true);
         // Check if the request was successful
         if ($paymentStatus['status'] == 1) {
            // Process the payment status as needed
            return view('knet::status', ['status' => $paymentStatus['data']]);
        } else {
            // Handle the error
            return view('knet::status', ['status' => 'Failed to retrieve payment status.']);
        }



        // $termResourceKey = env('PAYMENT_RESOURCE_KEY');
        // if ($data['trandata'] != '') {
        //     $decryptedData = $this->decrypt($ResTranData, $termResourceKey);
        //     parse_str($decryptedData, $payData);
        // } else {
        //     $payData = $data;
        // }

        // Log::info('pay Data: ', $payData);
        // $this->create_log('payment', 'pay Data', 'payment', $payData['udf1'], 'client', $payData['udf2'], json_encode($payData));

        // if ($payData['result'] != 'CAPTURED') {
        //     Payment::where('id', $payData['udf1'])->update([
        //         'payment_id' => $payData['paymentid'], 'updated_at' => date('Y-m-d H:i:s'), 'pay' => -1
        //     ]);
        //     return ['success' => 0, 'data' => $payData];
        // } else {
        //     //            $payment_date = $payData['postdate'];
        //     //            $payment_date = date('Y').'-'.substr($payment_date, 0, 2).'-'.substr($payment_date, 2, 2) ?? date('Y-m-d');

        //     $result = [
        //         'id' => $payData['udf1'],
        //         'result' => $payData['result'],
        //         'track_id' => $payData['trackid'],
        //         'trans_id' => $payData['tranid'],
        //         'payment_id' => $payData['paymentid'],
        //         'auth' => $payData['auth'],
        //         'amount' => $payData['amt'],
        //         'postdate' => $payData['postdate'],
        //         'ref' => $payData['ref']
        //     ];

        //     //                dd($payData['udf5']);
        //     if ($payData['udf5'] !== null) {
        //         $instalment = Instalment::with('client')->find($payData['udf5']);
        //         if ($instalment) {
        //             $instalment->update(['is_paid' => 1]);
        //             // Push Notification to Admin
        //             $users = User::whereNotNull('email_verified_at')->get();
        //             foreach ($users as $user) {
        //                 $user->notify(new NewInstallment($instalment));
        //             }

        //             //                    if (isset($instalment->client)) {
        //             //                        $order['paymentData'] = $result;
        //             //                        $order['name'] = $instalment->client->name ?? '';
        //             //                        $order['subject'] = 'New Installment Request';
        //             //                        $order['date'] = date('Y-m-d H:i:s');
        //             //                        Mail::to($instalment->client->email)->send(new newInstallmentReceipt($order));
        //             //                    }

        //         }
        //     }


        //     $pay = Payment::where('id', $result['id'])->update([
        //         'payment_id' => $result['payment_id'],
        //         'updated_at' => date('Y-m-d H:i:s'),
        //         'pay' => 1,
        //         'post_date' => $payData['postdate'],
        //         'tran_id' => $result['trans_id'],
        //         'auth' => $result['auth'],
        //         'ref' => $result['ref'],
        //     ]);
        //     Log::info('update Payment in system Easybuy after paid');
        //     $this->create_log('payment', 'update Payment in system Easybuy after paid', 'payment', $result['id'], 'client', $payData['udf2'], Null);


        //     try {
        //         //                $payment = Payment::where('id', $result['id'])->first();
        //         //    (new Controller())->updatePaymentOracle($payment, $payData);
        //     } catch (\Exception $e) {
        //         Log::info($e);
        //     }

        //     return ['success' => 1, 'data' => $result];
        // }
    }



    // Add other methods as needed
}
