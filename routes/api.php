<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

//import the controller
use App\Http\Controllers\API\APIcontroller;

Route::post('/login',[APIcontroller::class,'login']);
Route::post('/register',[APIcontroller::class,'register']);

Route::group([
    "middleware"=>['auth:api']
],function(){
    Route::get('/profile',[APIcontroller::class,'profile']);
    Route::get('/logout',[APIcontroller::class,'logout']);
});