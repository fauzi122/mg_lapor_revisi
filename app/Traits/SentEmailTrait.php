<?php

namespace App\Traits;

use App\Models\EmailMaster;
use Illuminate\Support\Facades\Http;

trait SentEmailTrait
{
    // public function emailNotif($receiver,$subject,$content){
    public function emailNotif($receiver,$event){
        $email = EmailMaster::where('event', $event)->firstOrFail();
        
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
            'subject' => $email->subject,
            'content' => $email->content
        ]);

        $jsonResponse = $request->json();
        // Penambahan Null Hanya Percobaan karena harus memakai API sendEmail, Code sebelumnya $code = $jsonResponse['code']
        $code = $jsonResponse['code'] ?? null;
        return $code;
        //dd($jsonResponse['code']);
    }
}
