@extends('layouts.defaultAdmin')


@section('content')

<div class="col-xs-5 wm-smooth-box">
    <h3 class="text-center">Cadastrar Clube</h3>
    {{ Form::open() }}
    {{ Form::token() }}
    <div class="inputs-container">
    {{ Form::label('nome', 'Nome') }}
    {{ Form::text('nome', Input::old('nome'), ['class' => 'txt-default']) }}
    {{ $errors->first('nome') }}
    </div>

    <div class="inputs-container medium">
    {{ Form::label('abreviatura', 'Abreviatura') }}
    {{ Form::text('abreviatura', Input::old('abreviatura'), ['class' => 'txt-default']) }}
    {{ $errors->first('abreviatura') }}
    </div>
    <div class="inputs-container medium">
    {{ Form::label('nacao_sistema_id', 'Nação Sistema') }}
    {{ Form::select('nacao_sistema_id', ['' => '(Selecione um país)'] + $nacoes, Input::old('nacao_sistema_id'), ['class' => 'txt-default']) }}
    {{ $errors->first('nacao_sistema_id')  }}
    </div>

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