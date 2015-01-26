@extends('layouts.defaultAuth')


@section('content')



<section class="wm-smooth-box">

	<h3>Tabela de Pontuação</h3>

	@if($pontuacao->count())
	<table class="table" style="font-size:20px">
		<thead>
		<tr>
			<th colspan="2">Clube</th>
			<th>Usuário</th>
			<th>Pontos</th>

		</tr>
		</thead>
		<tbody>

			@foreach($pontuacao as $ponto)
			<tr>
				<td>
					<img 
						src='{{ URL::to("clubes/{$ponto->clube->logo}") }}' height="50" 
					/>
				</td>
				<td>{{ $ponto->clube->nome }}</td>
				<td>{{ $ponto->usuario->nome }}</td>
				<td>{{ $ponto->total_pontos }}</td>

			</tr>
			@endforeach
		</tbody>
	</table>

	@else
		<div>Nenhum jogo foi efetuado</div>
	@endif

</section>
@stop