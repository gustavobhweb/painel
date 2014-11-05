<?php

Route::group(["before" => "guest"], function(){
    Route::any("/", [
        "as" => "user/login",
        "uses" => "UserController@loginAction"
    ]);
});

Route::group(["before" => "auth"], function(){
    Route::any("/home", [
        "as" => "user/home",
        "uses" => "UserController@homeAction"
    ]);

    Route::controller("user", "UserController");
});

Route::group(['before' => 'auth_admin'], function(){

    Route::any('/admin', [
        'as' => 'admin',
        'uses' => "AdminController@indexAction"
    ]);

    Route::controller('admin', 'AdminController');
});

Route::any("/logout", [
    "as" => "user/logout",
    "uses" => "UserController@logoutAction"
]);