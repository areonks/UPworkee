<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\VacancyResponseController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['prefix' => 'vacancies'], function () {
    Route::get('', [JobVacancyController::class, 'index']);
    Route::get('/{jobVacancy}', [JobVacancyController::class, 'show']);
});


Route::middleware('auth:sanctum')->group( function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/likedUsersVacancies', [JobVacancyController::class, 'likedUsersVacancies']);
    Route::get('/likedVacancies', [JobVacancyController::class, 'likedVacancies']);

    Route::group(['prefix' => 'vacancies'], function () {
        Route::post('', [JobVacancyController::class, 'store']);
        Route::put('/{jobVacancy}', [JobVacancyController::class, 'update'])->middleware('can:update,jobVacancy');
        Route::delete('/{jobVacancy}', [JobVacancyController::class, 'destroy'])->middleware('can:destroy,jobVacancy');
        Route::post('/{jobVacancy}/like', [JobVacancyController::class, 'addLike']);
        Route::post('/{jobVacancy}/unlike', [JobVacancyController::class, 'removeLike']);

        Route::group(['prefix' => '/{jobVacancy}/responses'], function () {
            Route::get('', [VacancyResponseController::class, 'index']);
            Route::post('', [VacancyResponseController::class, 'store']);
        });

    });

    Route::group(['prefix' => '/responses'], function () {
        Route::put('/{vacancyResponse}', [VacancyResponseController::class, 'update'])->middleware('can:update,vacancyResponse');
        Route::delete('/{vacancyResponse}', [VacancyResponseController::class, 'destroy'])->middleware('can:destroy,vacancyResponse');
        Route::post('/{vacancyResponse}/like', [VacancyResponseController::class, 'addLike']);
        Route::post('/{vacancyResponse}/unlike', [VacancyResponseController::class, 'removeLike']);

    });

});
