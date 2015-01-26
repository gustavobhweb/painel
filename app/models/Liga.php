<?php

class Liga extends Eloquent {

    protected $table = 'ligas';

    public $timestamps = false;

    protected $fillable = ['nome', 'data_inicio', 'data_fim', 'info', 'logo'];


    public function pontuacoes()
    {
    	return $this->hasMany('Pontuacao', 'liga_id');
    }

}