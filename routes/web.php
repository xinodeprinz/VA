<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\MomoController;
use App\Http\Controllers\User\PayPalController;
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

Route::get('/register/{referral?}', [RegisterController::class, 'showRegistrationForm']);

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
    });

// MainController Routes
Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/about', 'about')->name('about');
    Route::get('/plans', 'plans')->name('plans');
    Route::match(['GET', 'POST'], '/contact', 'contact')->name('contact');
    Route::get('/terms-and-conditions', 'terms')->name('terms');
    Route::post('/currency', 'currency')->name('currency');
});

Route::controller(DashboardController::class)
    ->middleware(['auth', 'verified', 'block'])
    ->group(function () {
        Route::get('/dashboard', 'index')->name('home');
        Route::get('/history/deposit', 'depositHistory')->name('deposit-history');
        Route::get('/history/withdrawal', 'withdrawalHistory')->name('withdrawal-history');
        Route::get('/referrals', 'referrals')->name('referrals');
        Route::match(['GET', 'POST'], '/adverts', 'adverts')->name('adverts');

        Route::middleware('hasClickedAds')->group(function () {
            Route::get('/ads', 'ads')->name('ads');
            Route::post('/ads', 'toShowAd')->name('ads');
            Route::get('/ads/{id}', 'showAd')->name('show-ad');
            Route::post('/process-ad', 'processAd')->name('process-ad');
        });

        Route::middleware('advert')->group(function () {
            Route::match(['GET', 'POST'], '/advert/create', 'createAdvert')->name('create-advert');
            Route::post('/upload/image', 'uploadImage')->name('image-upload');
        });
    });

Route::controller(MomoController::class)
    ->middleware(['auth', 'verified', 'block'])
    ->prefix('mobile-money')
    ->group(function () {
        // Show payment pages
        Route::get('/deposit', 'deposit')->name('momo-deposit');
        Route::get('/withdrawal', 'withdrawal')->name('momo-withdrawal');
        Route::get('/plan', 'plan')->name('momo-plan');
        // Process payments
        Route::post('/deposit', 'processDeposit')->name('momo-deposit');
        Route::post('/withdrawal', 'processWithdrawal')->name('momo-withdrawal');
        Route::post('/plan', 'processPlan')->name('momo-plan');
    });

Route::controller(PayPalController::class)
    ->middleware(['auth', 'verified', 'block'])
    ->prefix('paypal')
    ->group(function () {
        // Show payment pages
        Route::get('/deposit', 'deposit')->name('paypal-deposit');
        Route::get('/withdrawal', 'withdrawal')->name('paypal-withdrawal');
        Route::get('/plan', 'plan')->name('paypal-plan');

        // Process payments
        Route::post('/deposit', 'processDeposit')->name('paypal-deposit');
        Route::post('/withdrawal', 'processWithdrawal')->name('paypal-withdrawal');
        Route::post('/plan', 'processPlan')->name('paypal-plan');

        Route::get('/success/{type}', 'success')->name('success');
        Route::get('/error/{type}', 'getError')->name('error');
    });

Route::controller(PlanController::class)
    ->middleware(['auth', 'verified', 'block'])
    ->group(function () {
        Route::post('/buy-plan', 'buyPlan')->name('buy-plan');
    });

Route::controller(AdminController::class)
    ->prefix('admin')
    ->middleware(['auth', 'verified', 'block', 'admin'])
    ->group(function () {
        Route::get('/users', 'users')->name('admin.users');
        Route::delete('/users/{id}', 'deleteUser')->name('user.delete');
        Route::patch('/users/{id}', 'blockUser')->name('user.block');
        Route::get('/ads', 'ads')->name('admin.ads');
        Route::delete('/ads/{id}', 'deleteAd')->name('ad.delete');
    });