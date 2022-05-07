<?php

use App\Http\Controllers\DeleteLink;
use App\Http\Controllers\GetLinks;
use App\Http\Controllers\GetLinkStats;
use App\Http\Controllers\GetStats;
use App\Http\Controllers\GoByLink;
use App\Http\Controllers\PatchLink;
use App\Http\Controllers\PostLinks;
use App\Models\Link;
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

Route::view('/', 'index');

Route::get('links', GetLinks::class);
Route::get('links/{hash}', fn(string $hash) => Link::with('tags')->byHash($hash)->firstOrFail());
Route::post('links', PostLinks::class);
Route::patch('links/{hash}', PatchLink::class);
Route::delete('links/{hash}', DeleteLink::class);

Route::get('stats', GetStats::class);
Route::get('stats/{hash}', GetLinkStats::class);

Route::get('l/{hash}', GoByLink::class);
