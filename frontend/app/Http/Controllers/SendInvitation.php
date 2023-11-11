<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SendInvitation extends Controller
{
    public function sendInvitation(Request $request, string $id) {
        $status = 200;
        $ids = $request->selectedIDs;
        
        if (!$ids) $ids = [];
        $method = $request->selectedMethod;
        
        $invitation = Http::withToken(session('api_token'))->get(env('API_URL').'invitations/'.decode_id($id))->object()->data->invitation;
        $success_sent = [];
        
        foreach ($ids as $id) {
            $guest = Http::withToken(session('api_token'))->get(env('API_URL').'guests/'.$id)->object()->data->guest;
            
            $data = [
                "invitation" => $invitation,
                "wedding" => $invitation->wedding,
                "guest" => $guest,
            ];

            try {
                Mail::to($guest->email)->send(new InvitationMail($data));
            } catch (\Throwable $th) {
                return response()->json(['output' => $data], $status);
            }
            
            $guest = Http::withToken(session('api_token'))->put(env('API_URL').'guests/'.$id, ["is_invited" => true]);
        }
        $status = 200;

        if (count($ids) == 0) $status = 400;

        return response()->json(['ids' => $request->selectedIDs, 'method' => $request->selectedMethod], $status);
    }
}
