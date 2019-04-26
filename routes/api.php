<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Login;
use App\Http\Middleware\Register;
use App\Http\Middleware\Token;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

Route::get('/getallcity',"CityController@getallcity");
Route::get('/cityuni/{id}', 'CityUniController@getcityuni');
Route::get("/complaint","ComplaintController@getcomplaint");
Route::get("/getblocklist","BlockedUserListController@getblocklist");
Route::get("/getblocklist/{id}","BlockedUserListController@getblocklist");


//Category
Route::get("/getcategory","CategoryController@getcategory");


//Category
Route::get("/tokentest/{token}","SessionController@read");


//register
Route::post("/register","RegisterController@addregister");
Route::post("/delregister","RegisterController@delregister");
Route::get("/getregister/{code}","RegisterController@getregister");
//register

//user
Route::post("/user","UserController@addnewuser");
Route::post("/userget","UserController@getuser");
//user


//usersavatar
Route::post("/setnewavatar","UsersAvatarController@addnewavatar");



//usersavatar

//login
Route::post("/Signin","LoginController@signin")->middleware(Login::class);;
Route::post("/Signout","LoginController@signout");
//login

//password
Route::post("/SetPassword","PasswordController@updateuserpass")->middleware(Token::class);
Route::post("/GetPassword","PasswordController@getuserpass")->middleware(Token::class);
//password


Route::post('/deneme', 'CityUniController@test');
Route::get('/test', 'TestController@index');
Route::post("/setav","UserController@test");


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
