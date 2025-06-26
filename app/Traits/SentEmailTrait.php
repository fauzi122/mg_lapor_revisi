<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;

trait SentEmailTrait
{
    public function emailNotif($receiver,$subject,$content){
        $url = "https://apicdev.esdm.go.id/development/dev-sandbox/api/v1/mail/send";
        $uname = "pelaporan-migas";
        $password = "f9q9b5YbQafj";
        $auth = 'Basic ZGplX2xoZTpMaDNfM2JUa0U=';
        $request = Http::withBasicAuth($uname,$password)
        ->withOptions([
            'verify' => false,
            'allow_redirects' => true
        ])
        ->withHeaders([
            'Authorization' => $auth,
            'Content-Type' => 'application/json'
        ])
        ->post($url, [
            'receiver' => $receiver,
            'subject' => $subject,
            'content' => $content
        ]);

        $jsonResponse = $request->json();
        $code = $jsonResponse['code'];
        return $code;
        //dd($jsonResponse['code']);
    }
}
