<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// Models
use App\Models\Guest;
use App\Models\Order;
use App\Models\Wedding;

class WeddingController extends Controller
{
    public function index()
    {
        try {
            $weddings = Wedding::all();

            $data = [
                'weddings' => $weddings,
            ];

            return $this->jsonResponse($data, 'Weddings retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve weddings', [$e->getMessage()], false, 500);
        }
    }

    public function get_by_order_id($order_id)
    {
        try {
            $order = Order::with('invitation.wedding')->find($order_id);
            
            if (!$order) {
                return $this->jsonResponse(null, 'Order not found', [], false, 404);
            }

            $guests = Guest::where('invitation_id', $order->invitation->id)->orderBy('id', 'desc')->limit(10)->get();
            $guests_count = Guest::where('invitation_id', $order->invitation->id)->count();


            $data = [
                'order' => $order,
                'guests' => $guests,
                'guests_count' => $guests_count,
            ];

            return $this->jsonResponse($data, 'Wedding retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve the wedding', [$e->getMessage()], false, 500);
        }
    }

    public function show($id)
    {
        try {
            $wedding = Wedding::find($id);

            if (!$wedding) {
                return $this->jsonResponse(null, 'Wedding not found', [], false, 404);
            }

            $data = [
                'wedding' => $wedding,
            ];

            return $this->jsonResponse($data, 'Wedding retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve the wedding', [$e->getMessage()], false, 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable',
            'location' => 'nullable',
            'location_gmap' => 'nullable',
            'rekening_gift' => 'nullable',
            'invitation_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $wedding = Wedding::create($request->all());

            $data = [
                'wedding' => $wedding,
            ];

            return $this->jsonResponse($data, 'Wedding created successfully', [], true, 201);
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to create the wedding', [$e->getMessage()], false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $wedding = Wedding::find($id);

        if (!$wedding) {
            return $this->jsonResponse(null, 'Wedding not found', [], false, 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'nullable',
            'location' => 'nullable',
            'location_gmap' => 'nullable',
            'rekening_gift' => 'nullable',
            'invitation_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $wedding->update($request->all());

            $data = [
                'wedding' => $wedding,
            ];

            return $this->jsonResponse($data, 'Wedding updated successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to update the wedding', [$e->getMessage()], false, 500);
        }
    }

    public function destroy($id)
    {
        $wedding = Wedding::find($id);

        if (!$wedding) {
            return $this->jsonResponse(null, 'Wedding not found', [], false, 404);
        }

        try {
            $wedding->delete();
            return $this->jsonResponse(null, 'Wedding deleted successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to delete the wedding', [$e->getMessage()], false, 500);
        }
    }
}
