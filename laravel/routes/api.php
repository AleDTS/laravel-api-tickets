<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/tickets', 'TicketController@index')->name('tickets');

// Route::get('/tickets', 'TicketController@sortby');


// Route::group([], function(){
// 	Route::get('/tickets', 'TicketController@index');
// 	Route::get('/tickets', 'TicketController@sortby');
// });

// Route::get('/tickets/sortby={value}', 'TicketController@sortby');

// Route::get('/tickets/range/since={since}&until={until}', 'TicketController@range');
