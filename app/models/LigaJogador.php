<?php


class LigaJogador extends Eloquent
{
	protected $table = 'liga_jogadores';

	public static function jogadoresDisponiveis($liga_id)
	{

		$jogador = new Jogador;

		$listaJogadores = static::whereLigaId($liga_id)->lists('jogador_id');
		
		if ($listaJogadores) {

			$jogador->whereNotIn(
				'id',
				$listaJogadores
			);
		}

		return $jogador;
	
	}

}