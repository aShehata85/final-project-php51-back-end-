<?php

// we must define (DashboardController) by (use) syntax to apply the function without error
use Illuminate\Support\Facades\Route;
use App\Http\controllers\Admin\DashboardController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Laravel\Socialite\Facades\Socialite;

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
Route::group(['prefix' => LaravelLocalization::setLocale() , 
'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
] , function(){   
    Route::get('/', function(){
        return view('welcome');
    });


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();

    // $user->token
});

   
    
});
