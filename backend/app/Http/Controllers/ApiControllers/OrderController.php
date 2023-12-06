<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// Models
use App\Models\User;
use App\Models\Theme;
use App\Models\Order;
use App\Models\Invitation;
use App\Models\Payment;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::with('invitation', 'theme')->get();

            $data = [
                'orders' => $orders,
            ];

            return $this->jsonResponse($data, 'Orders retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve orders', [$e->getMessage()], false, 500);
        }
    }

    public function getByuserID($user_id)
    {
        try {
            $user = User::find($user_id);

            if (!$user) {
                return $this->jsonResponse(null, 'User not found', [], false, 404);
            }

            $orders = Order::where('user_id', $user_id)->with('invitation', 'theme')->get();

            $data = [
                'orders' => $orders,
            ];

            return $this->jsonResponse($data, 'Orders retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve orders', [$e->getMessage()], false, 500);
        }
    }

    public function show($id)
    {
        try {
            $order = Order::with('user', 'package', 'theme', 'invitation', 'payment')->find($id);

            if (!$order) {
                return $this->jsonResponse(null, 'Order not found', [], false, 404);
            }

            $data = [
                'order' => $order,
            ];

            return $this->jsonResponse($data, 'Order retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve the order', [$e->getMessage()], false, 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'theme_id' => 'required|exists:themes,id',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $user = User::find($request->user_id);
            $theme = Theme::find($request->theme_id);

            DB::beginTransaction();

            // Create Order
            $order = [
                "status" => "UNPAID",
                "user_id" => $request->user_id,
                "package_id" => $theme->package_id,
                "theme_id" => $theme->id,
            ];

            $order = Order::create($order);

            // Create Payment
            $payment = [
                "total_price" => $theme->price,
                "user_id" => $request->user_id,
                "order_id" => $order->id
            ];

            $payment = Payment::create($payment);

            $payment_midtrans = Payment::midtrans($user, $order, $payment);
            
            Invitation::initWeddingInvitation($order);

            DB::commit();

            $data = [
                "theme" => $theme,
                "payment_midtrans" => $payment_midtrans,
                "order" => $order
            ];

            return $this->jsonResponse($data, 'Order created successfully', [], true, 201);
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to create the order', [$e->getMessage()], false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->jsonResponse(null, 'Order not found', [], false, 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:PAID,UNPAID',
            'user_id' => 'required',
            'package_id' => 'required',
            'theme_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $order->update($request->all());

            $data = [
                'order' => $order,
            ];

            return $this->jsonResponse($data, 'Order updated successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to update the order', [$e->getMessage()], false, 500);
        }
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->jsonResponse(null, 'Order not found', [], false, 404);
        }

        try {
            $order->delete();
            return $this->jsonResponse(null, 'Order deleted successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to delete the order', [$e->getMessage()], false, 500);
        }
    }

    /**
     * Midtrans Callback
     *
     * @return 
     */
    public function makeOrderMidtransCallback(Request $request)
    {
        try {
            $server_key = config('midtrans.server_key');
            $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $server_key);
            if ($hashed == $request->signature_key) {
                if ($request->transaction_status == 'capture') {
                    $order = Order::find($request->order_id);
                    $order->update(['status' => 'PAID']);
                    $order->payment->update([
                        'type' => $request->payment_type,
                        'transaction_id' => $request->transaction_id,
                        'transaction_time' => $request->transaction_time,
                        'transaction_status' => $request->transaction_status,
                    ]);    
                }
            }
            else{
                return $this->jsonResponse(null, 'invalid key', [], false, 422);
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            return redirect()->back()->with("error", "failed");
        }
    }
}
