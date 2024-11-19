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
Route::get('about', [FrontendController::class, 'about'])->name('frontend.catalog');
Route::get('page/{slug}', [FrontendController::class, 'page'])->name('frontend.page');
Route::get('catalog/{slug?}', [FrontendController::class, 'catalog'])->name('frontend.catalog');
Route::get('product/{slug}', [FrontendController::class, 'product'])->name('frontend.product');
Route::get('product/{slug}/detected-gases', [FrontendController::class, 'detected_gases'])->name('frontend.product.detected_gases');
Route::get('services', [FrontendController::class,'servicesListing'])->name('frontend.services_listing');
Route::get('service/{slug}', [FrontendController::class,'service'])->name('frontend.service');
Route::get('contact', [FrontendController::class, 'contact'])->name('frontend.contact');
Route::get('application', [FrontendController::class,'application'])->name('frontend.application');
Route::post('send-application', [FrontendController::class,'sendApplication'])->name('frontend.send.application');
Route::get('album/{slug}', [FrontendController::class,'album'])->name('frontend.album');
Route::get('test', [FrontendController::class, 'test'])->name('frontend.test');



