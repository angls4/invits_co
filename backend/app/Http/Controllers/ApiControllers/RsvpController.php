<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use DB;
use Illuminate\Http\Request;
use App\Models\Rsvp;
use Illuminate\Support\Facades\Validator;

class RsvpController extends Controller
{
    public function index()
    {
        try {
            $rsvps = Rsvp::all();

            $data = [
                'rsvps' => $rsvps,
            ];

            return $this->jsonResponse($data, 'Rsvps retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve rsvps', [$e->getMessage()], false, 500);
        }
    }

    public function show($id)
    {
        try {
            $rsvp = Rsvp::find($id);

            if (!$rsvp) {
                return $this->jsonResponse(null, 'Rsvp not found', [], false, 404);
            }

            $data = [
                'rsvp' => $rsvp,
            ];

            return $this->jsonResponse($data, 'Rsvp retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve the rsvp', [$e->getMessage()], false, 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'invitation_id' => 'required|exists:invitations,id',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $is_attend = $request->is_attend == "true";
            $amount_guest = $request->amount_guest ? $request->amount_guest : ($is_attend ? 1 : 0);

            $rsvp = [
                "invitation_id" => $request->invitation_id,
                "name" => $request->name,
                "amount_guest" => $amount_guest,
                "is_attend" => $is_attend,
                "guest_id" => $request->guest_id ?? null
            ];

            DB::beginTransaction();
            
            // Create RSVP
            $rsvp = Rsvp::create($rsvp);
            
            DB::commit();

            $data = [
                'rsvp' => $rsvp,
            ];

            return $this->jsonResponse($data, 'Rsvp created successfully', [], true, 201);
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to create the rsvp', [$e->getMessage()], false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $rsvp = Rsvp::find($id);

        if (!$rsvp) {
            return $this->jsonResponse(null, 'Rsvp not found', [], false, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'amount_guest' => 'required|integer',
            'is_attend' => 'required|boolean',
            'invitation_id' => 'required|exists:invitations,id',
            'guest_id' => 'nullable|exists:guests,id',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $rsvp->update($request->all());

            $data = [
                'rsvp' => $rsvp,
            ];

            return $this->jsonResponse($data, 'Rsvp updated successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to update the rsvp', [$e->getMessage()], false, 500);
        }
    }

    public function destroy($id)
    {
        $rsvp = Rsvp::find($id);

        if (!$rsvp) {
            return $this->jsonResponse(null, 'Rsvp not found', [], false, 404);
        }

        try {
            $rsvp->delete();
            return $this->jsonResponse(null, 'Rsvp deleted successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to delete the rsvp', [$e->getMessage()], false, 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Rsvp - Invitation
    |--------------------------------------------------------------------------
    */
    public function get_by_invitation_id(Request $request, $invitation_id)
    {
        try {
            $invitation= Invitation::where('id', $invitation_id)->first();

            if (!$invitation) {
                return $this->jsonResponse(null, 'Invitation not found', [], false, 404);
            }

            if($request->query('key')) {
                $key = $request->query('key');
    
                $rsvps = Rsvp::where('invitation_id', $invitation_id)
                            ->where('name', 'LIKE','%'. $key .'%')
                            ->get();
            } else {
                $rsvps = Rsvp::where('invitation_id', $invitation_id)->get();
            };
    
            $data = [
                "invitation" => $invitation,
                "rsvps" => $rsvps,
                "package" => $invitation->order->package,
            ];

            return $this->jsonResponse($data, 'Rsvps by invitation id retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve rsvps by invitation id', [$e->getMessage()], false, 500);
        }
    }

}
