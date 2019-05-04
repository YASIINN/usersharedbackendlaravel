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

//Product
Route::post("/addnewproduct","ProductController@add")->middleware(Token::class);
Route::post("/getproduct","ProductController@getproduct")->middleware(Token::class);
Route::post("/productdetail","ProductController@getproductdetail")->middleware(Token::class);
Route::post("/delproduct","ProductController@softdelete")->middleware(Token::class);
Route::post("/updateproduct","ProductController@update")->middleware(Token::class);
//Product


//middle table
Route::post("/addprphotos","ProductPhotoController@add");
Route::post("/getphotos","ProductPhotoController@getproductphoto");
Route::post("/delproductphotos","ProductPhotoController@delproductphotos");
//middle table

//ProductUser

Route::post("/addproductuser","UserProductController@add");

//ProductUser


//PrPhoto
Route::post("/addnewphoto","PhotoController@addphoto");
Route::post("/updatephoto","PhotoController@update");
//PrPhoto

//FavProduct
Route::get("/favcount/{prid}","FavProductController@favprcount");

//FavProduct
Route::post("/isuserproduct","UserProductController@get")->middleware(Token::class);


//Comment
Route::post("/addcomment","CommentAndStarController@add")->middleware(Token::class);

//Comment
