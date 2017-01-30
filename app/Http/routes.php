<?php

Route::get('/refresh', ['as' => 'pageRefresh', function(){
    session(['fire' => "fired"]);
    return redirect()->back();
}]);


Route::get('/down', ['as' => 'systemDown', 'uses' => 'PagesController@down']);

Route::get('/', ['as' => 'index', 'uses' => 'PagesController@index']);
Route::get('/user/account/registration/done', ['as' => 'userDone', 'uses' => 'PagesController@done']);
Route::get('/user/account/confirmed', ['as' => 'userConfirmed', 'uses' => 'PagesController@confirmed']);
Route::get('/user/account/confirmation/{code}', ['as' => 'userConfirmation', 'uses' => 'PagesController@confirmation']);

Route::post('login', ['as' => 'userLogin', 'uses' => 'PagesController@login']);
Route::post('register', ['as' => 'userRegister', 'uses' => 'PagesController@register']);
Route::patch('user/account/setup/{id}', ['as' => 'setup', 'uses' => 'PagesController@setup']);
Route::post('email/send', ['as' => 'sendEmail', 'uses' => 'MailController@send']);
Route::get('forgot-password', ['as' => 'forgotPassword', 'uses' => 'PagesController@forgot']);
Route::get('account/recovery', ['as' => 'recovery', 'uses' => 'PagesController@recovery']);
Route::post('password/recover', ['as' => 'recover', 'uses' => 'PagesController@recover']);

Route::get('/admin', ['as' => 'adminIndex', 'uses' => 'AdminController@index']);
Route::get('/admin/account/setup', ['as' => 'adminSetup', 'uses' => 'AdminController@setup']);
Route::get('/admin/account/setup/done', ['as' => 'adminDone', 'uses' => 'AdminController@done']);
Route::get('/admin/account/confirmation/{code}', ['as' => 'adminConfirmation', 'uses' => 'AdminController@confirmation']);
Route::get('/admin/account/confirmed', ['as' => 'adminConfirmed', 'uses' => 'AdminController@confirmed']);
Route::post('/admin/login', ['as' => 'adminLogin', 'uses' => 'AdminController@login']);
Route::post('/admin/account/new/install', ['as' => 'adminInstall', 'uses' => 'AdminController@install']);
Route::patch('/admin/account/{id}', ['as' => 'adminConfirm', 'uses' => 'AdminController@confirm']);

Route::group(['middleware' => 'admin'], function(){
    Route::get('admin/student/profile/{id}', ['as' => 'adminStudentProfile', 'uses' => 'AdminController@studentProfile']);
    Route::get('/admin/waiver/{id}', ['as' => 'adminShowWaiver', 'uses' => 'AdminController@waiver']);
    Route::get('/admin/letter/waiver/{id}', ['as' => 'adminShowWaiverLetter', 'uses' => 'AdminController@waiverLetter']);
    Route::get('/admin/personal-info/{id}', ['as' => 'adminShowPersonal', 'uses' => 'AdminController@personal']);
    Route::get('/admin/letter/personal-info/{id}', ['as' => 'adminShowPersonalLetter', 'uses' => 'AdminController@personalLetter']);
    Route::get('/admin/evaluation/{id}', ['as' => 'adminShowEvaluation', 'uses' => 'AdminController@evaluation']);
    Route::get('/admin/letter/evaluation/{id}', ['as' => 'adminShowEvaluationLetter', 'uses' => 'AdminController@evaluationLetter']);
    Route::get('/admin/dashboard', ['as' => 'adminDashboard', 'uses' => 'AdminController@dashboard']);
    Route::get('/admin/logs', ['as' => 'adminLogs', 'uses' => 'AdminController@logs']);
    Route::get('/admin/profile', ['as' => 'adminProfile', 'uses' => 'AdminController@profile']);
    Route::get('/admin/users/advisers', ['as' => 'adminCollectionAdviser', 'uses' => 'AdminController@collectionAdviser']);
    Route::get('/admin/users/students', ['as' => 'adminCollectionStudent', 'uses' => 'AdminController@collectionStudent']);
    Route::get('/admin/course-and-section', ['as' => 'adminCourseAndSection', 'uses' => 'AdminController@courseAndSection']);
    Route::get('/admin/companies', ['as' => 'adminCompany', 'uses' => 'AdminController@company']);
    Route::get('/admin/course-and-section/section/remove/{id}', ['as' => 'adminRemoveSection', 'uses' => 'AdminController@removeSection']);
    Route::get('/admin/logout', ['as' => 'adminLogout', 'uses' => 'AdminController@logout']);
    Route::get('/admin/load/request', ['as' => 'loadRequest', 'uses' => 'AdminController@loadRequest']);
    Route::get('/admin/request/{id}/action/accept', ['as' => 'adminRequestAccept', 'uses' => 'AdminController@acceptRequest']);
    Route::get('/admin/request/{id}/action/reject', ['as' => 'adminRequestReject', 'uses' => 'AdminController@rejectRequest']);
    Route::get('/admin/inbox', ['as' => 'adminInbox', 'uses' => 'AdminController@inbox']);
    Route::get('/admin/inbox/chat/{id}', ['as' => 'adminChat', 'uses' => 'AdminController@chat']);
    Route::post('/admin/inbox/chat/send/{id}/{chat_id}', ['as' => 'adminMessageSend', 'uses' => 'AdminController@send']);
    Route::get('admin/user/profile/email/update', ['as' => 'setEmail', 'uses' => 'AdminController@setEmail']);
    Route::patch('admin/user/profile/email/update', ['as' => 'updateEmail', 'uses' => 'AdminController@updateEmail']);
    Route::get('admin/user/profile/password/update', ['as' => 'setPass', 'uses' => 'AdminController@setPassword']);
    Route::patch('admin/user/profile/password/update', ['as' => 'updatePass', 'uses' => 'AdminController@updatePassword']);
    Route::post('/admin/ojt/hours/set', ['as' => 'adminSetHours', 'uses' => 'AdminController@setHours']);
    Route::post('/admin/course-and-section/section/add', ['as' => 'adminAddSection', 'uses' => 'AdminController@addSection']);
});

Route::group(['middleware' => 'auth'], function() {

    Route::get('adviser/dashboard', ['as' => 'adviserDashboard', 'uses' => 'AdviserController@index']);
    Route::get('adviser/logout', ['as' => 'adviserLogout', 'uses' => 'AdviserController@logout']);
    Route::get('adviser/signature', ['as' => 'adviserSignature', 'uses' => 'AdviserController@signature']);
    Route::get('adviser/users/students', [ 'as' => 'myStudents', 'uses' => 'AdviserController@showStudents']);
    Route::get('adviser/logs', [ 'as' => 'adviserActivityLogs', 'uses' => 'AdviserController@showLogs']);
    Route::get('adviser/user/profile', ['as' => 'adviserProfile', 'uses' => 'AdviserController@profile']);
    Route::get('adviser/user/profile/email/update', ['as' => 'adviserSetEmail', 'uses' => 'AdviserController@setEmail']);
    Route::get('adviser/user/profile/password/update', ['as' => 'adviserSetPass', 'uses' => 'AdviserController@setPassword']);
    Route::get('adviser/load/request', ['as' => 'adviserLoadRequest', 'uses' => 'AdviserController@loadRequest']);
    Route::get('adviser/load/notifications', ['as' => 'adviserLoadNotification', 'uses' => 'AdviserController@loadNotification']);
    Route::get('adviser/remove/notifications/{id}', ['as' => 'adviserRemoveNotification', 'uses' => 'AdviserController@removeNotification']);
    Route::get('adviser/inbox', ['as' => 'adviserInbox', 'uses' => 'AdviserController@inbox']);
    Route::get('adviser/inbox/clear', ['as' => 'adviserClear', 'uses' => 'AdviserController@clearNewMessages']);
    Route::get('adviser/inbox/chat/{id}', ['as' => 'adviserChat', 'uses' => 'AdviserController@chat']);
    Route::post('adviser/inbox/chat/send/{id}/{chat_id}', ['as' => 'messageSend', 'uses' => 'AdviserController@send']);
    Route::patch('adviser/user/profile/password/update', ['as' => 'adviserUpdatePass', 'uses' => 'AdviserController@updatePassword']);
    Route::patch('adviser/user/profile/email/update', ['as' => 'adviserUpdateEmail', 'uses' => 'AdviserController@updateEmail']);
    Route::get('adviser/student/profile/{id}', ['as' => 'adviserStudentProfile', 'uses' => 'AdviserController@studentProfile']);
    Route::get('adviser/request/{id}/action/accept', ['as' => 'adviserRequestAccept', 'uses' => 'AdviserController@acceptRequest']);
    Route::get('adviser/request/{id}/action/reject', ['as' => 'adviserRequestReject', 'uses' => 'AdviserController@rejectRequest']);
    Route::get('/adviser/waiver/{id}', ['as' => 'adviserShowWaiver', 'uses' => 'AdviserController@waiver']);
    Route::get('/adviser/letter/waiver/{id}', ['as' => 'adviserShowWaiverLetter', 'uses' => 'AdviserController@waiverLetter']);
    Route::get('/adviser/personal-info/{id}', ['as' => 'adviserShowPersonal', 'uses' => 'AdviserController@personal']);
    Route::get('/adviser/letter/personal-info/{id}', ['as' => 'adviserShowPersonalLetter', 'uses' => 'AdviserController@personalLetter']);
    Route::get('/adviser/evaluation/{id}', ['as' => 'adviserShowEvaluation', 'uses' => 'AdviserController@evaluation']);
    Route::get('/adviser/letter/evaluation/{id}', ['as' => 'adviserShowEvaluationLetter', 'uses' => 'AdviserController@evaluationLetter']);
    Route::patch('adviser/user/profile/picture/update', ['as' => 'adviserChangeDP', 'uses' => 'AdviserController@changeDP']);
    Route::get('adviser/user/profile/email/update', ['as' => 'adviserSetEmail', 'uses' => 'AdviserController@setEmail']);
    Route::patch('adviser/user/profile/email/update', ['as' => 'adviserUpdateEmail', 'uses' => 'AdviserController@updateEmail']);
    Route::get('adviser/user/profile/password/update', ['as' => 'adviserSetPass', 'uses' => 'AdviserController@setPassword']);
    Route::patch('adviser/user/profile/password/update', ['as' => 'adviserUpdatePass', 'uses' => 'AdviserController@updatePassword']);
    Route::get('/adviser/swass/{week}/{id}', ['as' => 'adviserShowSWASS', 'uses' => 'AdviserController@swass']);
    Route::get('/adviser/letter/swass/{week_no}/{id}', ['as' => 'adviserShowSwassLetter', 'uses' => 'AdviserController@swassLetter']);
    Route::get('/adviser/ojt-forms', ['as' => 'adviserForms', 'uses' => 'AdviserController@forms']);
    Route::post('adviser/forms/upload', ['as' => 'formUpload', 'uses' => 'AdviserController@fileUpload']);
    Route::get('adviser/forms/remove/{id}', ['as' => 'formRemove', 'uses' => 'AdviserController@fileRemove']);
    Route::get('adviser/report', ['as' => 'adviserReports', 'uses' => 'AdviserController@reports']);

    Route::get('student/inbox/clear', ['as' => 'studentClear', 'uses' => 'StudentController@clearNewMessages']);
    Route::get('/student/dashboard', ['as' => 'studentDashboard', 'uses' => 'StudentController@index']);
    Route::get('/student/profile', ['as' => 'studentProfile', 'uses' => 'StudentController@index']);
    Route::get('/student/inbox', ['as' => 'studentInbox', 'uses' => 'StudentController@inbox']);
    Route::get('/student/recommendation/{id}', ['as' => 'showRecommendation', 'uses' => 'StudentController@recommendation']);
    Route::get('/student/recommendation/letter/{id}', ['as' => 'showRecommendationLetter', 'uses' => 'StudentController@recommendationLetter']);
    Route::get('/student/load/notifications', ['as' => 'studentLoadNotification', 'uses' => 'StudentController@index']);
    Route::get('/student/company/set/{id}', ['as' => 'studentSetCompany', 'uses' => 'StudentController@setCompany']);
    Route::post('/student/company/add/choice', ['as' => 'studentAddCompany', 'uses' => 'StudentController@addCompany']);
    Route::get('/student/comapany/remove/choice/{id}', ['as' => 'studentRemoveCompany', 'uses' => 'StudentController@removeCompanyChoice']);
    Route::post('student/time-in', ['as' => 'timeIn', 'uses' => 'StudentController@timeIn']);
    Route::post('/student/time-out/{id}', ['as' => 'timeOut', 'uses' => 'StudentController@timeOut']);
    Route::get('/student/forms', ['as' => 'studentForm', 'uses' => 'StudentController@forms']);
    Route::get('/student/inbox', ['as' => 'studentInbox', 'uses' => 'StudentController@inbox']);
    Route::get('/student/inbox/chat/{id}', ['as' => 'studentChat', 'uses' => 'StudentController@chat']);
    Route::post('/student/inbox/chat/send/{id}/{chat_id}', ['as' => 'studentMessageSend', 'uses' => 'StudentController@send']);
    Route::post('/student/set/company-profile', ['as' => 'studentSetCompanyProfile', 'uses' => 'StudentController@setCompanyProfile']);
    Route::get('/student/logout', ['as' => 'studentLogout', 'uses' => 'StudentController@logout']);
    Route::get('/student/waiver', ['as' => 'showWaiver', 'uses' => 'StudentController@waiver']);
    Route::get('/student/letter/waiver', ['as' => 'showWaiverLetter', 'uses' => 'StudentController@waiverLetter']);
    Route::get('/student/personal-info', ['as' => 'showPersonal', 'uses' => 'StudentController@personal']);
    Route::get('/student/letter/personal-info', ['as' => 'showPersonalLetter', 'uses' => 'StudentController@personalLetter']);
    Route::get('/student/evaluation', ['as' => 'showEvaluation', 'uses' => 'StudentController@evaluation']);
    Route::get('/student/letter/evaluation', ['as' => 'showEvaluationLetter', 'uses' => 'StudentController@evaluationLetter']);
    Route::get('/student/swass/{week}', ['as' => 'showSWASS', 'uses' => 'StudentController@swass']);
    Route::get('/student/letter/swass/{week_no}', ['as' => 'showSwassLetter', 'uses' => 'StudentController@swassLetter']);
    Route::get('/student/company/change', ['as' => 'changeCompany', 'uses' => 'StudentController@changeCompany']);

});