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

    Route::any("/logout", [
        "as" => "user/logout",
        "uses" => "UserController@logoutAction"
    ]);
});