<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\StoryController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
 //   return $request->user();
//});

Route::group([

    'middleware'=>['auth:sanctum'],
    'prefix' => 'professional',
    'as' => 'professional.'

], function ($router) {        

        Route::group(['prefix' => 'story','as' => 'story.'], function ($router) {
             Route::get('info/{id}/', [StoryController::class, 'story'])->name('story');
            Route::post('/store', [StoryController::class, 'store'])->name('store');
            Route::post('/image-upload', [StoryController::class, 'image_upload'])->name('image_upload');
            Route::get('/list', [StoryController::class, 'stories'])->name('stories');
            Route::post('/interestedStory', [StoryController::class, 'interestedStory'])->name('interestedStory');
            Route::get('/delete-story', [StoryController::class, 'story_delete'])->name('delete-story');
        });

       
});





