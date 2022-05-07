<?php

use App\Http\Controllers\ShortLinksController;
use App\Http\Controllers\ShortLinksRedirectController;
use App\Http\Controllers\StatisticController;
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
Route::get('/links/{shortLink:short_url}', [ShortLinksController::class, 'show']);
Route::post('/links', [ShortLinksController::class, 'store']);
Route::patch('/links/{shortLink:short_url}', [ShortLinksController::class, 'update']);
Route::delete('/links/{shortLink:short_url}', [ShortLinksController::class, 'destroy']);

Route::get('/get_link/{shortLink:short_url}', [ShortLinksRedirectController::class, 'checkLink']);
Route::get('/stats/', [StatisticController::class, 'getAllStats']);
Route::get('/stats/{shortLink:short_url}', [StatisticController::class, 'getLinkStats']);
