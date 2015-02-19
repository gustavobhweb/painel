<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	
	use UserTrait, RemindableTrait;
	
    protected $table = 'usuarios';
    
    protected $hidden = ['password', 'remember_token'];
    

    public static function isValidEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        list($user, $host) = explode("@", $email);

        if (!checkdnsrr($host, "MX") && !checkdnsrr($host, "A")) {
            return false;
        }
        
        return true;
    }

    public static function updateImage($fullpath)
    {
        $user = Auth::user();
        $user->img_fullpath = $fullpath;
        $user->save();
    }

    public function ligas()
    {
        return $this->belongsToMany('Liga', 'liga_usuario_clube', 'usuario_id');
    }

}