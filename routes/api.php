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

Route::get('/', 'SchemaController@handle')->name('schema');
Route::get('theme', 'ThemeController@handle');   
Route::apiResource('player', 'PlayerController');  
Route::post('game/{gameId}/theme/{themeId}', 'AttachController@theme'); 
Route::delete('game/{gameId}/theme/{themeId}', 'DetachController@theme'); 
Route::post('game/{gameId}/player/{playerId}', 'AttachController@player'); 
Route::delete('game/{gameId}/player/{playerId}', 'DetachController@player'); 
Route::get('game/{gameId}/player/{playerId}/question', 'QuestionController@handle'); 
Route::get('game/{gameId}/player/{playerId}/consequence', 'ConsequenceController@handle');  
Route::post('game/{gameId}/player/{playerId}/stage', 'StageController@handle');  
Route::apiResource('game', 'GameController'); 