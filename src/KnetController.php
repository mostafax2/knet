<?php

namespace Mostafax\Knet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mostafax\Knet\Knet;
use Mostafax\Knet\Models\Payment;

class KnetController extends Controller
{

    public function index()
    {
        echo "good";
    }
    public function success(Request $request)
    {
        $Knet = new Knet();
        $data = $Knet->handleError($request->all());
        Payment::where('track_id',$data['trackid'])->update([ 
            'payment_id'=>$data['paymentid'],  
            'tran_id'=>$data['tranid'],
            'ref_id'=>$data['ref'],
            'status'=>1,
            'result'=>$data['result'],
            'udf1'=>$data['udf1'],
            'udf2'=>$data['udf2'],
            'udf3'=>$data['udf3'],
            'udf4'=>$data['udf4'],
            'udf5'=>$data['udf5'],
        ]);
          
        return view('knet::success', compact('data'));
    }

    public function error(Request $request)
    {
        $Knet = new Knet();
       return $data = $Knet->handleError($request->all());
        Payment::where('track_id',$data['trackid'])->update([ 
            'payment_id'=>$data['paymentid'],  
            'tran_id'=>$data['tranid'],
            'ref_id'=>$data['ref'],
            'status'=>2,
            'result'=>$data['result'],
            'udf1'=>$data['udf1'],
            'udf2'=>$data['udf2'],
            'udf3'=>$data['udf3'],
            'udf4'=>$data['udf4'],
            'udf5'=>$data['udf5'],
        ]);
        return view('knet::error', compact('data'));
    }


    public function init($data)
    {
        // $data = [
        //     'amount' => 20,
        //     'track_id' => rand(0, 9999),
        //     'udf1' => null,
        //     'udf2' => null,
        //     'udf3' => null,
        //     'udf4' => null,
        //     'udf5' => null
        // ];
        $Knet = new Knet();
        Payment::create($data);
        return $Knet->pay($data);
    }
}
