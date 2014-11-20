@extends('layouts.defaultAdmin')


@section('content')
	<div class="col-xs-5 wm-smooth-box">

		<h3 class="text-center">Editar Liga</h3>

		{{ Form::model($liga, ['files' => true]) }}
		{{ Form::token() }}


		<div class="inputs-container">
		{{ Form::label('nome', 'Nome') }}
		{{ Form::text('nome', Input::old('nome'), ['class' => 'txt-default']) }}
		{{ $errors->first('nome') }}
		</div>

		<div class="inputs-container medium">
		{{ Form::label('dataInicio', 'Data Início') }}
		{{ Form::text('dataInicio', date('d/m/Y', strtotime($liga->dataInicio)), ['class' => 'txt-default']) }}
		{{ $errors->first('dataInicio')  }}
		</div>


		<div class="inputs-container medium">
		{{ Form::label('dataFim', 'Data Fim') }}
		{{ Form::text('dataFim', date('d/m/Y', strtotime($liga->dataFim)), ['class' => 'txt-default']) }}
		{{ $errors->first('dataFim')  }}
		</div>

		<div class="inputs-container">
		{{ Form::label('logo', 'Logo') }}
		{{ Form::file('logo') }}
		{{ $errors->first('logo')  }}
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