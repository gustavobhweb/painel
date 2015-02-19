@extends('layouts.defaultAuth')
{{ error_reporting(0) }}
@section('content')

<div class="wm-smooth-box">
<ul class="list-group" id="placar">

	<h3 class="text-center">Resultados - {{ $liga->nome or '--' }}</h3>

 	@foreach($pontuacao as $ponto)
		
		<li class="list-group-item smooth-color"> 	

			<div class="resultado">
				<img 
		 			src='{{ URL::to("clubes/{$ponto->jogo->ligaUsuarioClubeCasa->clube->logo}") }}'
		 			height="50"
		 		/>

	 			{{ $ponto->jogo->ligaUsuarioClubeCasa->clube->abreviatura or 'Error' }}
	 			
	 			<span class="number">{{ $ponto->jogo->gols_casa }}</span>

	 			X 

	 			<span class="number">{{ $ponto->jogo->gols_fora }}</span>
	 			
	 			{{ $ponto->jogo->ligaUsuarioClubeFora->clube->abreviatura or 'Error' }}
	 			<img 
	 				src='{{ URL::to("clubes/{$ponto->jogo->ligaUsuarioClubeFora->clube->logo}") }}'
	 				height="50"
	 			/>
	 		</div>

	 		<br>
	 		<div class="text-right">
	 		Data do Jogo: {{ $ponto->jogo->updated_at->format('d/m/Y H:i') }}
	 		</div>

	 		
	 	</li>

 	@endforeach



 </ul>


 <div class="text-right">
 Pontos: {{ $pontuacaoTotal }}
 </div>
 
 </div>




@stop


@section('styles')
{{ HTML::style('static/css/user/ver_liga.css') }}
@stop
