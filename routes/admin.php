<?php

// we must define (DashboardController) by (use) syntax to apply the function without error
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\controllers\Admin\ProductController;
use App\Http\controllers\Admin\UserController;
use App\Http\controllers\Admin\DashboardController;


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
    Route::middleware(['auth' , 'isadmin'])->prefix('admin')->group(function(){

        // we call the controller by following method, i.e, we put functions in functions place (like controller)
        // and put only in routing only the (uri) stuff 
        Route::get('/' , [DashboardController::class , 'index'])->name('dashboard');
    
        // the following is to write one single command to resource all in one line. 
        Route::resource('user' , UserController::class);
        Route::get('/user/{id}/posts' , [UserController::class , 'showPost'])->name('user.post');
        Route::resource('product' , ProductController::class);
        Route::resource('category' , CategoryController::class);
    });
});
