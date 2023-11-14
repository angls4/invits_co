<?php

namespace App\Http\Traits;


trait WablasTrait
{
    public static function sendText($data = [])
    {
        $curl = curl_init();
        $token = env('SECURITY_TOKEN_WABLAS');
        $payload = [
            "data" => $data
        ];
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL,  env('DOMAIN_SERVER_WABLAS') . "/api/v2/send-message");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);
        curl_close($curl);
    }

    public static function sendTemplate()
    {
        $curl = curl_init();
        $token = env('SECURITY_TOKEN_WABLAS');
        $payload = [
            "data" => [
                [
                    'phone' => '6281218xxxxxx',
                    'message' => [
                        'buttons' => ["button 1","button 2","button 3"],
                        'content' => 'sending template message...',
                        'footer' => 'footer template here',
                    ],
                ]
            ]
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
        curl_setopt($curl, CURLOPT_URL,  "https://solo.wablas.com/api/v2/send-button");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        
        $result = curl_exec($curl);
        curl_close($curl);
        echo "<pre>";
        print_r($result);
    }
    
    public static function invitationMessage($invitation, $guest)
    {
        $wedding = $invitation->wedding;
        $event = $invitation->wedding->event[0];
        $groom = $invitation->wedding->groom;
        $bride = $invitation->wedding->bride;
        $link = config('app.url') . '/' . $invitation->slug;
        $date = HelperTrait::dateID($event->date);

        $message = "
        Yth. Saudara/Saudari $guest->name
        
        Kami yang berbahagia $groom->name dan $bride->name, mengundang Saudara/Saudari untuk hadir di pemberkatan nikah kami, pada:
        
        Hari dan Tanggal\t:	$date
        Pukul\t\t:	$event->start_time
        Lokasi\t\t:	$wedding->location
        Link Undangan\t:	$link
        
        Akan menjadi suatu kehormatan apabila Saudara/Saudari berkenan hadir di acara kami.
        
        Salam Hormat,
        Keluarga $groom->name dan keluarga $bride->name";

        return $message;
    }

}