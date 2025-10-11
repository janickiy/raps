<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;


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

Route::get('', [FrontendController::class, 'index'])->name('frontend.index');
Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/pages/{slug}', [FrontendController::class, 'page'])->name('frontend.pages');
Route::get('/news', [FrontendController::class, 'news'])->name('frontend.news');
Route::get('/news/{slug}', [FrontendController::class, 'openNews'])->name('frontend.open_news');
Route::get('/catalog/{slug?}', [FrontendController::class, 'catalog'])->name('frontend.catalog');
Route::get('/product/{slug}', [FrontendController::class, 'product'])->name('frontend.product');
Route::get('/contact', [FrontendController::class,'contact'])->name('frontend.contact');
Route::post('/send-msg', [FrontendController::class,'sendMsg'])->name('frontend.send_msg');
Route::get('/converter', [FrontendController::class,'converter'])->name('frontend.converter');
Route::get('/application', [FrontendController::class,'application'])->name('frontend.application');
Route::post('/send-application', [FrontendController::class,'sendApplication'])->name('frontend.send.application');
Route::post('/gaz-convert', [FrontendController::class,'gazСonvert'])->name('frontend.gaz_convert');



