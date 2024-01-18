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
Route::get('catalog', [FrontendController::class, 'catalog'])->name('frontend.catalog');
Route::get('product-listing/{slug}', [FrontendController::class, 'productListing'])->name('frontend.product_listing');
Route::get('certificates', [FrontendController::class, 'certificates'])->name('frontend.certificates');
Route::get('contact', [FrontendController::class, 'contact'])->name('frontend.contact');


