<?php

class Nacao extends Eloquent 
{

    protected $table = 'nacoes';

    protected $fillable = ['nome', 'abreviatura'];


    public function clubes()
    {
    	return $this->hasMany('Clube', 'nacao_id');
    }

}