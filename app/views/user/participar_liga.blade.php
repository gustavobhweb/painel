@extends('layouts.defaultAuth')

@section('content')

{{ Form::hidden('liga_id', $liga->id) }}

<div class="wm-smooth-box">

<h3>Torneio {{{ $liga->nome }}}</h3>

{{ Form::open() }}

{{ $errors->first('message', '<div>:message</div>') }}

{{ 
    Form::select(
        'nacao_sistema_id',
        $paises,
        Input::old('nacao_sistema_id'),
        ['class' => 'form-control select-paises']
    )
}}

{{ $errors->first('nacao_sistema_id', '<div>:messages</div>') }}

{{ 
    Form::hidden(
        'clube_sistema_id',
        Input::old('clube_sistema_id'),
        ['id' => 'clube-id']
    ) 
}}
<div id="clube-selecionado">
	@if(Session::has('clube'))
		 <li data-id="{{ Session::get('clube.id') }}" class="list-group-item smooth-color">
		 	{{ Session::get('clube.nome') }}
            <img class="pull-right" height="35" src="{{ URL::to('clubes/' . Session::get('clube.logo')) }}" />
            <div class="clearfix"></div>
        </li>
	@endif
</div>

{{ $errors->first('clube_sistema_id', '<div>:message</div>') }}

{{ Form::submit('Salvar', ['class' => 'btn wm-smooth-box']) }}



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

@stop


@section('scripts')
{{ HTML::script('static/js/user/participar_liga.js') }}
@stop


@section('styles')
{{ HTML::style('static/css/user/participar_liga.css') }}
@stop
