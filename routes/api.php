<?php

use Illuminate\Http\Request;
use App\Webhr;

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

Route::group(['middleware' => 'auth:api'], function() {


});


  Route::get('webhrdata/{id}', function($username) {
    return Webhr::where('user_name',$username)->first();
});
