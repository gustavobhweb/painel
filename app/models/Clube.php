<?php

class Clube extends Eloquent {

    protected $table = 'clubes';

    protected $fillable = ['nome', 'nacao_id', 'abreviatura'];

}