<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupElementController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\AthleteController;
use App\Http\Controllers\GroupAthleteController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\StateElementController;

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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/musics", [MusicController::class, "show_all"]);

Route::get("/group_elements", [GroupElementController::class, "show_all"]);
Route::get("/athletes", [AthleteController::class, "show_all"]);
Route::get("/group_elements/{group_elements_id}", [GroupElementController::class, "show"]);
Route::get("/group_elements/{group_elements_id}/levels", [LevelController::class, "show_all"]);
Route::get("/group_elements/{group_elements_id}/levels/{levels_id}/elements", [ElementController::class, "show_all"]);
Route::get("/group_elements/{group_elements_id}/levels/{levels_id}", [LevelController::class, "show"]);
Route::get("/group_elements/{group_elements_id}/levels/{levels_id}/elements/{elements_id}/variations", [VariationController::class, "show_all"]);
Route::get("/group_elements/{group_elements_id}/levels/{levels_id}/elements/{elements_id}", [ElementController::class, "show"]);

Route::post("/state_element", [StateElementController::class, "update"]);
Route::post("/newGroupElement", [GroupElementController::class, "store"]);
Route::post("/newAthlete", [AthleteController::class, "store"]);
Route::post("/newLevel", [LevelController::class, "store"]);
Route::post("/newElement", [ElementController::class, "store"]);
Route::post("/newVariation", [VariationController::class, "store"]);

Route::post("/athlete/{id}", [AthleteController::class, "update"]);








