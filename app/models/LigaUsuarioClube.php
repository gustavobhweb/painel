<?php

class LigaUsuarioClube extends Eloquent {

    protected $table = 'liga_usuario_clube';

    /**
    * Método reponsável por verificar se o usuário está participando de uma liga
    */
    public static function verificarParticipacao()
    {	
    	return static::where('usuario_id', '=', Auth::user()->id)->count();
    }

}