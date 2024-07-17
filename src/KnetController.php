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


    public function initPayment(array $data)
    {
        // Handle init payment logic
    }

    public function pay(array $data)
    {
        // Handle pay logic
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

    public function checkPayment(array $data): array
    {
        // Handle check payment logic
    }

    public function check($track_id, $pay_id, $amount = null)
    {
        // Handle check logic
    }

    // Add other methods as needed
}
