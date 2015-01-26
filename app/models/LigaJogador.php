<?php


class LigaJogador extends Eloquent
{
    protected $table = 'liga_jogadores';

    protected $fillable = ['usuario_id', 'jogador_id', 'liga_id'];

    public $timestamps = false;

    private static $validations = [
        'usuario_id' => 'required|exists:usuarios,id',
        'liga_id'    => 'required|exists:ligas,id',
        'jogador_id' => 'required|exists:jogadores,id'
    ];

    private static $messages = [
        'required' => 'O campo :attribute é obrigatório',
        'exists'   => 'Dados incosistentes. O :attribute não existe no sistema.'
    ];

    public static function jogadoresDisponiveis($liga_id)
    {

        $jogador = Jogador::select('*');

        $listaJogadores = static::whereLigaId($liga_id)->lists('jogador_id');
        
        if ($listaJogadores) {
            $jogador->whereNotIn('id', $listaJogadores);
        }

        return $jogador;
    
    }


    public function jogador()
    {
        return $this->belongsTo('Jogador');
    }


    public static function validateInputs(array $inputs)
    {
        return Validator::make($inputs, static::$validations, static::$messages);
    }

}