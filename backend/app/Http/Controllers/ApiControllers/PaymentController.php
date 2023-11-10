<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;

class PaymentController extends Controller
{
    public function total()
    {
        try {
            $total_payments = Order::join('payments', 'orders.id', '=', 'payments.order_id')
                                ->sum('payments.total_price');
 
            $data = [
                'total_payments' => $total_payments,
            ];

            return $this->jsonResponse($data, 'Total payments retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve total paymenets', [$e->getMessage()], false, 500);
        }
    }

    public function total_paid()
    {
        try {
            $total_payments_paid = Order::where('status', 'PAID')
                                    ->join('payments', 'orders.id', '=', 'payments.order_id')
                                    ->sum('payments.total_price');

            $data = [
                'total_payments_paid' => $total_payments_paid,
            ];

            return $this->jsonResponse($data, 'Total paid payments retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve total payments paid', [$e->getMessage()], false, 500);
        }
    }

    public function total_unpaid()
    {
        try {
            $total_payments_unpaid = Order::where('status', 'UNPAID')
                                        ->join('payments', 'orders.id', '=', 'payments.order_id')
                                        ->sum('payments.total_price');

            $data = [
                'total_payments_unpaid' => $total_payments_unpaid,
            ];

            return $this->jsonResponse($data, 'Total unpaid payments retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve total payments unpaid', [$e->getMessage()], false, 500);
        }
    }
}