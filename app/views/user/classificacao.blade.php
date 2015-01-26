@extends('layouts.defaultAuth')


@section('content')

<div class="col-xs-7 wm-smooth-box">
    <h3>Ligas</h3>
    <ul class="list-group">
    @foreach($ligas as $liga)

        <li class="list-group-item smooth-color">
        	<h4>{{{ $liga->nome }}}</h4>
            <a href="{{ URL::action('UserController@getVerJogos', [$liga->id]) }}">
                Resultado dos Jogos
            </a>
            |
            <a href="{{ URL::action('UserController@getPontuacao', [$liga->id]) }}">
                Pontuação
            </a>
        </li>
    @endforeach
    </ul>
</div>


@stop