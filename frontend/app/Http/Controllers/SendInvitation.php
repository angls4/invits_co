<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use App\Http\Traits\WablasTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SendInvitation extends Controller
{
    public function sendInvitation(Request $request, string $id) {
        $status = 400;
        $ids = $request->selectedIDs;
        
        if (!$ids){
            return response()->json(['ids' => $request->selectedIDs, 'method' => $request->selectedMethod], $status);
        }
        $method = $request->selectedMethod;
        
        $invitation = Http::withToken(session('api_token'))->get(env('API_URL').'invitations/'.decode_id($id))->object()->data->invitation;
        $success_sent = [];
        
        if ($method == 'email') {
            foreach ($ids as $id) {
                try {
                    $guest = Http::withToken(session('api_token'))->get(env('API_URL').'guests/'.$id)->object()->data->guest;
                    
                    $data = [
                        "invitation" => $invitation,
                        "wedding" => $invitation->wedding,
                        "guest" => $guest,
                    ];
                    Mail::to($guest->email)->send(new InvitationMail($data));
                } catch (\Throwable $th) {
                    return response()->json(['output' => $data], $status);
                }
            }
        } elseif ($method == 'wa') {
            foreach ($ids as $id) {
                try {
                    $guest = Http::withToken(session('api_token'))->get(env('API_URL').'guests/'.$id)->object()->data->guest;
                    
                    $kumpulan_data = [];
                    $data['phone'] = $guest->no_whats_app;
                    $data['message'] = WablasTrait::invitationMessage($invitation, $guest);
                    $data['secret'] = false;
                    $data['retry'] = false;
                    $data['isGroup'] = false;
                    array_push($kumpulan_data, $data);
                    
                    WablasTrait::sendText($kumpulan_data);
                } catch (\Throwable $th) {
                    return response()->json(['output' => $data], $status);
                }
            }
        }
        $guest = Http::withToken(session('api_token'))->put(env('API_URL').'guests/'.$id, ["is_invited" => true]);
        $status = 200;

        return response()->json(['ids' => $request->selectedIDs, 'method' => $request->selectedMethod], $status);
    }
}
