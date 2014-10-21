<?php

Route::filter("auth", function()
{
	$auth = Auth::user();

	if (Auth::guest()) {
		return Redirect::route('user/login');
	} elseif (Auth::check() && $auth->tipo_id == 1) {
		return Redirect::route('admin');
	} elseif (Auth::check() && $auth->tipo_id == 2) {
		return Redirect::route('user/home');
	}
});

Route::filter("guest", function()
{
	if (Auth::check()) {
		return Redirect::route('user/home');
	}
});

Route::filter('auth_admin', function()
{
	/**
		* Se tentar acessar o admin, não tendo autorização, o usuário é advertido com um erro 403
	*/
	if (Auth::guest() || Auth::check() && Auth::user()->tipo_id != 1) {
		return Response::view('errors.403');
	}
});

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token')) {
		throw new Illuminate\Session\TokenMismatchException;
	}
});
