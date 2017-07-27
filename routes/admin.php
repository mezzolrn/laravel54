<?php


//管理后台
Route::group(['prefix' => 'admin'], function(){

	//登录展示页面
	Route::get('/login', '\App\Admin\Controllers\LoginController@index');
	//登录行为
	Route::post('/login', '\App\Admin\Controllers\LoginController@login');
	
	Route::group(['middleware' => 'auth:admin'], function(){

		//登出行为
		Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');
		
		//首页
		Route::get('/home', '\App\Admin\Controllers\HomeController@index');

		//管理人员模块
		Route::get('/users', '\App\Admin\Controllers\UserController@index');
		Route::get('/users/create', '\App\Admin\Controllers\UserController@create');
		Route::post('/users/store', '\App\Admin\Controllers\UserController@store');

		//审核模块
		Route::get('/posts', '\App\Admin\Controllers\PostController@index');
		Route::post('/posts/{post}/status', '\App\Admin\Controllers\PostController@status');
	});

});
