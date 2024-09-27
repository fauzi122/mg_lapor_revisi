<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;

trait SentEmailTrait
{
    public function emailNotif($receiver,$subject,$content){
        //dd('Oji');
        $url = "https://apicdev.esdm.go.id/development/dev-sandbox/api/v1/mail/send";
        $uname = "pelaporan-migas";
        $password = "";
        $auth = 'Basic ZGplX2xoZTpMaDNfM2JUa0U=';
        $request = Http::withBasicAuth($uname,$password)->post($url,[
            'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $auth
                ],
            'body' =>json_encode([
                    'receiver' => $receiver,
                    'subject' => $subject,
                    'content' => $content
                ])
        ]);

        $jsonResponse = $request->json();
        $code = $jsonResponse['code'];
        return $code;
        //dd($jsonResponse['code']);
    }
}
