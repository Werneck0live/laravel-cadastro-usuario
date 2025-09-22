<?php

Auth::routes();

route::group(['middleware' => 'auth'], function () {
	Route::resource('/painel/usuarios', 'Painel\UserController');	
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    Route::resource('/painel/usuarios', 'Painel\UserController');
    return Redirect::to('/painel/usuarios'); 
});

Route::get('/logout', function(){
   Auth::logout();
   return Redirect::to('login');
});