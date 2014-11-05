<?php

class Jogador extends Eloquent {

    protected $table = 'jogadores_sistema';

    protected $fillable = [
    	'nome', 'apelido', 'dataNasc',
    	'nacao_sistema_id', 'foto', 'clube_sistema_id'
    ];

    public $timestamps = false;
}