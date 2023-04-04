<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Middleware\TimeRestrictionMiddleware;
use App\Http\Middleware\VoteDay;



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
    return view('auth.register');
});

Route::get('/link', function(){

    Artisan::call('storage:link');

    });

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('voter.message');

// Admin authentication routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');
    
    // Admin registration routes
    Route::get('register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [App\Http\Controllers\Admin\Auth\RegisterController::class, 'register']);
    
    //Email Verification routes 
    Route::get('email/verify', [App\Http\Controllers\Admin\Auth\VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\Admin\Auth\VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [App\Http\Controllers\Admin\Auth\VerificationController::class, 'resend'])->name('verification.resend');

     //Party routes
     Route::resource('party', 'App\Http\Controllers\Admin\PartyController')
     ->middleware(['auth:admin', 'verified.admin']);

      //Candidate routes 
    Route::resource('candidate', 'App\Http\Controllers\Admin\CandidateController')
    ->middleware(['auth:admin', 'verified.admin']);
    //Dropdown route
    Route::post('candidate/filter-constituencies', 'App\Http\Controllers\Admin\CandidateController@filterConstituencies')->name('filter.constituencies');
    });

    //Admin Dashboard route
    Route::get('admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth:admin',\App\Http\Middleware\EnsureAdminIsVerified::class])
    ->name('dashboard');
    
    //Admin Reset Password routes
    Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('/admin/password/reset', [App\Http\Controllers\Admin\Auth\AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
    Route::post('/admin/password/email', [App\Http\Controllers\Admin\Auth\AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::get('/admin/password/reset/{token}', [App\Http\Controllers\Admin\Auth\AdminResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
    Route::post('/admin/password/reset', [App\Http\Controllers\Admin\Auth\AdminResetPasswordController::class, 'reset'])->name('admin.password.update');
        });
    
    //Import Boundary routes 
    Route::get('admin/boundary', [App\Http\Controllers\Admin\ElectoralBoundaryController::class, 'uploadfile'])->name('admin.upload')->middleware(['auth:admin', 'verified.admin']);
    Route::post('admin/boundary', [App\Http\Controllers\Admin\ElectoralBoundaryController::class, 'boundary'])->name('admin.boundary')->middleware(['auth:admin', 'verified.admin']);

    //Voter Routes
    // Route::resource('voter', App\Http\Controllers\Voter\VoterController::class);
    Route::get('voter/register', [App\Http\Controllers\Voter\VoterController::class, 'create'])->middleware('auth')->name('voter.register');
    Route::post('voter/store', [App\Http\Controllers\Voter\VoterController::class, 'store'])->middleware('auth')->name('voter.store');
    Route::get('voter/show', [App\Http\Controllers\Voter\VoterController::class, 'show'])->middleware('auth')->name('voter.show');
    Route::get('admin/voters', [App\Http\Controllers\Voter\VoterController::class, 'index'])->middleware(['auth:admin', 'verified.admin'])->name('voter.index');

    //Constituency and Regional votes routes 
     Route::get('vote/constituency-vote', [App\Http\Controllers\Voter\VoteController::class, 'createConstituency'])
     ->middleware(TimeRestrictionMiddleware::class, 'auth')
     ->name('vote.createConstituency');
  
     Route::post('vote/constituency-vote', [App\Http\Controllers\Voter\VoteController::class, 'storeConstituency'])
        ->middleware(TimeRestrictionMiddleware::class)
    ->middleware('auth')
    ->name('vote.storeConstituency');

    Route::get('vote/regional-vote', [App\Http\Controllers\Voter\VoteController::class, 'createRegional'])
    ->middleware(TimeRestrictionMiddleware::class)
    ->middleware('auth')
    ->name('vote.createRegional');

    Route::post('vote/regional-vote', [App\Http\Controllers\Voter\VoteController::class, 'storeRegional'])
    ->middleware(TimeRestrictionMiddleware::class)
    ->middleware('auth')
    ->name('vote.storeRegional');
    Route::get('vote/message', [App\Http\Controllers\Voter\VoteController::class, 'show'])
    ->middleware('auth')
    ->name('vote.show');
   
//Election Results routes 
Route::get('admin/constituency-votes/search', [App\Http\Controllers\Voter\VoteController::class, 'searchConstituencyVote'])->middleware(['auth:admin', \App\Http\Middleware\EnsureAdminIsVerified::class]);
Route::get('admin/regional-votes/search', [App\Http\Controllers\Voter\VoteController::class, 'searchRegionalVote'])->name('vote.searchRegionalVote')->middleware(['auth:admin', \App\Http\Middleware\EnsureAdminIsVerified::class]);

Route::get('storage/media/{image}', [App\Http\Controllers\Voter\VoteController::class, 'images']);





   








   
    
 






