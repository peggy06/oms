<?php

namespace App\Http\Controllers;

use App\Http\Requests\SMSRequest;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class SmsController extends Controller
{
    public function __construct(User $user){
        $this->username = 'ojtmonitoring@gmail.com';
        $this->password = '123Password';
        $this->info = '1';
        $this->test = '0';
        $this->user = $user;
    }

    public function send(SMSRequest $request){
        $from = "BulSU OMS Bot";
        $number = $request->input('receiver');
        $message = $request->input('msg').' -Sender: '.auth()->user()->name.'(+63'.$this->user->find(auth()->user()->id)->profile->contact.')';
        $message = urlencode($message);

        $data = "uname=".$this->username."&pword=".$this->password."&message=".$message."&from=".$from."&selectednums=".$number."&info=".$this->info."&test=".$this->test;

        $ch = curl_init('http://www.txtlocal.com/sendsmspost.php');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        if(count($result) != 0){

        }
    }

}
