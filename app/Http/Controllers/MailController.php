<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\User;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;

/**
 * @property User user
 */
class MailController extends Controller
{
    public function __construct(User $user){
        $this->user = $user;
    }

    public function send(Request $request){
        echo $message = $request->input('message');
        $data = [
            'nameTo'    => $this->user->where('email', $request->input('to'))->first()->name,
            'nameFrom'  => $this->user->where('email', $request->input('from'))->first()->name,
            'emailTo'   => $request->input('to'),
            'emailFrom' => $request->input('from'),
            'subject'   => $request->input('subject'),
            'msg'       => $message
        ];

        try {
            $sent = Mail::send('mails.template', $data, function($msg)use($data){
                $msg->to($data['emailTo'], $data['nameTo'])->subject($data['subject']);
                $msg->from('ojttracker@gmail.com', 'BulSU OMS - Mailing System');
            });
            if($sent){
                return redirect()->back();
            }else{
                return 'naku naman';
            }
        }catch (Exception $e) {
            session()->flash('cantSendEmail', "<script>alert('Failed to send email. Please check your network connection.');</script>");
            return redirect()->back();

        }
    }
}