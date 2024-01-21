<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::fallback(function () {
    return response()->json(['error' => 'Not Found'], 404);
});

Route::get('/', function(){
    return response()->json(['message' => 'api v1.0.0']);
});

/**
 * Solution Routes
 */
Route::get('/bars', [App\Http\Controllers\BarsController::class, 'getAllBars']);
Route::get('/bars/{id}', [App\Http\Controllers\BarsController::class, 'getBarById'])->where('id', '[0-9]+');
Route::get('/search/bars-by-criteria', [App\Http\Controllers\BarsController::class, 'filterByCriteria']);
Route::post('/bar/add', [App\Http\Controllers\BarsController::class, 'addBar']);
Route::put('/bar/update/{id}', [App\Http\Controllers\BarsController::class, 'updateBar']);
Route::get('/visits', [App\Http\Controllers\VisitsController::class, 'getAllvisits']);
Route::get('/visits/{id}', [App\Http\Controllers\VisitsController::class, 'getVisitById'])->where('id', '[0-9]+');
Route::get('/search/filter-by-date', [App\Http\Controllers\VisitsController::class, 'filterByDateRange']);
Route::post('/visit/add', [App\Http\Controllers\VisitsController::class, 'addVisit']);
Route::put('/visit/update/{id}', [App\Http\Controllers\VisitsController::class, 'updateVisit']);