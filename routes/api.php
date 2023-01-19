<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\Api\SupportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MessagesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/roles', [RolesController::class, 'roles']);

// Register
Route::post('/register', [AuthController::class, 'register']); 
Route::post('/login', [AuthController::class, 'login'])->name('login'); 
Route::post('/resetpassword', [AuthController::class, 'resetpassword']);
Route::post('/social-login', [AuthController::class, 'socialLoginHandler'])->name('social_login'); 
Route::post('/check_email_exist', [AuthController::class, 'check_email_exist']);


Route::group(['middleware' => ['auth:sanctum']], function () { 
   
    Route::post('/sendOTP', [AuthController::class, 'twiliosendsms']);
    Route::post('/verifyotp', [AuthController::class, 'verifyOTP']);
    Route::post('/changepassword', [AuthController::class, 'changepassword']);
    Route::post('/matchotp', [AuthController::class, 'matchotp']);
    Route::post('/sign-out', [AuthController::class, 'logout']); 
    Route::post('/create-post', [PostController::class, 'createPost']);
    Route::get('/get-posts', [PostController::class, 'getAllPosts']);
    Route::post('/add-comment', [PostController::class, 'comments']);
    Route::post('/like_post', [PostController::class, 'like_post']);
    Route::post('/unlike_post', [PostController::class, 'unlike_post']);
    Route::post('/hide_post', [PostController::class, 'hide_post']);
    Route::post('/share', [PostController::class, 'share'])->name('share');

    Route::get('/searchUserData', [AuthController::class, 'searchUserData'])->name('searchUserData');

    //admin create job routes

    Route::post('/create-job', [JobsController::class, 'createJob']);
    Route::get('/get_all_jobs', [JobsController::class, 'get_all_jobs']);
    Route::get('job/{id}/', [JobsController::class, 'job'])->name('job');
    Route::get('search_job', [JobsController::class, 'search_job'])->name('search_job');
    Route::get('deleteJob', [JobsController::class, 'deleteJob'])->name('deleteJob');

   
    Route::post('user_create_jobs', [JobsController::class, 'user_create_jobs'])->name('user_create_jobs');
    Route::get('get_user_jobs', [JobsController::class, 'get_user_jobs'])->name('get_user_jobs');
    Route::post('hide_user_jobs', [JobsController::class, 'hide_user_jobs'])->name('hide_user_jobs');
    Route::post('apply_jobs', [JobsController::class, 'apply_jobs']);
  
    Route::post('/create-event', [EventController::class, 'createevent']);
    Route::get('/get_all_events', [EventController::class, 'get_all_events']);
    Route::get('event/{id}/', [EventController::class, 'event'])->name('event');
    Route::get('deleteEvent', [EventController::class, 'deleteEvent'])->name('deleteEvent');
    Route::get('event_delete', [EventController::class, 'event_delete'])->name('event_delete');
    Route::post('eventApply', [EventController::class, 'eventApply'])->name('eventApply');

    Route::get('event_start', [EventController::class, 'event_start'])->name('event_start');
    Route::get('event_start_fifteen_before', [EventController::class, 'event_start_fifteen_before'])->name('event_start_fifteen_before');

    Route::get('search_event', [EventController::class, 'search_event'])->name('search_event');
    Route::post('user_create_events', [EventController::class, 'user_create_events'])->name('user_create_events');
    Route::get('get_user_events', [EventController::class, 'get_user_events'])->name('get_user_events');
    Route::post('hide_user_events', [EventController::class, 'hide_user_events'])->name('hide_user_events');

    Route::post('/create-promotion', [PromotionController::class, 'createpromotion']);

    Route::get('/profile', [ProfileController::class, 'profile']);
    Route::put('/edit/{id}', [ProfileController::class, 'edit']);

    Route::post('/event-calender', [CalenderController::class, 'calender'])->name('calender'); 
    Route::get('/get_event_calender', [CalenderController::class, 'get_event_calender'])->name('get_event_calender');
    Route::get('/delete/{id}/', [CalenderController::class, 'destroy'])->name('delete'); 


    Route::get('Organizationprofile', [OrganizationController::class, 'Organizationprofile'])->name('Organizationprofile'); 
    Route::put('/Organizationedit/{id}', [OrganizationController::class, 'edit']);

    Route::get('Recruiterprofile', [RecruiterController::class, 'Recruiterprofile'])->name('Recruiterprofile'); 
    Route::put('/Recruiteredit/{id}', [RecruiterController::class, 'edit']);

    Route::post('/createSupport', [SupportController::class, 'createSupport']);
    Route::get('/get_user_support', [SupportController::class, 'get_user_support']);
    Route::get('/get_user_support_record', [SupportController::class, 'get_user_support_record']);
    Route::post('/send_support_message', [SupportController::class, 'send_support_message']);
    Route::get('/get_user_data', [SettingController::class, 'get_user_data']);
    Route::post('/update_privacy_setting', [SettingController::class, 'update_privacy_setting']);
    Route::get('/get_user_pricay_data', [SettingController::class, 'get_user_pricay_data']);
    Route::get('/get_notification', [SettingController::class, 'get_notification']);
    Route::get('/profile_view_notifications', [SettingController::class, 'profile_view_notifications']);
    Route::get('/termConditions', [SettingController::class, 'termConditions']);
    Route::get('/faq', [SettingController::class, 'faq']);
    Route::get('/privacyPolicy', [SettingController::class, 'privacyPolicy']);

    Route::post('/follower', [FollowController::class, 'Follower']);
    Route::post('/unfollow', [FollowController::class, 'unfollow']);


    Route::post('/createSubscription', [SubscriptionController::class, 'createSubscription']);
    Route::get('/getsubscription', [SubscriptionController::class, 'getsubscription']);
    Route::post('/userCreateSubscription', [SubscriptionController::class, 'userCreateSubscription']);
    Route::post('/userCancelSubscription', [SubscriptionController::class, 'userCancelSubscription']);

    Route::post('createcustomer', [PaymentController::class,'createCustomerOnStripe']);
    Route::get('getalllist', [PaymentController::class,'getalllist']);
    Route::get('getSingleCardDetail', [PaymentController::class,'getSingleCardDetail']);
    Route::get('deleteCardDetail', [PaymentController::class,'deleteCardDetail']);
    Route::put('updateCardDetail', [PaymentController::class,'updateCardDetail']);
    Route::post('cardSetDefault', [PaymentController::class,'cardSetDefault']);


    Route::post('scheduleInterview', [MessagesController::class,'scheduleInterview']);
    Route::get('getScheduledInterviews', [MessagesController::class,'getScheduledInterviews']);
    Route::get('deleteInterview', [MessagesController::class,'deleteInterview']);
});

Route::get('testNotification', [FollowController::class,'testNotification']);
Route::get('job_one_year', [EventController::class, 'job_one_year'])->name('job_one_year');
Route::get('linkedinauth', [AuthController::class, 'linkedinauth']);
Route::post('term_condition', [AuthController::class, 'term_condition'])->name('term_condition');
Route::post('faq', [AuthController::class, 'faq'])->name('faq');
Route::post('privacy_policy', [AuthController::class, 'privacy_policy'])->name('privacy_policy');