<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\ForgotPasswordController;

/*
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::any('/non_authenticated', function () {
    return response()->json([
        'code' => 404,
         'status' => false,
        'message' => 'Token not found',
    ], 404);
})->name('non_authenticated');

Route::get('/', 'App\Http\Controllers\Web\AdminController@index')->name('adminsignin');
Route::post('checkoutlogin', 'App\Http\Controllers\Web\AdminController@checkoutlogin')->name('checkoutloginadmin');


Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::post('support-chat-media', [AdminController::class, 'createAdminMessage']); 
Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); 
Route::get('support', [AdminController::class, 'support'])->name('support'); 
Route::get('get_user_data', [AdminController::class, 'get_user_data'])->name('get_user_data'); 
Route::get('pageUnderDev', [AdminController::class, 'pageUnderDev']);
Route::post('/cmplete', [AdminController::class, 'completedUpdate'])->name('cmplete');
Route::post('/createAdminMessage', [AdminController::class, 'createAdminMessage'])->name('createAdminMessage');
Route::post('/displayTicketMessage', [AdminController::class, 'displayTicketMessage'])->name('displayTicketMessage');
// Route::post('support-chat-media', [AdminController::class, 'createAdminMessage']);
// ---Display listing--- //
Route::get('indexList', [AdminController::class, 'indexList'])->name('indexList');
Route::get('searchbox',[AdminController::class,'searchbox'])->name('searchbox');
Route::match(['get','post'],'/exp-csv/{role}/{search?}',[AdminController::class,'exportFile'])->name('exportFile');
Route::get('showPro/{id}', [AdminController::class, 'showPro'])->name('showPro');
Route::post('approve-reject', [AdminController::class, 'approveReject'])->name('approveReject');

Route::get('showRecruOrg/{id}', [AdminController::class, 'showRecruOrg'])->name('showRecruOrg');
Route::get('advertisment', [AdminController::class, 'advertisment'])->name('advertisment');
Route::get('create-advertisment', [AdminController::class, 'createAdvertisement'])->name('createAdvertisement');
Route::post('create-advert', [AdminController::class, 'createAdvert'])->name('createAdvert');
Route::get('postApproval', [AdminController::class, 'postApproval'])->name('postApproval');
Route::get('push-card-dashboard', [AdminController::class, 'pushCardDash'])->name('pushCardDash');
Route::get('push-card', [AdminController::class, 'pushCard'])->name('pushCard');
Route::post('add-push-card', [AdminController::class, 'addPushCard'])->name('addPushCard');
Route::get('edit-push-card/{id}', [AdminController::class, 'editPushCard'])->name('editPushCard');
Route::post('edit-card/', [AdminController::class, 'editCard'])->name('editCard');
Route::match(['get','post'],'delete-push-card/{id}', [AdminController::class, 'deletePush'])->name('deletePush');
Route::get('guide-line-term', [AdminController::class, 'guideLineTerm'])->name('guideLineTerm');
Route::get('guide-line', [AdminController::class, 'guidLine'])->name('guidLine');
Route::get('edit-term-condition', [AdminController::class, 'editTermCon'])->name('editTermCon');
Route::post('edit-term', [AdminController::class, 'editTerm'])->name('editTerm');
Route::get('editFaq/{id}', [AdminController::class, 'editFaq'])->name('editFaq');
Route::post('edit-Faq', [AdminController::class, 'edit_faq'])->name('edit_faq');
Route::get('privacyPolicy', [AdminController::class, 'privacyPolicy'])->name('privacyPolicy');
Route::post('editPrivacy', [AdminController::class, 'editPrivacy'])->name('editPrivacy');
Route::get('cap-profanity', [AdminController::class, 'capProfanity'])->name('capProfanity');
Route::get('delete-profanity', [AdminController::class, 'deletePro'])->name('deletePro');
Route::get('admin-push-notification', [AdminController::class, 'adminPushNotification'])->name('adminPushNotification');
Route::post('admin-push-noti', [AdminController::class, 'adminPushNoti'])->name('adminPushNoti');
Route::get('checkbox-noti', [AdminController::class, 'checkNoti'])->name('checkNoti');
Route::get('activeStatus', [AdminController::class, 'activeStatus'])->name('activeStatus');
Route::get('pushNotificationGroup', [AdminController::class, 'pushNotificationGroup'])->name('pushNotificationGroup');