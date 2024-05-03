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
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TopicalityController;

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


Route::get("/accounts", [AccountController::class, "show_all"]);
Route::post("/verify", [AccountController::class, "verify"]);


Route::get("/topicalities", [TopicalityController::class, "show_all"]);
Route::get("/musics", [MusicController::class, "show_all"]);
Route::get("/group_elements", [GroupElementController::class, "show_all"]);
Route::get("/athletes", [AthleteController::class, "show_all"]);
Route::get("/group_elements/{group_elements_id}/levels", [LevelController::class, "show_all"]);
Route::get("/group_elements/{group_elements_id}/levels/{levels_id}/elements", [ElementController::class, "show_all"]);
Route::get("/group_elements/{group_elements_id}/levels/{levels_id}/elements/{elements_id}/variations", [VariationController::class, "show_all"]);


Route::get("/topicality/{topic_id}", [TopicalityController::class, "show"]);
Route::get("/group_elements/{group_element_id}", [GroupElementController::class, "show"]);
Route::get("/levels/{level_id}", [LevelController::class, "show"]);
Route::get("/elements/{element_id}", [ElementController::class, "show"]);
Route::get("/variations/{variation_id}", [VariationController::class, "show"]);

Route::post("/newGroupElement", [GroupElementController::class, "store"]);
Route::post("/newAthlete", [AthleteController::class, "store"]);
Route::post("/newLevel", [LevelController::class, "store"]);
Route::post("/newElement", [ElementController::class, "store"]);
Route::post("/newVariation", [VariationController::class, "store"]);
Route::post("/newMusic", [MusicController::class, "store"]);
Route::post("/newAccount", [AccountController::class, "store"]);
Route::post("/newTopicality", [TopicalityController::class, "store"]);

Route::post("/state_element", [StateElementController::class, "update"]);
Route::post("/athlete/{id}", [AthleteController::class, "update"]);
Route::post("/topicality/{id}", [TopicalityController::class, "update"]);
Route::post("/technic/{id}", [GroupElementController::class, "update"]);
Route::post("/level/{id}", [LevelController::class, "update"]);
Route::post("/element/{id}", [ElementController::class, "update"]);
Route::post("/variation/{id}", [VariationController::class, "update"]);


Route::delete("/del_topicality/{id}", [TopicalityController::class, "delete"]);
Route::delete("/del_athlete/{id}", [AthleteController::class, "delete"]);
Route::delete("/del_technic/{id}", [GroupElementController::class, "delete"]);
Route::delete("/del_level/{id}", [LevelController::class, "delete"]);
Route::delete("/del_element/{id}", [ElementController::class, "delete"]);
Route::delete("/del_variation/{id}", [VariationController::class, "delete"]);








