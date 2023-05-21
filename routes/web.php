<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\MomoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/register/{referral?}', [RegisterController::class, 'showRegistrationForm'])->name('register');
Auth::routes();

// Email verification routes
Route::controller(EmailController::class)
    ->middleware('block')
    ->group(function () {
        Route::get('/email/verify', 'verify')
            ->middleware('auth')
            ->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', 'fulfill')
            ->middleware(['auth', 'signed'])
            ->name('verification.verify');

        Route::post('/email/verification-notification', 'notification')
            ->middleware(['auth', 'throttle:6,1'])
            ->name('verification.send');
        Route::post('/code/resend', 'resendCode')
            ->middleware('auth')
            ->name('resend-code');
        Route::post('/code/verify', 'verifyUser')
            ->middleware('auth')
            ->name('verify-code');
    });

// MainController Routes
Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/about', 'about')->name('about');
    Route::get('/invest', 'invest')->name('invest');
    Route::match(['GET', 'POST'], '/contact', 'contact')->name('contact');
    Route::get('/language/{locale}', 'changeLanguage')->name('language.change');
    Route::get('/sitemap', 'sitemap')->name('sitemap');
    Route::post('/newsletter', 'newsletter')->name('newsletter');
});

Route::controller(DashboardController::class)
    ->middleware(['auth', 'myVerify', 'block', 'expired'])
    ->group(function () {
        Route::get('/dashboard', 'index')->name('home');
        Route::get('/transactions/history', 'transactions')->name('transactions');
        Route::get('/referrals', 'referrals')->name('referrals');
        Route::match(['GET', 'POST'], '/adverts', 'adverts')->name('adverts');
        Route::get('/video/thanks', 'thanks')->name('thanks');

        Route::middleware('hasWatchedVideos')
            ->prefix('video')
            ->group(function () {
                Route::get('/', 'video')->name('video');
                Route::post('/reward', 'rewardVideo')
                    ->middleware('throttle:5,60') //5 request per hour.
                    ->name('video-reward');
            });

        Route::get('/random/video', 'getRandomVideo');
    });

Route::controller(MomoController::class)
    ->middleware(['auth', 'myVerify', 'block', 'withdraw'])
    ->prefix('momo')
    ->group(function () {
        // Show payment pages
        Route::get('/{type}', 'show')->name('momo');
        // Process payments
        Route::post('/deposit', 'processDeposit')->name('momo-deposit');
        Route::post('/invest', 'processInvestment')->name('momo-invest');
        Route::middleware('throttle:5,10')->group(function () { //5 request per 10 minutes
            // Route::match(['GET', 'POST'], '/complete/withdrawal', 'processWithdrawal')->name('process-withdrawal');
            Route::post('/email/withdrawal', 'processWithdrawal')->name('momo-withdrawal');
        });
    });

Route::controller(AdminController::class)
    ->prefix('admin')
    ->middleware(['auth', 'myVerify', 'block', 'admin'])
    ->group(function () {
        Route::get('/users', 'users')->name('admin.users');
        Route::delete('/users/{id}', 'deleteUser')->name('user.delete');
        Route::patch('/users/{id}', 'blockUser')->name('user.block');
        Route::match(['GET', 'POST'], '/users/email', 'emailUsers')->name('admin.users.email');
    });

Route::controller(InvestmentController::class)
    ->prefix('investment')
    ->group(function () {
        Route::post('/details', 'calculate');
        Route::post('/plan', 'plan')->middleware(['auth'])->name('investment-plan');
    });
