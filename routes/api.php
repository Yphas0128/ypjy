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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

    Route::group(['prefix' => 'jwt','middleware'=>'admin_api_auth'], function () {
        Route::prefix('common')->group(function () {
            Route::post('register', 'JwtController@register');
            Route::post('login', 'JwtController@login');
            Route::post('getMenus','MenuController@menus');
        });
        Route::prefix('role')->group(function () {
            Route::post('getdata','RoleController@getdata');
            Route::post('del','RoleController@del');
            Route::post('gettree','RoleController@gettree');
            Route::post('rights','RoleController@rights');
            Route::post('options','RoleController@options');
        });

        Route::prefix('userc')->group(function () {
            Route::post('getdata','JwtController@getdata');
            Route::post('add','JwtController@add');
            Route::post('getsearch','JwtController@getsearch');
            Route::post('del','JwtController@del');
            Route::post('change','JwtController@change');
            Route::post('edit','JwtController@edit');
            Route::post('editrole','JwtController@editrole');
        });


        Route::prefix('menu')->group(function () {
            Route::post('getdata','MenuController@getdata');
            Route::post('getinfo','MenuController@getinfo');
            Route::post('add','MenuController@add');
        });

        Route::prefix('hook')->group(function () {
            Route::post('add','HookController@add');
            Route::post('getdata','HookController@getdata');
        });

       /*
        Route::post('menu/getdata','MenuController@getdata');
        Route::post('role/getdata','RoleController@getdata');
        Route::post('role/del','RoleController@del');
        Route::post('role/gettree','RoleController@gettree');
        Route::post('role/rights','RoleController@rights');
        Route::post('role/options','RoleController@options');*/

       /* Route::get('/', ['uses'=>'JwtController@index','middleware'=>'auth:apijwt']);editrole*/
    });