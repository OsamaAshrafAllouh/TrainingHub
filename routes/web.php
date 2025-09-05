<?php

use App\Http\Controllers\Admin\AdvisorController;
use App\Http\Controllers\Admin\AdvisorFieldController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\TraineeController;
use App\Http\Controllers\Admin\TraineeProgramController;
use App\Http\Controllers\Admin\TrainingProgramController;
use App\Http\Controllers\Advisor\TaskController;
use App\Http\Controllers\API\SocialAuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\Trainee\MeetingRequestController;
use App\Http\Controllers\Trainee\PaymentInformationController;
use App\Http\Controllers\Trainee\TrainingTaskController;
use App\Http\Controllers\TrainingAttendanceController;
use App\Http\Controllers\WebSiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/' , [WebSiteController::class , 'index'])->name('home_page');


Route::resource('advisors' , AdvisorController::class )->only('store','create');
Route::resource('trainees' , TraineeController::class )->only('store','create');


//authorize using google
Route::get('login/google' , [SocialAuthController::class , 'redirectToProvider'])->name('google.login');
Route::get('auth/google/callback' , [SocialAuthController::class , 'handleCallback'])->name('google.login.callback');



Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    //main page
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //Advisors Component
    Route::resource('advisors' , AdvisorController::class )->except('store','create');
    Route::get('/get-advisors/{fieldId}', [AdvisorController::class, 'getAdvisors']);
    Route::get('/advisors-fields', [AdvisorController::class, 'advisorsFields'])->name('advisors-fields');
    Route::put('/update-status/{id}', [AdvisorFieldController::class, 'updateStatus'])->name('advisor-field.update-status');
    Route::post('/advisor-profile/save', [AdvisorController::class, 'save'])->name('advisor-profile.save');

    //Trainee Component
    Route::resource('trainees' , TraineeController::class )->except('store','create');
    Route::get('trainees-to-advisor', [TraineeController::class,'displayTrainees'])->name('trainees_to_advisor');
    Route::get('show_trainee/{id}', [TraineeController::class,'showTrainees'])->name('show_trainees_to_advisor');
    Route::post('/trainee-profile/save', [TraineeController::class, 'save'])->name('trainee-profile.save');
    Route::post('/trainee/update-status/{id}', [TraineeController::class, 'updateStatus'])->name('trainee.updatePaymentStatus');

    //Payment Component
    Route::resource('payments' , PaymentController::class );

    //Trainee Programs Request Component
    Route::resource('trainees-programs' , TrainingProgramController::class );
    Route::get('program-to-trainee', [TrainingProgramController::class,'displayAcceptedProgram'])->name('program_to_trainee');
    Route::get('trainees-programs-requests', [TrainingProgramController::class,'requests'])->name('trainees-programs-request');
    Route::get('/getAdvisor', [TrainingProgramController::class,'getAdvisor'])->name('getAdvisor');

//    Route::get('trainees-programs-request' , [TrainingProgramController::class,'apply'])->name('apply');

    //Program Component
    Route::resource('programs' , ProgramController::class );
    Route::get('/get-available-programs/{fieldId}', [ProgramController::class, 'getAvailablePrograms'])->name('get.available.programs');
    Route::get('show_programs', [ProgramController::class,'displayPrograms'])->name('programs_to_advisor');
    Route::get('/show_program_trainee/{program}', [TraineeController::class,'showTraineesinProgram'])->name('showTrainees');
    Route::get('/get-programs-by-advisor/{advisorId}', [MeetingRequestController::class,'getProgramsByAdvisor']);
    Route::post('/check-meeting-conflicts', [MeetingRequestController::class, 'checkMeetingConflicts'])->name('check.meeting.conflicts');

    //Fields or Discipline  Component
    Route::resource('fields' , FieldController::class );


    //Billing issues Component
    Route::get('/trainees-billings', [BillingController::class, 'index'])->name('trainees-billings');


    //accept registration Advisor or Trainee
    Route::get('/sendemail/{id}', [TraineeController::class, 'accept'])->name('sendemail');
    Route::get('/sendmail/{id}', [AdvisorController::class, 'accept'])->name('sendmailtoavisor');

    //Change Password Component
    Route::get('/updatePassword', [ProfileController::class, 'password'])->name('password');;
    Route::put('/password/update/{id}', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment-information', [PaymentInformationController::class, 'store'])->name('payment-information.store');
    Route::post('/pay', [PaymentInformationController::class, 'pay'])->name('payment-information.pay');

    //Trainee Programs Request Component
    Route::resource('tasks' , TaskController::class );
    Route::post('/save-mark',  [TaskController::class, 'saveMark'])->name('save.mark');
    Route::get('/alltasks/{id}',  [TaskController::class, 'alltasks'])->name('alltask');
    Route::get('/alltrainees/{id}',  [TrainingProgramController::class, 'alltrainee'])->name('alltrainees');
    Route::get('/Training-task', [TaskController::class, 'tasksSolution'])->name('Training-tasks.solution');


    //Trainee meeting Request Component
    Route::resource('meetings' , MeetingRequestController::class );
    Route::get('/meetings-request', [MeetingRequestController::class, 'meetings'])->name('advisor.meetings.index');

    //solution of tasks
    Route::resource('Training-tasks', TrainingTaskController::class);

    Route::get('program-tasks/{id}', [TrainingTaskController::class, 'task'])->name('task');

    //Change Profile Component
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');;


    Route::get('/calendar/{id}', [CalendarController::class , 'view'])->name('calendar.view');
    Route::post('/add-attendance', [TrainingAttendanceController::class,'addAttendance'])->name('add.attendance');


    Route::get('/logs', [LogController::class, 'showLogs'])->name('logs');

});

