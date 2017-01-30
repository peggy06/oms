<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Choice;
use App\Company;
use App\Course;
use App\Dtr;
use App\Hour;
use App\Http\Requests\CompanyChoiceRequest;
use App\Http\Requests\CompanyProfileRequest;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\TimeInRequest;
use App\Message;
use App\Notification;
use App\Period;
use App\Profile;
use App\Section;
use App\User;
use App\Form;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Jcf\Geocode\Geocode;

class StudentController extends Controller
{
    public function __construct(User $user, Notification $notification, Message $message, Choice $choice, Hour $hour, Company $company, Profile $profile, Course $course, Dtr $dtr, Period $period, Chat $chat, Section $section, Form $form){
        $this->user = $user;
        $this->notification = $notification;
        $this->message = $message;
        $this->choice = $choice;
        $this->hour = $hour;
        $this->company = $company;
        $this->profile = $profile;
        $this->course = $course;
        $this->dtr = $dtr;
        $this->period = $period;
        $this->chat = $chat;
        $this->messages = $message;
        $this->section = $section;
        $this->form = $form;
        session_start();
    }

    public function index(){
        $messages = $this->message;
        $notifications = $this->notification;
        $users = $this->user;
        if($this->choice->where('user_id', auth()->user()->id)->count() != 0){
            $choices = $this->choice->where('user_id', auth()->user()->id)->get();
        }else{
            $choices = $this->choice->where('user_id', auth()->user()->id);
        }
        $company = $this->company;
        $course =  $this->course->find($users->find(auth()->user()->id)->profile->course);
        $course_code = $course->code;
        if($course->section == 'bsit'){
            $progress = ($users->find(auth()->user()->id)->profile->number_of_hours_rendered / 60 /60) * 100 / $this->hour->find(1)->bsit;
        }else{
            $progress = ($users->find(auth()->user()->id)->profile->number_of_hours_rendered / 60 /60) * 100 / $this->hour->find(1)->bit;
        }
        $hours = $this->hour->find(1);
        $dtr = $this->dtr->where(['user_id' => auth()->user()->id])->get();
        $today_record = $this->dtr->where(['user_id' => auth()->user()->id, 'date' => Carbon::now()->format('Y-m-d')]);

        return view('frontend.users.students.dashboard', compact('messages', 'notifications', 'users', 'choices', 'company', 'course', 'progress', 'hours', 'dtr', 'today_record', 'course_code'));
    }

    public function swass($week){
        $users = $this->user;
        $hours = $this->hour->find(1);
        $course = $this->course->find(auth()->user()->profile->course);
        $section = $this->section->find(auth()->user()->profile->section);
        $company = $this->company->find($this->user->find(auth()->user()->id)->profile->company_id);
        $swass = $this->dtr->where(['user_id' => auth()->user()->id, 'week_no' => $week])->get();
        return view('frontend.users.students.forms.SWASS', compact('users', 'hours', 'company', 'course','section', 'swass', 'week'));
    }

    public function swassLetter($week_no){
        $messages = $this->message;
        $notifications = $this->notification;
        $users = $this->user;
        $user_profile = $this->user->find(auth()->user()->id)->profile;
        return view('frontend.users.students.letterHolder_swass', compact('company_choice', 'user_profile', 'messages', 'notifications', 'users', 'week_no'));
    }

    public function waiver(){
        if(!auth()->guest()){
            if(auth()->user()->confirmed == 1){
                $users = $this->user;
                $hours = $this->hour->find(1);
                $company = $this->company->find($this->user->find(auth()->user()->id)->profile->company_id);
                return view('frontend.users.students.forms.waiver', compact('users', 'hours', 'company'));
            }
        }
    }

    public function waiverLetter(){
        $messages = $this->message;
        $notifications = $this->notification;
        $users = $this->user;
        $user_profile = $this->user->find(auth()->user()->id)->profile;
        return view('frontend.users.students.letterHolder_waiver', compact('company_choice', 'user_profile', 'messages', 'notifications', 'users'));
    }


    public function personal(){
        if(!auth()->guest()){
            if(auth()->user()->confirmed == 1){
                $users = $this->user;
                $hours = $this->hour->find(1);
                $course = $this->course;
                $company = $this->company->find($this->user->find(auth()->user()->id)->profile->company_id);
                return view('frontend.users.students.forms.personal_info', compact('users', 'hours', 'company', 'course'));
            }
        }
    }

    public function personalLetter(){
        $messages = $this->message;
        $notifications = $this->notification;
        $users = $this->user;
        $user_profile = $this->user->find(auth()->user()->id)->profile;
        return view('frontend.users.students.letterHolder_personal', compact('company_choice', 'user_profile', 'messages', 'notifications', 'users'));
    }

    public function evaluation(){
        if(!auth()->guest()){
            if(auth()->user()->confirmed == 1){
                $users = $this->user;
                $hours = $this->hour->find(1);
                $course = $this->course;
                $company = $this->company->find($this->user->find(auth()->user()->id)->profile->company_id);
                $profile = $this->profile->find(auth()->user()->id);
                $hour = $this->hour->find(1);
                $period = $this->period->where(['user_id' => auth()->user()->id]);
                return view('frontend.users.students.forms.evaluation', compact('users', 'hour', 'company', 'course', 'profile', 'period'));
            }
        }
    }

    public function evaluationLetter(){
        $messages = $this->message;
        $notifications = $this->notification;
        $users = $this->user;
        $user_profile = $this->user->find(auth()->user()->id)->profile;
        return view('frontend.users.students.letterHolder_evaluation', compact('company_choice', 'user_profile', 'messages', 'notifications', 'users'));
    }


    public function recommendation($id){
        if(!auth()->guest()){
            if(auth()->user()->confirmed == 1){
                $messages = $this->message;
                $notifications = $this->notification;
                $users = $this->user;
                $user_profile = $this->user->find(auth()->user()->id)->profile;
                $company_choice = $this->choice->where(['user_id' => auth()->user()->id, 'id' => $id])->first();
                return view('frontend.users.students.letterHolder_recommendation', compact('company_choice', 'user_profile', 'messages', 'notifications', 'users'));
            }
        }
    }

    public function recommendationLetter($id){
        $users = $this->user;
        $company_choice = $this->choice->where(['user_id' => auth()->user()->id, 'id' => $id])->first();
        $hours = $this->hour->find(1);
        return view('frontend.users.students.forms.recommendation', compact('company_choice', 'users', 'hours'));
    }

    public function addCompany(CompanyChoiceRequest $request){
        if(strtolower($request->input('company_name')) == 'bulacan state university - sarmiento campus' or strtolower($request->input('company_name') == 'bulacan state university sarmiento campus')){
            try{
                if($this->choice->where(['user_id' => auth()->user()->id, 'name' => $request->input('company_name')])->count() == 0){
                    $this->choice->create([
                        'user_id'   => auth()->user()->id,
                        'name'      => 'Bulacan State University - Sarmiento Campus',
                        'address'   => 'Kaypian Road, City of San Jose Del Monte Bulacan',
                        'lat'       => 14.814173,
                        'lng'       => 121.057059
                    ]);
                    return redirect()->route('studentDashboard');
                }else{
                    return redirect()->route('studentDashboard');
                }
            }catch (Exception $e){
                return redirect()->route('studentDashboard');
            }
        }else{
            if($request->input('company_lat') != null and $request->input('company_lat') != null){
                try{
                    if($this->choice->where(['user_id' => auth()->user()->id, 'name' => $request->input('company_name')])->count() == 0){
                        $this->choice->create([
                            'user_id'   => auth()->user()->id,
                            'name'      => $request->input('company_name'),
                            'address'   => $request->input('company_address'),
                            'lat'       => $request->input('company_lat'),
                            'lng'       => $request->input('company_lng')
                        ]);
                        return redirect()->route('studentDashboard');
                    }else{
                        return redirect()->route('studentDashboard');
                    }
                }catch (Exception $e){
                    return redirect()->route('studentDashboard');
                }
            }else{
                $result = Geocode::make()->address($request->input('company_name').' in '.$request->input('company_address'));

                if($this->choice->where(['user_id' => auth()->user()->id, 'name' => $result->name()])->count() == 0){
                    $this->choice->create([
                        'user_id'   => auth()->user()->id,
                        'name'      => $result->name(),
                        'address'   => $result->formattedAddress(),
                        'lat'       => $result->latitude(),
                        'lng'       => $result->longitude()
                    ]);
                    return redirect()->route('studentDashboard');
                }else{
                    return redirect()->route('studentDashboard');
                }
            }
        }
    }

    public function setCompany($id){
        $chosen = $this->choice->find($id);

        if($this->company->where('name', $chosen->name)->count() == 0){
            $my_company = $this->company->create([
                'name'      => $chosen->name,
                'address'   => $chosen->address,
                'latitude'  => $chosen->lat,
                'longitude' => $chosen->lng
            ]);
        }else{
            $my_company = $this->company->where(['name' => $chosen->name])->first();
        }

        $this->profile->where(['user_id' => auth()->user()->id])->update(['company_id' => $my_company->id]);

        return redirect()->route('studentDashboard');
    }

    public function timeIn(Request $request){
        if(Carbon::now()->format('H:i:s') >= auth()->user()->profile->sched_on){
            if(!auth()->user()->period()->count()){
            auth()->user()->period()->create([
                'date_started'  => Carbon::now()->format('Y-m-d')
            ]);
            }

            auth()->user()->update(['onDuty' => 1]);

            if(auth()->user()->dtr()->where(['date' => Carbon::now()->format('Y-m-d')])->count() == 0){

                auth()->user()->dtr()->create([
                    'date'          => Carbon::now()->format('Y-m-d'),
                    'status'        => 1,
                    'week_no'       => Carbon::now()->diffInWeeks() + 1,
                    'company'       => $this->company->find(auth()->user()->profile->company_id)->name,
                    'updated_at'    => '0000-0-0 0:0:0'
                ]);

                session(['time-in' => 'in']);
                return redirect()->route('studentDashboard');
            }else{
                session()->flash('failed', 'You are only allowed to time in once per day');
                return redirect()->route('studentDashboard');
            }
        }else{
            session()->flash('far', 'Too early to time-in, based on your schedule');
            return redirect()->back();
        }
//        }
    }

    public function timeOut(Request $request, $receiver){
        if(Carbon::now()->format('H:i:s') < auth()->user()->profile->sched_off){
            $msg = $request->input('reason').'-from: '.auth()->user()->name.'(0'.$this->user->find(auth()->user()->id)->profile->contact.')';
            $_receiver = '63'.$receiver;
            $sms = new sms();
            $sms->send( $_receiver, $msg);
        }

        $current_day = auth()->user()->dtr()->where(['date' => Carbon::now()->format('Y-m-d')]);

        $current_day->update(['status' => 0]);

        $rendered = auth()->user()->profile->number_of_hours_rendered;
        auth()->user()->profile->update([
            'number_of_hours_rendered' => $rendered + $current_day->first()->created_at->diffInSeconds($current_day->first()->updated_at)
        ]);

        auth()->user()->update(['onDuty' => 0]);
        session()->forget('time-in');
        return redirect()->route('studentDashboard');
    }

    public function forms(){
        if(!auth()->guest()){
            $messages = $this->message;
            $notifications = $this->notification;
            $users = $this->user;
            if($this->period->where(['user_id' => auth()->user()->id])->count() != 0){
                $week_no = Carbon::now()->diffInWeeks($this->period->where(['user_id' => auth()->user()->id])->first()->created_at) + 1;
            }else{
                $week_no = 0;
            }
            $forms = $this->form->all();
            return view('frontend.users.students.forms', compact('messages', 'notifications', 'users', 'week_no', 'forms'));
        }else{
            return redirect()->route('index');
        }
    }

    public function logout(){
        auth()->logout();
        return redirect()->back();
    }

    public function inbox(){
        $page_title = 'Inbox';
        $users = $this->user;
        $notifications = $this->notification;
        $messages = $this->messages;
        return view('frontend.users.students.inbox', compact('page_title', 'users', 'sorted_permission', 'permissions', 'notifications', 'messages'));
    }

    public function clearNewMessages(){
        if($this->messages->where(['receiver' => auth()->user()->id, 'deleted' => 0, 'new' => 1])->count() != 0){
            $this->messages->where(['receiver' => auth()->user()->id, 'new' => 1])->update(['new' => 0]);
        }
        return redirect()->action('StudentController@inbox');
    }

    public function chat($id){
        $id = decrypt($id);

        if($this->messages->where(['receiver' => auth()->user()->id, 'sender' => $this->user->find($id)->id, 'seen' => 0])->count() != 0){
            $this->messages->where(['receiver' => auth()->user()->id, 'sender' => $this->user->find($id)->id, 'seen' => 0])->update(['seen' => 1]);
        }
        $member = $id.'&'.auth()->user()->id;
        $page_title = 'Inbox';
        $users = $this->user;
        $notifications = $this->notification;
        $messages = $this->messages;
        if($this->chat->where(['member' => $member])->count() != 0){
            $chat_id = $this->chat->where(['member' => $member])->first()->chat_id;
        }elseif($this->chat->where(['member' => strrev($member)])->count() != 0) {
            $chat_id = $this->chat->where(['member' => strrev($member)])->first()->chat_id;
        }else{
            $this->chat->create([
                'chat_id' => Str::random(6),
                'member'  => $member
            ]);
            $chat_id = $this->chat->where(['member' => $member])->first()->chat_id;
        }

        $chat = $this->messages->where(['chat_id' => $chat_id])->get();
        $sender = $id;
        return view('frontend.users.students.chatbox', compact('page_title', 'users', 'sorted_permission', 'permissions', 'notifications', 'messages', 'chat', 'id', 'sender', 'chat_id'));
    }

    public function send(MessageRequest $request, $id, $chat_id){
        $id = decrypt($id);
        $message_info = [
            'chat_id'  => $chat_id,
            'sender'    => auth()->user()->id,
            'receiver'  => $id,
            'message'   => $request->input('message'),
            'new'       => 1,
            'seen'      => 0,
            'deleted'   => 0
        ];

        try{
            $this->messages->create($message_info);

        }catch (Exception $e){
            session()->flash('failed', "cant send message");
            return redirect()->back();
        }


        return redirect()->back();
    }

    public function setCompanyProfile(CompanyProfileRequest $request){
        $tech_area = $request->input('tech_area');
        $comp_sup = $request->input('comp_sup');
        $comp_contact = $request->input('comp_contact');
        $timeIn = $request->sched_on;
        $timeOut = $request->sched_off;

        try{
            $this->user->find(auth()->user()->id)->profile->update([
                'technology_area' => $tech_area,
                'company_supervisor' => $comp_sup,
                'company_contact' => $comp_contact,
                'sched_on'  => $timeIn,
                'sched_off' => $timeOut
            ]);

            return redirect()->route('studentDashboard');
        }catch (Exception $e){
            session()->flash('failed', 'Cant update record '.$e->getMessage());
            return redirect()->back();
        }
    }

    public function changeCompany()
    {
        auth()->user()->profile()->update(['company_id' => 0, 'technology_area' => '', 'company_supervisor' => '', 'company_contact' => '']);
        return redirect()->back();
    }

    public function removeCompanyChoice($id)
    {
        $company = auth()->user()->choice()->find($id);
        $company->destroy($id);
        return redirect()->back();
    }
}
