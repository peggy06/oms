<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\SetupRequest;
use App\Log;
use App\Permission;
use App\Profile;
use App\Section;
use App\Signature;
use App\User;
use App\Verification;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    public function __construct(User $user, Permission $permission, Signature $signature, Verification $verification, Log $log, Profile $profile, Course $course, Section $section){
        $this->user = $user;
        $this->permission = $permission;
        $this->signature = $signature;
        $this->verification = $verification;
        $this->log = $log;
        $this->profile = $profile;
        $this->course = $course;
        $this->section = $section;

        session_start();
    }

    public function index(){
        if(auth()->guest()){
            $page_title = 'Welcome to BulSU - OMS';
            return view('frontend.index', compact('page_title'));
        }else{
            if(auth()->user()->role == 4)
                return redirect()->route('adviserDashboard');
            elseif (auth()->user()->role == 5) 
                return redirect()->route('studentDashboard');
            else
                return view('frontend.index');
        }
    }

    public function register(RegistrationRequest $request){
         //test if signature exist and catch exception if not
            try {
                $signature_exist = $this->signature->where('signature', strtoupper($request->input('signature')))->first();
                $adviser_attr = $this->user->find($signature_exist->user_id);
                //check signatures availability
                if ($signature_exist){
                    //set new user data

                    //set avatar
                    $user = [
                        'firstname' => ucfirst($request->input('firstname')),
                        'lastname'  => ucfirst($request->input('lastname')),
                        'name'      => ucwords($request->input('firstname')." ".$request->input('lastname')),
                        'email'     => $request->input('email'),
                        'role'      => $signature_exist->role,
                        'under_to'  => $signature_exist->user_id
                    ];

                    //set email verification data
                    $verification_code = Str::random(36);
                    $data = [
                        'firstname' => $request->input('firstname'),
                        'lastname'  => $request->input('lastname'),
                        'email'     => $request->input('email'),
                        'code'      => encrypt($verification_code),
                    ];

                    //try to send email, catch exception and return error message if can't
                    try {
                 // TODO: Remove comment tags on email feature
                       $sent = Mail::send('mails.confirmationMail', $data, function($msg)use($data){
                           $msg->to($data['email'], $data['firstname'].' '.$data['lastname'])->subject('Welcome to OJT Monitoring');
                           $msg->from('ojttracker@gmail.com', 'OJT Monitoring BOTS');
                       });

                        // $sent = true; //temporary: email sending features need internet connection

                        //if email sent , create incomplete or temporary user
                        if ($sent){
                            try {
                                $new_user = $this->user->create($user);

                                if ($new_user){

                                    //set avatar
                                    if($new_user->role == 4){
                                        if($request->input('gender') == 'male'){
                                            $avatar = "/images/avatar_male_adviser.png";
                                        }else{
                                            $avatar = "/images/avatar_female_adviser.png";
                                        }
                                    }elseif($new_user->role == 5){
                                        if($request->input('gender') == 'male'){
                                            $avatar = "/images/avatar_male_student.png";
                                        }else{
                                            $avatar = "/images/avatar_female_student.png";
                                        }
                                    }

                                    //create profile for new user
                                    $new_user->profile()->create([
                                        'user_id'   => $new_user->id,
                                        'gender'    => $request->input('gender'),
                                        'contact'   => $request->input('contact'),
                                        'avatar'    => $avatar,
                                        'bday'      => $request->input('bday'),
                                        'course'    => $adviser_attr->profile->course,
                                        'section'    => $adviser_attr->profile->section,
                                    ]);

                                    if($new_user->role == 4){
                                        //create digital signature
                                        $new_user->signatures()->create([
                                            'signature' => strtoupper(Str::random(12)),
                                            'role'      => '5'
                                        ]);
                                    }

                                    //try to store verification code to db
                                    try {
                                        $new_user->verification()->create(['code' => $verification_code,]);
                                    }catch (Exception $e){
                                        session()->flash('reg-failed', "Cant process your request. <br>".$e->getMessage());
                                        return redirect()->back();
                                    }
                                    if($new_user->role == 4){

                                        //send request
                                        try{
                                            $new_user->permissions()->create([
                                                'request'   => "Wants to be an OJT Adviser under your supervision.",
                                                'to'        => $signature_exist->user_id,
                                                'new'       => 1
                                            ]);
                                        }catch (Exception $e){
                                            session()->flash('reg-failed', "cant send request");
                                            return redirect()->back();
                                        }
                                    }else{
                                        //send request
                                        try{

                                            $new_user->permissions()->create([
                                                'request'   => "Wants to be an OJT Student under your supervision.",
                                                'to'        => $signature_exist->user_id,
                                                'new'       => 1
                                            ]);
                                        }catch (Exception $e){
                                            session()->flash('reg-failed', "cant send request");
                                            return redirect()->back();
                                        }
                                    }
                                }else {
                                    //failed: create new user
                                    session()->flash('reg-failed', "Cant process your request.");
                                    return redirect()->back();
                                }
                            }catch (Exception $e) {
                                session()->flash('reg-failed', "Cant create account. <br> DUPLICATE ENTRY!");
                                return redirect()->back();
                            }
                        }else {
                            //failed: send email
                            session()->flash('reg-failed', "Cant send email.");
                            return redirect()->back();
                        }
                    }catch (Exception $e) {
                        //failed: email exceptions
                        session()->flash('reg-failed', "Cant send email. <br>".$e->getMessage());
                        return redirect()->back();
                    }
                    
                    $enc = encrypt($verification_code);
                    return redirect()->route('userDone');
                }else {
                    //failed: signature not available
                    session()->flash('reg-failed', "Signature doesn't exist or has been used by other user.");
                    return redirect()->back();
                }
            }catch (Exception $e) {
                session()->flash('reg-failed', "Cant process request. <br>".$e->getMessage());
                return redirect()->back();
            }
    }

    public function done(){
        if(!auth()->guest()){
            if(auth()->user()->role == 4){
                return redirect()->route('adviserDashboard');
            }
        }else{
            return view('frontend.done');
        }
    }

    public function confirmation($code){
        if(!auth()->guest()){
            if(auth()->user()->role == 4){
                return redirect()->route('adviserDashboard');
            }
        }else {
            $code = decrypt($code); //decrypt link code

            try {
                $validate_link = $this->verification->where(['code' => $code, 'used' => 0])->first();
            } catch (Exception $e) {
                return view('errors.already_confirmed');
            }

            if ($validate_link) {
                $section = $this->section->all();
                $user = $this->user->where('id', $validate_link->user_id)->first();
                return view('frontend.confirmation', compact('user', 'section'));
            } else {
                return view('errors.already_confirmed');
            }
        }
    }

    public function setup(SetupRequest $request, $id){
        if($request->input('password') == $request->input('confirm')){
            $credentials = [
                'password' => bcrypt($request->input('password')),
                'confirmed' => '1'
            ];

            try {
                $new_user = $this->user->find($id);
                $new_user->update($credentials);
                if($new_user){
                    $validity = ['used' => '1'];

                    try{
                        $class = null;

                        if ($new_user->role == 4){
                            $new_user->profile()->update(['course' => $request->input('department'), 'section' => $request->input('section')]);
                            $class = "OJT Adviser";
                        }elseif ($new_user->role == 5) {
                            $new_user->profile()->update(['course' => $this->user->find($new_user->under_to)->profile->course]);
                            $class = "OJT Student";
                        }else {
                            $class = "UNKNOWN";
                        }

                        $new_user->verification()->update($validity);

                        try {
                            $new_user->logs()->create([
                                'activity'  => "Register as ".$class,
                                'role'      =>  $new_user->role
                            ]);
                        }catch (Exception $e) {
                            session()->flash('failed', "Can't record activity");
                            return redirect()->back();
                        }

                    }catch (Exception $e) {
                        session()->flash('failed', "Some Problem occur: ".$e->getMessage());
                        return redirect()->back();
                    }



                    return redirect()->route('userConfirmed');
                }
            }catch (Exception $e) {
                session()->flash('failed', "Failed to setup password <br> BOTS says: ".$e->getMessage());
                return redirect()->back();
            }
        }else{
            session()->flash('failed', "Password did not match");
            return redirect()->back();
        }
    }

    public function confirmed(){
        if(!auth()->guest()){
            if(auth()->user()->role == 4){
                return redirect()->route('adviserDashboard');
            }else{
                return redirect()->route('studentDashboard');
            }
        }else {
            return view('frontend.confirm');
        }
    }

    public function login(LoginRequest $request){
        $login_credentials = ['email' => $request->input('email'), 'password' => $request->input('password')];

        if(auth()->attempt($login_credentials)){
            if (auth()->user()->role != 1){
                auth()->user()->update(['isOnline' => 1]);
                auth()->user()->logs()->create(['activity' => 'Login', 'role' => auth()->user()->role]);
                if(auth()->user()->role == 4){
                    return redirect()->route('adviserDashboard');
                }else{
                    return redirect()->route('studentDashboard');
                }
            }else {
                auth()->logout();
                session()->flash('failed', 'Email/Password did not match.');
                return redirect()->back();
            }
        }else {
                session()->flash('failed', 'Email/Password did not match.');
                return redirect()->back();
        }
    }

    public function forgot(){
        return view('frontend.forgot_password');
    }

    public function recover(ForgotPasswordRequest $request){
        $email_check = $this->user->where('email', $request->input('email'))->count();

        if($email_check != 0){
            //set email verification data
            $verification_code = Str::random(36);
            $data = [
                'email'     => $request->input('email'),
                'code'      => encrypt($verification_code),
            ];

            //try to send email, catch exception and return error message if can't
            try {
//                TODO: Remove comment tags on email feature
                $sent = Mail::send('mails.forgot', $data, function($msg)use($data){
                    $msg->to($data['email'], 'Unknown')->subject('Recover Account');
                    $msg->from('ojttracker@gmail.com', 'BulSU OMS Recovery System');
                });
            }catch (Exception $e){
                return $e;
            }

            return redirect()->route('recovery');
        }else{
            session()->flash('noUser', "There's no user with email ".$request->input('email'));
            return redirect()->back();
        }
    }

    public function recovery(){
        return view('frontend.recovery');
    }
}
