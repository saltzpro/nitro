<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventAgeController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\EventShirtController;
use App\Http\Controllers\EventPickupController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\EventCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {
        
    Route::prefix('/v1')->group(function() {
        Route::prefix('/organizer')->group(function() {
            Route::resource('/collections', CollectionController::class);
            Route::get('/user-events', [EventController::class, 'userEvents']);
        });
        
        Route::middleware(['selected.event'])->group(function () {
            Route::prefix('/organizer')->group(function() {
                Route::get('/dashboard-summary', [RegistrationController::class, 'dashboardSummary']);
                Route::get('/recently-activities', [RegistrationController::class, 'recentlyActivities']);
                Route::get('/registration/{status}', [RegistrationController::class, 'listOfRegistration']);

            });
            
            
            Route::get('/event-list', [EventController::class, 'eventList']);
        });

        Route::prefix('/admin')->group(function() {
            Route::get('/all-events', [EventController::class, 'allEvents']);
            Route::put('/all-events/{event}', [EventController::class, 'updateSelectedEvent']);
            Route::prefix('/event')->group(function() {

            });
            
            Route::resource('/event-pickup', EventPickupController::class);
            Route::resource('/event-category', EventCategoryController::class);
            Route::resource('/event-age', EventAgeController::class);
            Route::resource('/event-shirt', EventShirtController::class);
        });
    });
});

Route::prefix('/v1')->group(function () {
        // Matches The "/url/users" URL
        Route::resource('event' , EventController::class);

        Route::resource('/participants', RegistrationController::class);
        Route::prefix('/participants')->group(function() {
            Route::get('/all', [RegistrationController::class, '']);
        });

});
