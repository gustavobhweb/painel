<?php

class Liga extends Eloquent {

    protected $table = 'ligas';

    public $timestamps = false;

    protected $fillable = ['nome', 'data_inicio', 'data_fim', 'info', 'logo'];


    public function pontuacoes()
    {
    	return $this->hasMany('Pontuacao', 'liga_id');
    }

    public function usuarios()
    {
    	return $this->belongsToMany('User', 'liga_usuario_clube', 'liga_id', 'usuario_id')
                    ->withPivot('clube_id', 'ativo');
    }

    public function clubes()
    {
        return $this->belongsToMany('Clube', 'liga_usuario_clube')
                    ->withPivot('usuario_id', 'ativo');
    }


}