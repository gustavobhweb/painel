<?php

class Pontuacao extends Eloquent
{
	protected $table = 'pontuacoes';


	public function liga()
	{
		return $this->belongsTo('Liga', 'liga_id');
	}

	public function usuario()
	{
		return $this->belongsTo('User', 'usuario_id');
	}

	public function clube()
	{
		return $this->belongsTo('Clube', 'clube_id');
	}

	public function jogo()
	{
		return $this->belongsTo('Jogo', 'jogo_id');
	}
}