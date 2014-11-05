@extends('layouts.defaultAuth')

@section('styles')
	{{ HTML::style('static/css/home.css') }}
@stop

@section('scripts')
	{{ HTML::script('static/js/home.js') }}
@stop

@section('content')
	@if(!$verificarParticipacao)
		<div id='sugestaoParticipacao'>
			<p>{{{ explode(' ', Auth::user()->nome)[0] }}}, você não está participando de nenhuma liga.</p>
			<a class='btn btn-success' href="{{ URL::to('user/participar-liga') }}">
				<i class='glyphicon glyphicon-ok'></i> Participar de uma liga
			</a>
		</div><!-- .sugestaoParticipacao -->
	@endif
@stop