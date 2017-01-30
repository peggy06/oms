<?php
/**
 * Created by PhpStorm.
 * User: jimuelpalaca
 * Date: 11/9/2016
 * Time: 11:01 AM
 */

namespace App\Http\Controllers;


class sms
{
    protected $username;
    protected $password;
    protected $info;
    protected $test;

    public function __construct(){
        $this->username = 'ojtmonitoring@gmail.com';
        $this->password = '123Password';
        $this->info = '1';
        $this->test = '0';
    }

    public function send($receiver, $msg){
        $from = "BulSU OMS Bot";
        $number = $receiver;
        $message = $msg;
        $message = urlencode($message);

        $data = "uname=".$this->username."&pword=".$this->password."&message=".$message."&from=".$from."&selectednums=".$number."&info=".$this->info."&test=".$this->test;

        $ch = curl_init('http://www.txtlocal.com/sendsmspost.php');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}