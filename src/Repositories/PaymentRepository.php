<?php 
namespace Mostafax\Knet\Repositories;

use Mostafax\Knet\Models\Payment;

class PaymentRepository
{
    protected $model;

    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    public function updatePayment($trackId, $data)
    {
        return $this->model->where('track_id', $trackId)->update($data);
    }

    public function createPayment($data)
    {
        return $this->model->create($data);
    }
}
