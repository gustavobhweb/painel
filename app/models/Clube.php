<?php

class Clube extends Eloquent {

    protected $table = 'clubes_sistema';

    protected $fillable = ['nome', 'nacao_sistema_id', 'abreviatura'];

}