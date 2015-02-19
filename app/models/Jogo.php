<?php

class Jogo extends Eloquent 
{

    protected $table = 'jogos';

    protected $fillable = ['liga_id', 'data_hora', 'gols_fora', 'gols_casa', 'usuario_id_fora', 'usuario_id_casa'];


    public function usuarioFora()
    {
    	return $this->belongsTo('User', 'usuario_id_fora');
    }

    public function usuarioCasa()
    {
    	return $this->belongsTo('User', 'usuario_id_casa');
    }

   
   	public function liga()
   	{
   		return $this->belongsTo('Liga', 'liga_id');
   	}


   	public function ligaUsuarioClubeCasa()
   	{
   		return $this->belongsTo('ligaUsuarioClube', 'usuario_id_casa', 'usuario_id');
   	}

    public function ligaUsuarioClubeFora()
    {
      return $this->belongsTo('ligaUsuarioClube', 'usuario_id_fora', 'usuario_id'); 
    }


    public function ligaUsuarioClube()
    {
        return $this->belongsTo('ligaUsuarioClube', 'liga_id'); 
    }


    public function pontuacao()
    {

        if ($this->gols_casa === $this->gols_fora) {

            $ponto = 1;
            
        } elseif ($jogo->usuario_id_casa === $auth->id) {

            if ($jogo->gols_casa > $jogo->gols_fora) {
                $ponto = 3;
            } else {
                $ponto = 0;
            }

        } else {

            if ($jogo->gols_fora > $jogo->gols_casa) {
                $ponto = 3;
            } else {
                $ponto = 0;
            }
        }


        $pontos[$jogo->id] = $ponto;
    }


}