<?php

namespace App\Http\Controllers;

use App\Traits\SentEmailTrait;
use Illuminate\Http\Request;

class testEmailController extends Controller
{
    use SentEmailTrait;
    public function index(){
        return view('test-email.index');
    }

    public function send(Request $request){
        $receiver = $request->receiver;
        $subject = $request->subject;
        $content = $request->content;

        $this->emailNotif($receiver,$subject,$content);

        if($code = '403'){
            dd('Forbidden');
        }
        else if ($code = '200'){
            dd('sukses email');
        }
        else if($code = '401'){
            dd('gak punya akses');
        }
    }
}
