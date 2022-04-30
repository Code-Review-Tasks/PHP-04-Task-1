<?php

use App\Http\Controllers\ShortLinksController;
use App\Http\Controllers\ShortLinksRedirectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/links', [ShortLinksController::class, 'showList']);
Route::get('/links/{short_links}', [ShortLinksController::class, 'show']);
Route::post('/links', [ShortLinksController::class, 'store']);
Route::patch('/links/{short_links}', [ShortLinksController::class, 'update']);
Route::delete('/links/{short_links}', [ShortLinksController::class, 'destroy']);

Route::get('/get_link/{short_links:short_url}', [ShortLinksRedirectController::class, 'checkLink']);
