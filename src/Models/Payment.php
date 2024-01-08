<?php

namespace Mostafax\Knet\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'order_id',
        'payment_id',
        'track_id',
        'amount',
        'tran_id',
        'ref_id',
        'status',
        'result',
        'info',
        'udf1',
        'udf2',
        'udf3',
        'udf4',
        'udf5',
    ];
}
