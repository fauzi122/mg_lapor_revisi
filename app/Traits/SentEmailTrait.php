<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;

trait SentEmailTrait
{
    public function emailNotif($receiver,$subject,$content){
        dd($receiver,$subject,$content);
        $url = "https://apicdev.esdm.go.id/development/dev-sandbox/api/v1/mail/send";
        $uname = "pelaporan-migas";
        $password = "f9q9b5YbQafj";
        $auth = 'Basic ZGplX2xoZTpMaDNfM2JUa0U=';
        $request = Http::withBasicAuth($uname,$password)
        ->withOptions([
            'verify' => false,
            'allow_redirects' => true
        ])
        ->post($url,[
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
        dd($jsonResponse);   
        $code = $jsonResponse['code'];
        return $code;
        //dd($jsonResponse['code']);
    }
}
