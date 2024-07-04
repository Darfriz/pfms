<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\LiabilitiesController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\DSRController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;

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
    $pageTitle = 'Welcome';
    return view('welcome', compact('pageTitle'));
});
 
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('users', [UserController::class, 'index']);


Route::middleware(['admin'])->group(function () {
    // Routes for administrators
    
   
});

// Other routes accessible to all users
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/assets', [AssetsController::class, 'index'])->name('assets');
Route::get('/liabilities', [LiabilitiesController::class, 'index'])->name('liabilities');

Route::get('/dsr', [DsrController::class, 'index'])->name('dsr'); // Debt Service Ratio route
Route::get('/property', [PropertyController::class, 'index'])->name('property');
Route::get('/investment', [InvestmentController::class, 'index'])->name('investment');

Route::get('/car', [CarController::class, 'index'])->name('car');
Route::get('/credit', [CreditController::class, 'index'])->name('credit');
Route::get('/personal', [PersonalController::class, 'index'])->name('personal');

Route::get('/policy', [PolicyController::class, 'index'])->name('policy');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/save-property', [PropertyController::class, 'saveProperty'])->name('save-property');
Route::post('/save-dsr', [DsrController::class, 'saveDsr'])->name('save-dsr');
Route::post('/save-investment', [InvestmentController::class, 'saveInvestment'])->name('save-investment');
Route::post('/save-Carliabilities', [CarController::class, 'saveCarLiabilities'])->name('save-CarLiabilities');
Route::post('/save-Personalliabilities', [PersonalController::class, 'savePersonalLiabilities'])->name('save-PersonalLiabilities');
Route::delete('/assets/{id}', [AssetsController::class, 'destroy'])->name('assets.destroy');
Route::delete('/liabilities/{id}', [LiabilitiesController::class, 'destroy'])->name('liabilities.destroy');
