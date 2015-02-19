<?php

class LigaUsuarioClube extends Eloquent 
{

    protected $table = 'liga_usuario_clube';

    protected $fillable = ['usuario_id', 'liga_id', 'clube_id'];


    protected static $validations = [
    	'usuario_id' => 'required|exists:usuarios,id',
    	'liga_id'	 => 'required|exists:ligas,id',
    	'clube_id'	=> 'required|exists:clubes,id'
   	];

   	protected static $messages = [
   		'required'	=> 'O campo :attribute é obrigatório.',
   		'exists'	=> 'O campo :attribute não existe'
   	];

    /**
    * Método reponsável por verificar se o usuário está participando de uma liga
    */
    public static function verificarParticipacao($liga_id = null)
    {	
    
        $usuario_id = Auth::user()->id;
        
    	$ligaUsuario = static::where('usuario_id', '=', $usuario_id);

        if (null !== $liga_id) {
            $ligaUsuario->whereLigaId($liga_id);
        }

        return (bool) $ligaUsuario->count();

    }


    public static function validateInputs(array $data)
    {
    	return Validator::make($data, static::$validations, static::$messages);
    }

    public function clube()
    {
        return $this->belongsTo('Clube', 'clube_id');
    }

    public function liga()
    {
        return $this->belongsTo('Liga', 'liga_id');
    }

    public function usuario()
    {
        return $this->belongsTo('User', 'usuario_id');
    }


}