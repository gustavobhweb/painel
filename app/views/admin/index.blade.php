@extends('layouts.defaultAdmin')


@section('sidebar')
@if(isset($ligas) && $ligas->count())
    <h3 class="text-muted">Ligas Cadastradas</h3>
    <ul class="list-group">
        @foreach($ligas as $liga)
        <li class="list-group-item" title="{{{ $liga->info }}}"> 
            <a href="{{ URL::to('admin/editar-liga', [$liga->id]) }}" >
                {{{ $liga->nome }}}
            </a>
        </li>
        @endforeach
    </ul>
@endif
@stop

@section('content')
    <div class="col-xs-5 wm-smooth-box">
        <h3 class="text-center">Cadastrar Nova Liga</h3>
        {{ Form::open() }}
        {{ Form::token() }}
        <div class="inputs-container">
        {{ Form::label('nome', 'Nome') }}
        {{ Form::text('nome', Input::old('nome'), ['class' => 'txt-default']) }}
        {{ $errors->first('nome') }}
        </div>

        <div class="inputs-container medium">
        {{ Form::label('dataInicio', 'Data Início') }}
        {{ Form::text('dataInicio', Input::old('dataInicio'), ['class' => 'txt-default']) }}
        {{ $errors->first('dataInicio')  }}
        </div>
        <div class="inputs-container medium">
        {{ Form::label('dataFim', 'Data Fim') }}
        {{ Form::text('dataFim', Input::old('dataFim'), ['class' => 'txt-default']) }}
        {{ $errors->first('dataFim')  }}
        </div>

        <div class="inputs-container">
            {{ Form::label('info', 'Informações da liga') }}
            {{ Form::textarea('info', Input::old('info'), ['class' => 'txt-default']) }}
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


@section('styles')

@stop