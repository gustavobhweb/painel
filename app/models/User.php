<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	
	use UserTrait, RemindableTrait;
	
    protected $table = 'usuarios';
    
    protected $hidden = ['password'];
    

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

}