<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get("/", "SchemaController@handle")->name('schema');
Route::get("theme", "ThemeController@handle"); 
Route::post("player", "PlayerController@create"); 
Route::put("player/{player}", "PlayerController@update"); 
Route::post("stage", "StageController@create"); 
Route::put("stage/{stage}", "StageController@update"); 
Route::get("game/{gameId}/player/{playerId}/question", "QuestionController@handle"); 
Route::get("game/{gameId}/player/{playerId}/consequence", "ConsequenceController@handle");  
Route::apiResource("game", "GameController"); 