@extends('layouts.defaultAdmin')

@section('content')
	<div class="col-xs-5 center-block">

		{{ Form::open() }}
		{{ Form::label('nome', 'Nome') }}
		{{ Form::text('nome', Input::old('nome'), ['class' => 'form-control']) }}

		<div class="pull-left">
		{{ Form::label('dataInicio', 'Data Início') }}
		{{ Form::text('dataInicio', Input::old('nome'), ['class' => 'form-control']) }}
		</div>
		<div class="pull-left col-sm-offset-1">
		{{ Form::label('dataFim', 'Data Fim') }}
		{{ Form::text('dataFim', Input::old('nome'), ['class' => 'form-control']) }}
		</div>
		{{ Form::close() }}
	</div>

@stop