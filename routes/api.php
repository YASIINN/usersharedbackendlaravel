<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Login;
use App\Http\Middleware\Register;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

Route::get('/getallcity',"CityController@getallcity");
Route::get('/cityuni/{id}', 'CityUniController@getcityuni');
Route::get("/complaint","ComplaintController@getcomplaint");
Route::get("/getblocklist","BlockedUserListController@getblocklist");
Route::get("/getblocklist/{id}","BlockedUserListController@getblocklist");
Route::get("/getcategory","CategoryController@getcategory");


//register
Route::post("/register","RegisterController@addregister");
Route::post("/delregister","RegisterController@delregister");
Route::get("/getregister/{code}","RegisterController@getregister");
//register


Route::post("/user","UserController@addnewuser");
Route::post("/userget","UserController@getuser");
Route::post("/Signin","LoginController@signin")->middleware(Login::class);;



Route::post('/deneme', 'CityUniController@test');
Route::get('/test', 'TestController@index');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
