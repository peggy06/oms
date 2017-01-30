<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Company;
use App\Course;
use App\Dtr;
use App\Hour;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\FormUploadRequest;
use App\Log;
use App\Message;
use App\Notification;
use App\Period;
use App\Permission;
use App\Profile;
use App\Section;
use App\Signature;
use App\User;
use App\Form;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;

class AdviserController extends Controller
{
    public function __construct(User $user, Log $log, Signature $signature, Permission $permission, Notification $notification, Message $message, Chat $chat, Company $company, Hour $hour, Course $course, Section $section, Dtr $dtr, Period $period, Profile $profile, Form $form){
        $this->users = $user;
        $this->log = $log;
        $this->signatures = $signature;
        $this->permission = $permission;
        $this->notification = $notification;
        $this->messages = $message;
        $this->chat = $chat;
        $this->company = $company;
        $this->hour = $hour;
        $this->course = $course;
        $this->section = $section;
        $this->dtr  = $dtr;
        $this->profile = $profile;
        $this->period = $period;
        $this->form = $form;
        session_start();
    }

    public function index(){
        if(!auth()->guest()){
            $page_title = 'Dashboard';
            $logs = $this->log;
            $signature = $this->signatures;
            $users = $this->users->where(['deleted' => 0, 'confirmed' => 1, 'under_to' => auth()->user()->id])->get();
            $onDuty = $this->users->where(['role' => 5, 'under_to' => auth()->user()->id, 'onDuty' => 1])->get();
            $permissions = $this->permission;
            $messages = $this->messages;
            $notifications = $this->notification;
            $my_messages = $messages->where(['receiver' => auth()->user()->id, 'new' => 1])->get();

            return view('frontend.users.advisers.dashboard', compact('page_title', 'logs', 'users', 'signature', 'permissions', 'notifications', 'messages', 'onDuty', 'my_messages'));
        }else{
            return redirect()->route('index');
        }
    }

    public function loadRequest(){
        $users = $this->users;
        $permissions = $this->permission;
        $to_sort = $permissions->where(['deleted' => 0, 'to' => auth()->user()->id, 'accepted' => 0])->get()->toArray();
        $sorted_permission = array_reverse($to_sort);
        return view('frontend.users.advisers.requestHolder', compact('sorted_permission', 'permissions', 'users'));
    }

    public function loadNotification(){
        $users = $this->users;
        $notifications = $this->notification;
        $to_sort = $notifications->where(['deleted' => 0, 'to' => auth()->user()->id])->get()->toArray();
        $sorted_notifications = array_reverse($to_sort);
        return view('frontend.users.advisers.notificationHolder', compact('sorted_notifications', 'notifications', 'users'));
    }

    public function removeNotification($id){
        $id = decrypt($id);

        $this->notification->find($id)->update(['removed' => 1]);
        return redirect()->back();
    }

    public function logout(){
        $this->users->where('id', auth()->user()->id)->update(['isOnline' => '0']);
        $this->log->create([
            'user_id'   => auth()->user()->id,
            'activity'  => "Logout",
            'role'      => auth()->user()->role
        ]);
        session()->forget(['userLogin']);
        auth()->logout();
        return redirect()->back();
    }

    public function showStudents(){
        $page_title = "Student's List";
        $users = $this->users;
        $permissions = $this->permission;
        $notifications = $this->notification;
        $messages = $this->messages;
        return view('frontend.users.advisers.myStudents', compact('page_title', 'users', 'sorted_permission', 'permissions', 'notifications', 'messages'));
    }

    public function showLogs(){
        if(!auth()->guest()) {
            $deletedLogs = false;
            $users = $this->users;
            $logs = $this->log;
            $permissions = $this->permission;
            $notifications = $this->notification;
            $messages = $this->messages;
            return view('frontend.users.advisers.logs', compact('logs', 'users', 'deletedLogs',  'sorted_permission', 'permissions', 'notifications', 'messages'));
        }else {
            return redirect()->route('index');
        }
    }

    public function inbox(){
        $page_title = 'Inbox';
        $users = $this->users;
        $permissions = $this->permission;
        $notifications = $this->notification;
        $messages = $this->messages;

        return view('frontend.users.advisers.inbox', compact('page_title', 'users', 'sorted_permission', 'permissions', 'notifications', 'messages'));

    }

    public function clearNewMessages(){
        if($this->messages->where(['receiver' => auth()->user()->id, 'deleted' => 0, 'new' => 1])->count() != 0){
            $this->messages->where(['receiver' => auth()->user()->id, 'new' => 1])->update(['new' => 0]);
        }
        return redirect()->action('AdviserController@inbox');
    }

    public function chat($id){
        $id = decrypt($id);
        if($this->messages->where(['receiver' => auth()->user()->id, 'sender' => $this->users->find($id)->id, 'seen' => 0])->count() != 0){
            $this->messages->where(['receiver' => auth()->user()->id, 'sender' => $this->users->find($id)->id, 'seen' => 0])->update(['seen' => 1, 'new' => 0]);
        }
        $member = $id.'&'.auth()->user()->id;
        $page_title = 'Inbox';
        $users = $this->users;
        $permissions = $this->permission;
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
        return view('frontend.users.advisers.chatbox', compact('page_title', 'users', 'sorted_permission', 'permissions', 'notifications', 'messages', 'chat', 'id', 'sender', 'chat_id'));
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

    public function profile(){
        $page_title = 'Profile';
        $messages = $this->messages;
        $users = $this->users;
        $permissions = $this->permission;
        $notifications = $this->notification;
        return view('frontend.users.advisers.profile', compact('page_title', 'users', 'sorted_permission', 'permissions', 'notifications', 'messages'));
    }

    public function studentProfile($id){
        $users = $this->users;
        $user = $this->users->find($id);
        $company = $this->company;
        $hours = $this->hour;
        $messages = $this->messages;
        $permissions = $this->permission;
        $notifications = $this->notification;
        $course = $this->course;
        $section = $this->section;
        $dtr = $this->dtr->where(['user_id' => $id])->get();
        $forms = $this->form->all();
        if($this->period->where(['user_id' => $id])->count() != 0){
            $week_no = Carbon::now()->diffInWeeks($this->period->where(['user_id' => $id])->first()->created_at) + 1;
        }else{
            $week_no = 0;
        }
        return view('frontend.users.advisers.studentProfile', compact('users', 'company', 'hours', 'notifications', 'permissions', 'messages', 'user', 'course', 'section', 'dtr', 'week_no', 'forms'));
    }

    public function acceptRequest($id){
        $decrypted_id = decrypt($id);
        try{

            $this->users->where('id', $this->permission->where('id', $decrypted_id)->first()->user_id)->update(['accepted' => '1']);
            $this->permission->find($decrypted_id)->update([
                'accepted'  => 1,
                'deleted'   => 1,
                'new'       => 2
            ]);

            $this->notification->create([
                'to'        => $this->permission->where('id', $decrypted_id)->first()->user_id,
                'poser'     => auth()->user()->id,
                'event'     => auth()->user()->name.' accepted your request.',
                'removed'   => 0,
                'deleted'   => 0
            ]);

            return redirect()->back();
        }catch (Exception $e){
            return $e;
        }
    }

    public function rejectRequest($id){
        $decrypted_id = decrypt($id);
        try{

            $this->users->where('id', $this->permission->where('id', $decrypted_id)->first()->user_id)->update(['accepted' => '2']);
            $permit = $this->permission->find($decrypted_id)->update([
                'accepted'  => 2,
                'deleted'   => 1,
                'new'       => 2
            ]);

            $this->notification->create([
                'to'        => $permit->user_id,
                'event'     => auth()->user()->name.' rejected your request!',
                'removed'   => 0,
                'deleted'   => 0
            ]);

            $this->users->where('id', $permit->user_id)->update(['accepted' => '1']);

            return redirect()->back();
        }catch (Exception $e){

        }
    }

    public function waiver($id){
        $users = $this->users;
        $hours = $this->hour->find(1);
        $user = $this->users->find($id);
        $company = $this->company->find($this->users->find($id)->profile->company_id);
        return view('frontend.users.advisers.forms.waiver', compact('users', 'hours', 'company', 'user'));
    }

    public function waiverLetter($id){
        $permissions = $this->permission;
        $messages = $this->messages;
        $notifications = $this->notification;
        $users = $this->users;
        $user = $this->users->find($id);
        $user_profile = $this->users->find($id)->profile;
        return view('frontend.users.advisers.letterHolder_waiver', compact('company_choice', 'user_profile', 'messages', 'notifications', 'users', 'user', 'id', 'permissions'));
    }


    public function personal($id){
        $permissions = $this->permission;
        $users = $this->users;
        $hours = $this->hour->find(1);
        $course = $this->course;
        $user = $this->users->find($id);
        $company = $this->company->find($this->users->find($id)->profile->company_id);
        return view('frontend.users.advisers.forms.personal_info', compact('users', 'hours', 'company', 'course', 'permissions', 'user'));
    }

    public function personalLetter($id){
        $permissions = $this->permission;
        $messages = $this->messages;
        $notifications = $this->notification;
        $users = $this->users;
        $user_profile = $this->users->find($id)->profile;
        return view('frontend.users.advisers.letterHolder_personal', compact('company_choice', 'user_profile', 'messages', 'notifications', 'users', 'id', 'permissions'));
    }

    public function evaluation($id){
        $users = $this->users;
        $hours = $this->hour->find(1);
        $course = $this->course;
        $company = $this->company->find($this->users->find($id)->profile->company_id);
        $profile = $this->profile->find($id);
        $hour = $this->hour->find(1);
        $period = $this->period->where(['user_id' => $id]);
        return view('frontend.users.advisers.forms.evaluation', compact('users', 'hour', 'company', 'course', 'profile', 'period', 'id'));
    }

    public function evaluationLetter($id){
        $permissions = $this->permission;
        $messages = $this->messages;
        $notifications = $this->notification;
        $users = $this->users;
        $user_profile = $this->users->find($id)->profile;
        return view('frontend.users.advisers.letterHolder_evaluation', compact('company_choice', 'user_profile', 'messages', 'notifications', 'users', 'id', 'permissions'));
    }

    public function swass($week, $id){
        $users = $this->users;
        $permissions = $this->permission;
        $hours = $this->hour->find(1);
        $user = $this->users->find($id);
        $course = $this->course->find($user->profile->course);
        $section = $this->section->find($user->profile->section);
        $company = $this->company->find($this->users->find($user->id)->profile->company_id);
        $swass = $this->dtr->where(['user_id' => $id, 'week_no' => $week])->get();
        return view('frontend.users.advisers.forms.SWASS', compact('user', 'users', 'hours', 'company', 'course','section', 'swass', 'week', 'permissions'));
    }

    public function swassLetter($week_no, $id){
        $messages = $this->messages;
        $notifications = $this->notification;
        $users = $this->users;
        $permissions = $this->permission;
        $user_profile = $this->users->find(auth()->user()->id)->profile;
        return view('frontend.users.advisers.letterHolder_swass', compact('company_choice', 'user_profile', 'messages', 'notifications', 'users', 'week_no', 'id', 'permissions'));
    }

    public function setEmail(){
        $permissions = $this->permission;
        $messages = $this->messages;
        $notifications = $this->notification;
        if(!auth()->guest()) {
            $users = $this->users;
            return view('frontend.users.advisers.editEmail', compact('users', 'notifications', 'permissions', 'messages'));
        }else {
            return redirect()->route('index');
        }
    }

    public function setPassword(){
        $permissions = $this->permission;
        $messages = $this->messages;
        $notifications = $this->notification;
        if(!auth()->guest()) {
            $users = $this->users;
            return view('frontend.users.advisers.editPass', compact('users', 'notifications', 'permissions', 'messages'));
        }else {
            return redirect()->route('index');
        }
    }

    public function updateEmail(Request $request){
        if($request->input('email') == $request->input('confirmEmail')){
            if(password_verify($request->input('password'),auth()->user()->password)){
                try{
                    $email_updated = $this->users->find(auth()->user()->id)->update(['email' => $request->input('email')]);

                    if($email_updated){
                        try{
                            $this->log->create([
                                'user_id'   => auth()->user()->id,
                                'role'      => auth()->user()->role,
                                'activity'  => "Change email to ".$request->input('email'),
                            ]);

                            session()->flash('success', "Email has been changed.");
                            return redirect(route('adviserProfile'));
                        }catch (Exception $e){
                            session()->flash('failed', "Can't record activity");
                            return redirect()->back();
                        }
                    }
                }catch (Exception $e){
                    session()->flash('failed', "Can't update email");
                    return redirect()->back();
                }
            }else{
                session()->flash('failed', "Incorrect Password");
                return redirect()->back();
            }
        }else{
            session()->flash('failed', "Email did not match");
            return redirect()->back();
        }
    }

    public function updatePassword(Request $request){
        if($request->input('newPassword') == $request->input('confPassword')){
            if(password_verify($request->input('currPassword'),auth()->user()->password)){
                try{
                    $password_update = $this->users->find(auth()->user()->id)->update(['password' => bcrypt($request->input('newPassword'))]);

                    if($password_update){
                        try{
                            $this->log->create([
                                'user_id'   => auth()->user()->id,
                                'role'      => auth()->user()->role,
                                'activity'  => "Change password",
                            ]);

                            session()->flash('success', "Password has been changed.");
                            return redirect(route('adviserProfile'));

                        }catch (Exception $e){
                            session()->flash('failed', "Can't record activity");
                            return redirect()->back();
                        }
                    }
                }catch (Exception $e){
                    session()->flash('failed', "Can't update passsword");
                    return redirect()->back();
                }
            }else{
                session()->flash('failed', "Incorrect Password");
                return redirect()->back();
            }
        }else{
            session()->flash('failed', "New Password did not match");
            return redirect()->back();
        }
    }


    public function forms(){
        $permissions = $this->permission;
        $messages = $this->messages;
        $notifications = $this->notification;
        $forms = $this->form->all();
        return view('frontend.users.advisers.forms', compact('permissions', 'messages', 'notifications', 'forms'));
    }

    public function fileUpload(FormUploadRequest $request)
    {
        $filename = $request->file('form')->getClientOriginalName();
        $path = '/forms/'.$filename;

        $upload_complete = $this->form->create(['name' => $filename, 'path' => $path, 'created_by' => auth()->user()->id]);

        if($upload_complete){
            $request->form->move(public_path() . '/forms/', $path);
        }
        return redirect()->back();
    }

    public function fileRemove($id)
    {
        $form = $this->form->find($id);
        unlink(public_path($form->path));
        $form->destroy($id);
        return redirect()->back();
    }

    public function reports()
    {
        $permissions = $this->permission;
        $messages = $this->messages;
        $notifications = $this->notification;
        $users = $this->users->where(['under_to' => auth()->user()->id])->get();
        $company = $this->company->all();
        return view('frontend.users.advisers.reports', compact('users', 'messages', 'permissions', 'notifications', 'company'));
    }
}
