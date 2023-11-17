<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// Models
use App\Models\Guest;
use App\Models\Invitation;

class GuestController extends Controller
{
    public function index()
    {
        try {
            $guests = Guest::all();

            $data = [
                'guests' => $guests,
            ];

            return $this->jsonResponse($data, 'Guests retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve guests', [$e->getMessage()], false, 500);
        }
    }

    public function show($id)
    {
        try {
            $guest = Guest::find($id);

            if (!$guest) {
                return $this->jsonResponse(null, 'Guest not found', [], false, 404);
            }

            $data = [
                'guest' => $guest,
            ];

            return $this->jsonResponse($data, 'Guest retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve the guest', [$e->getMessage()], false, 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'nullable',
            'address' => 'nullable',
            'is_invited' => 'required|boolean',
            'no_whats_app' => 'nullable',
            'email' => 'nullable|email',
            'invitation_id' => 'required|exists:invitations,id',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $guest = Guest::create($request->all());

            $data = [
                'guest' => $guest,
            ];

            return $this->jsonResponse($data, 'Guest created successfully', [], true, 201);
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to create the guest', [$e->getMessage()], false, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $guest = Guest::find($id);

        if (!$guest) {
            return $this->jsonResponse(null, 'Guest not found', [], false, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'nullable',
            'description' => 'nullable',
            'address' => 'nullable',
            'no_whats_app' => 'nullable',
            'email' => 'nullable|email',
            'invitation_id' => 'required|exists:invitations,id',
        ]);

        if ($validator->fails()) {
            return $this->jsonResponse(null, 'Validation error', $validator->errors(), false, 422);
        }

        try {
            $guest->update($request->all());

            $data = [
                'guest' => $guest,
            ];

            return $this->jsonResponse($data, 'Guest updated successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to update the guest', [$e->getMessage()], false, 500);
        }
    }

    public function destroy($id)
    {
        $guest = Guest::find($id);

        if (!$guest) {
            return $this->jsonResponse(null, 'Guest not found', [], false, 404);
        }

        try {
            $guest->delete();
            return $this->jsonResponse(null, 'Guest deleted successfully');
        }
        catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to delete the guest', [$e->getMessage()], false, 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Guest - Invitation
    |--------------------------------------------------------------------------
    */
    public function get_by_invitation_id(Request $request, $invitation_id)
    {
        try {
            $invitation = Invitation::where('id', $invitation_id)->first();
            
            if (!$invitation) {
                return $this->jsonResponse(null, 'Error not found', ['invitation_id' => 'invitation_id not found'], false, 404);
            }

            if ($request->query('key')) {
                $key = $request->query('key');

                $guests = Guest::where('invitation_id', $invitation_id)
                    ->where('name', 'LIKE', '%' . $key . '%')
                    ->orWhere('email', 'LIKE','%'. $key .'%')
                    ->orWhere('no_whats_app', 'LIKE','%'. $key .'%')
                    ->get();
            } else {
                $guests = Guest::where('invitation_id', $invitation_id)->get();
            }

            $data = [
                "invitation" => $invitation,
                "guests" => $guests,
                // Jika Anda ingin menyertakan informasi lain, tambahkan di sini.
            ];

            return $this->jsonResponse($data, 'Guests by invitation id retrieved successfully');
        } catch (\Exception $e) {
            return $this->jsonResponse(null, 'Failed to retrieve guests by invitation id', [$e->getMessage()], false, 500);
        }
    }

}
