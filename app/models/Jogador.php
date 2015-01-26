<?php

class Jogador extends Eloquent 
{

    protected $table = 'jogadores';

    protected $fillable = [
    	'nome',
        'apelido',
        'data_nascimento',
    	'nacao_id',
        'foto',
        'posicao_id'
    ];

    public $timestamps = false;


    public function posicao()
    {
    	return $this->belongsTo('Posicao', 'posicao_id');
    }


}