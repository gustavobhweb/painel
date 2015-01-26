@extends('layouts.defaultAuth')


@section('content')

{{ Form::hidden('liga_id', $liga_id, ['id' => 'liga-id']) }}
{{ Form::token() }}


<div class="wm-smooth-box">

	<div class="pull-right text-center">
		<div><img height="70" src='{{ URL::to("clubes/{$liga->clube->logo}") }}' /></div>
		<i>{{ $liga->clube->nome }}</i>

	</div>

	<h3>Selecionar Jogadores</h3>

    <div class="clearfix"></div>
        @if(Session::has('fail'))
            <script>
                $(function(){
                    var failModal = new WmModal(null, {title: 'Alerta', width: 500});

                    failModal.setContent('Você deve selecionar 23 jogadores').open();
                })
            </script>
        @endif


	<div class="form-group">
		{{ 
			Form::text(
				'search',
				null,
				[
					'class' => 'form-control',
					'id' => 'pesquisar-jogadores',
					'placeholder' => 'Digite o nome do jogador desejado'
				]
			) 
		}}
	</div>

	<div id="container-jogadores"></div>

	{{ Form::open() }}

	<ul id="jogadores-listagem">
	@foreach($ligaJogadores as $jogador)
        <div data-id="{{ $jogador->jogador_id }}" class="player" href="#">
            <div class="text-right">
                <a class="close remove-player" href="#">&times;</a>
                <div class="clearfix"></div>
            </div>

             <div
                class="jogador-img-ajax" 
                style="background-image:url(/jogadores/{{ $jogador->jogador->foto }})" >
            </div>

            <table class="list-play-data">
                <tr>
                    <th>Nome</th>
                    <td>{{{ $jogador->jogador->nome }}}</td>
                </tr>
                <tr>
                    <th>Apelido</th>
                    <td>{{{ $jogador->jogador->apelido }}} </td>
                </tr>
                <tr>
                    <th>Posição</th>
                    <td>
                        {{ $jogador->jogador->posicao->nome }} 
                        - 
                        {{ $jogador->jogador->posicao->abreviacao }}
                    </td>
                </tr>
            </table>
            <div class='clearfix'></div>
        </div>

	@endforeach
	</ul>

	{{ Form::submit('Salvar', ['class' => 'btn wm-smooth-box']) }}

	{{ Form::close() }}
</div>


<script type="text/template" id="tpl-jogadores">
<div id="ajax-jogadores" class="list-group">
    <% _.each(jogadores, function (jogador) { %>
        <div data-id="<%= jogador.id %>" class="player" href="#">
            <div class="pull-right clearfix">
                <a class="close remove-player" href="#">&times;</a>
            </div>

        	 <div
                class="jogador-img-ajax" style="background-image:url(/jogadores/<%= jogador.foto %>)" 
                data-src="/jogadores/<%= jogador.foto %>">
            </div>

        	<table class="list-play-data">
        		<tr>
        			<th>Nome</th>
        			<td><%- jogador.nome %> </td>
        		</tr>
        		<tr>
        			<th>Apelido</th>
        			<td><%- jogador.apelido %> </td>
        		</tr>
        		<tr>
        			<th>Posição</th>
        			<td><%= jogador.posicao.abreviacao %></td>
        		</tr>
        	</table>
            <div class='clearfix'></div>
        </div>
    <% }); %>
</div>
</script>

@stop


@section('scripts')
 {{ HTML::script('static/js/user/selecionar_jogadores_liga.js') }}
@stop

@section('styles')

{{ Html::style('static/css/user/selecionar_jogadores_liga.css') }}

@stop


