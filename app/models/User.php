<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    protected $table = "usuarios";
    protected $hidden = ["password"];

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getReminderEmail()
    {
        return $this->email;
    }

    public function getRememberToken()
    {
        return $this->remenber_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

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