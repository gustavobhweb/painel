<?php

class Liga extends Eloquent {

    protected $table = 'ligas';

    public $timestamps = false;

    protected $fillable = ['nome', 'dataInicio', 'dataFim', 'info', 'logo'];

}