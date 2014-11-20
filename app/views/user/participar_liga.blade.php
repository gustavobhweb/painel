@extends('layouts.defaultAuth')

@section('content')

{{ Form::hidden('liga_id', $liga->id) }}

<div class="wm-smooth-box">
<h3>Torneio {{{ $liga->nome }}}</h3>



{{ Form::open() }}
{{ Form::select('nacao_sistema_id', $paises, null, ['class' => 'form-control select-paises']) }}
{{ Form::hidden('clube_sistema_id', Input::old('clube_sistema_id'), ['id' => 'clube-id']) }}
<div id="clube-selecionado">
	@if(isset($clube))
		 <li data-id="<%= clube.id %>" class="list-group-item smooth-color">
		 	{{ $clube->nome }}
            <img class="pull-right" height="35" src='{{ URL::to("clubes/$clube->logo") }}' />
            <div class="clearfix"></div>
        </li>
	@endif
</div>


<ul class="list-group lista-jogadores"></ul>
<ul id="form-attach-players" class="list-group"></ul>
{{ Form::submit('Salvar', ['class' => 'btn btn-primary']) }}

{{ Form::close() }}


<div id="container-clubes"></div>

</div>



<script type="text/template" id="tpl-times">
<ul class="list-group lista-clubes">
    <% _.each(clubes, function(clube, i) {%>
        <li data-id="<%= clube.id %>" class="list-group-item smooth-color clube-item">
            <%- clube.nome.substring(0, 20) %>
            <img class="pull-right" height="35" src="{{ URL::to('clubes') }}/<%= clube.logo %>" />
            <div class="clearfix"></div>
        </li>
    <% });%>
    <div class='clearfix'></div>
</ul>
</script>


<script type="text/template" id="tpl-jogadores-listagem">
    <ul id="select-players-ajax" class="list-group">
        <% _.each(jogadores, function (jogador) { %>
            <li data-id="<%= jogador.id %>" class="list-group-item smooth-color">
                <%- jogador.nome %>
                <img src="<%= jogador.foto %>" />
            </li>
        <% }); %>
    </ul>
</script>

<script type="text/template" id="tpl-modal-jogadores">
    <form>
        <input type="text" id="autocomplete-jogadores" class='form-control' />
    </form>
    <div id="box-autocomplete-jogadores"></div>
</script>
@stop


@section('scripts')
{{ HTML::script('static/js/user/participar_liga.js') }}
@stop


@section('styles')
{{ HTML::style('static/css/user/participar_liga.css') }}
@stop
