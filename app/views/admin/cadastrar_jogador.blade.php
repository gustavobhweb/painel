@extends('layouts.defaultAdmin')

@section('content')

<div class="col-xs-5 wm-smooth-box">
    <h3 class="text-center">Cadastrar Jogador</h3>
    {{ Form::open(['autocomplete' => 'off', 'files' => true]) }}
    {{ Form::token() }}
    <div class="inputs-container">
    {{ Form::label('nome', 'Nome') }}
    {{ Form::text('nome', Input::old('nome'), ['class' => 'txt-default']) }}
    {{ $errors->first('nome') }}
    </div>

    <div class="inputs-container medium">
    {{ Form::label('apelido') }}
    {{ Form::text('apelido', Input::old('apelido'), ['class' => 'txt-default']) }}
    {{ $errors->first('apelido') }}
    </div>


    <div class="inputs-container medium">
    {{ Form::label('data_nascimento', 'Data de Nascimento') }}
    {{ Form::text('data_nascimento', Input::old('data_nascimento'), ['class' => 'txt-default', 'id' => 'data-nascimento']) }}
    {{ $errors->first('data_nascimento') }}
    </div>

    <div class='clearfix'></div>
    
    <div class="inputs-container medium">
    {{ Form::label('clube_id', 'Clube') }}
    {{ 
    	Form::select(
    		'clube_id',
    		['' => '(Selecione um clubes)'] + $clubes, Input::old('clube_id'),
    		['class' => 'txt-default']
    	) 
    }}
    {{ $errors->first('clube_id')  }}
    </div>

    <div class="inputs-container medium">
    {{ Form::label('nacao_id', 'Naturalidade') }}
    {{ 
    	Form::select(
    		'nacao_id',
    		['' => '(Selecione um país)'] + $nacoes, Input::old('nacao_id'),
    		['class' => 'txt-default']
    	) 
    }}
    {{ $errors->first('nacao_id')  }}
    </div>


    <div class="inputs-container medium">
    {{ Form::label('posicao_id', 'Posição em campo') }}
    {{ 
    	Form::select(
    		'posicao_id',
    		['' => '(Selecione uma posição)'] + $posicoes, Input::old('posicao_id'),
    		['class' => 'txt-default']
    	) 
    }}
    {{ $errors->first('posicao_id')  }}
    </div>

    <div class="inputs-container medium">
        {{ Form::label('foto', 'Foto') }}
        {{ Form::file('foto', ['id' => 'hidden-file', 'style' => 'display:none']) }}
        <div>
        {{ Form::button('selecionar foto ...', ['id' => 'fake-file-name', 'class' => 'btn btn-file']) }}
        </div>

        {{ $errors->first('foto')  }}
    </div>




    <div class="clearfix"></div>

    <div class="inputs-container text-right">
        {{ Form::button('Salvar', ['class' => 'btn-panel-1', 'type' => 'submit']) }}
    </div>
    {{ Form::close() }}

    @if(Session::has('message'))
    <div class="inputs-container">
        <div class="alert alert-success" style="opacity:0.7">{{ Session::get('message') }}</div>
    </div>
    @endif
</div>

@stop


@section('scripts')
{{ 
    HTML::script('static/js/admin/cadastrar_jogador.js'),
    HTML::script('static/js/jquery-ui.js'),
    HTML::script('static/js/jquery-ui-pt-br.js')
}}
@stop	

@section('styles')
{{ HTML::style('static/css/jquery-ui.min.css') }}
@stop

